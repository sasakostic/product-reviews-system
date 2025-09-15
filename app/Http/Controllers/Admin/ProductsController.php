<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image as ImageProcessor;
use App\Http\Controllers\Admin\SettingsController as Settings;
use Illuminate\Http\Request;

use Input;
use View;
use Auth;
use Redirect;
use DB;
use Carbon\Carbon;
use Response;
use Session;

use Illuminate\Support\Str;

use File;

use App\Product;
use App\Image;
use App\Review;
use App\Category;
use App\Brand;
use App\User;
use App\ReportedProduct;

class ProductsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['postUnflag']]);
        $this->middleware('isAdmin');        
        $this->middleware('AjaxAuth', ['only' => ['postUnflag']]);
    }
    
    public function index() 
    {

        Settings::set('new_products_since',  Carbon::now());
        
        if (Input::has('name')) {
            $name = Input::get('name');
            $products_query = Product::where('name', 'LIKE', '%' . $name . '%')
            ->orderBy('id', 'DESC');
        } 
        else {
            $products_query = Product::orderBy('id', 'DESC');
        }
        
        if (Input::has('brand_id')) {
            $brand_id = Input::get('brand_id');
            $products_query->where('brand_id', '=', $brand_id);            
        }

        if (Input::has('category_id')) {
            $category_id = Input::get('category_id');
            $products_query->where('category_id', '=', $category_id);            
        }

        if (Input::has('status')) {
            if(Input::get('status') == 'discontinued')
                $products_query->where('discontinued', '=', 1);
            else
                $products_query->where('active', '=', Input::get('status'));
        }

        if (Input::has('reported')) {
            $products_query->where('reported', '=', Input::get('reported'));             
        }

        if (Input::has('id')) {
            $id = Input::get('id');
            $products_query->where('id', '=', $id);            
        }

        
        $categories = Category::all();
        $brands = Brand::all();

        $products = $products_query->paginate(app('settings')->admin_products_pagination);

        return view('admin/products/index', compact(
            'products',
            'categories', 
            'brands'));
    }

    public function getSearch()
    {
        if (Input::has('name')) {
            $name = Input::get('name');
            $products_query = Product::where('name', 'LIKE', '%' . $name . '%')
            ->orderBy('id', 'DESC');
        } 
        else {
            $products_query = Product::orderBy('id', 'DESC');
        }
        
        if (Input::has('brand_id')) {
            $brand_id = Input::get('brand_id');
            $products_query->where('brand_id', '=', $brand_id);            
        }

        if (Input::has('category_id')) {
            $category_id = Input::get('category_id');
            $products_query->where('category_id', '=', $category_id);            
        }

        if (Input::has('status')) {
            if(Input::get('status') == 'discontinued')
                $products_query->where('discontinued', '=', 1);
            else
                $products_query->where('active', '=', Input::get('status'));
        }
        
        if (Input::has('reported')) {
            $products_query->where('reported', '=', Input::get('reported'));             
        }

        if (Input::has('id')) {
            $id = Input::get('id');
            $products_query->where('id', '=', $id);            
        }

        
        $categories = Category::all();
        $brands = Brand::all();

        $products = $products_query->paginate(app('settings')->admin_products_pagination);

        return view('admin/products/index', compact(
            'products',
            'categories', 
            'brands'));
    }
    
    public function create()
    {

        $categories = Category::all();
        $brands = Brand::all();

        return view('admin/products/create', compact(
            'categories',
            'brands'));
    }

    public function store(Request $request) {

        $this->validate($request, ['name' => 'required|min:1|unique:products']);

        $alert_type = 'success';
        $alert_message = 'Product added';
        
        try {
            $new_product = new Product();
            $new_product->name = Input::get('name');
            $new_product->slug = Input::get('slug');
            if (Input::get('slug') == '') {
                $new_product->slug = str_slug(Input::get('name'), '-');
            }
            $new_product->description = Input::get('description');
            $new_product->category_id = Input::get('category_id');
            $new_product->brand_id = Input::get('brand_id');
            if (Input::has('active')) $new_product->active = Input::get('active');
            else $new_product->active = 0;
            $new_product->affiliate_code = Input::get('affiliate_code');
            if(Input::has('discontinued'))
                $new_product->discontinued = Input::get('discontinued');
            else $new_product->discontinued = 0;   
            $new_product->save();
            
            $this->uploadImages($new_product->id);            
        }
        catch(\Exception $e) {
            $alert_type = 'error';
            $alert_message = 'Error adding product';
        }
        
        if(Input::get('save') == 'save_and_new')
            return redirect('admin/products/create')->with($alert_type, $alert_message . '. Add new one bellow')->with('menu_highlight', 'menu_products');
        else 
            return redirect('admin/products/' . $new_product->id . '/edit')->with($alert_type, $alert_message)->with('menu_highlight', 'menu_products');
    }

    public function edit($id) 
    {
        try {
            $product = Product::find($id);

            $brands = Brand::orderBy('name', 'ASC')->where('id', '>', 1)->lists('name', 'id')->all();
            $brands_all = array();
            $brand_unspec = [1 => Brand::find(1)->name];
            $brands = $brands_all + $brands + $brand_unspec;

            $categories = Category::orderBy('name', 'ASC')->where('id', '>', 1)->lists('name', 'id')->all();
            $categories_all = array();
            $category_unspec = [1 => Category::find(1)->name];
            $categories = $categories_all + $categories + $category_unspec;

            $images = Image::where('product_id', '=', $id)->get();
        } catch(\Exception $e) {
            return redirect('admin/products')->with('error', 'Product not found');
        }

        return view('admin/products/edit', compact(
            'product',
            'images',
            'categories',
            'brands'));
    }

    public function update(Request $request, $id) 
    {

        $alert_type = 'success';
        $alert_message = 'Product details updated';

        if(Input::get('submit_button') == 'delete_images') {
            $selected_images = Input::get('images');

            $cnt = 0;

            foreach($selected_images as $image_id) {
                ImagesController::destroy($image_id,$multiple=true);
                $cnt++;
            } 

            $alert_type = 'success';
            $alert_message = $cnt.' images deleted';

            return redirect('admin/products/' . $id .'/edit')
            ->with($alert_type, $alert_message);
        }

        $this->validate($request, ['name' => 'required|min:1']);

        try {
            $product = Product::find($id);
            $product->name = Input::get('name');
            $product->slug = Input::get('slug');
            if (Input::get('slug') == '')
                $product->slug = str_slug(Input::get('name'), '-');
            
            $product->description = Input::get('description');
            $product->category_id = Input::get('category_id');
            $product->brand_id = Input::get('brand_id');
            $product->affiliate_code = Input::get('affiliate_code');
            
            if(Input::has('discontinued'))
                $product->discontinued = Input::get('discontinued');
            else $product->discontinued = 0;  

            $default_image = Image::find($product->image_id);

            if($default_image) {
                if (File::exists('images/'.$product->id.'/mn_'.$default_image->file_name))
                    File::delete('images/'.$product->id.'/mn_'.$default_image->file_name);
            }

            $product->image_id = Input::get('default_image');
            $default_image = Image::find(Input::get('default_image'));

            if($default_image) self::createDefaultImage($product_id, $default_image->file_name);

            if (Input::has('active')) $product->active = Input::get('active');
            else $product->active = 0;
            $product->save();

            $this->UploadImages($product->id);
        } catch(\Exception $e) {
            $alert_type = 'error';
            $alert_message = 'Error updating product';
        }

        if(Input::get('update') == 'update_and_new')
            return redirect('admin/products/create')
        ->with($alert_type, $alert_message . '. Add new one bellow');
        else 
            return redirect('admin/products/' . $id .'/edit')
        ->with($alert_type, $alert_message);
    }

    public function destroy($id, $go_back = true) 
    {

        $alert_type = 'success';
        $alert_message = 'Product deleted';

        try {

            //get product image file names
            $image_files = Image::where('product_id', '=', $id)->get();

            //remove each file if exists
            foreach ($image_files as $image) {

                $image_file = 'images/' . $image->product_id . '/' . $image->file_name;
                $sm_image_file = 'images/' . $image->product_id . '/sm_' . $image->file_name;
                $mn_image_file = 'images/' . $image->product_id . '/mn_' . $image->file_name;

                if(File::exists($image_file)) File::delete($image_file);
                if(File::exists($sm_image_file)) File::delete($sm_image_file);
                if(File::exists($mn_image_file)) File::delete($mn_image_file);
            }

            @chmod('images/' . $product_id, 0777);
            @rmdir('images/' . $product_id);

            $product = Product::find($id);
            $product->delete();
        } catch(\Exception $e) {
            $alert_type = 'error';
            $alert_message = 'Error deleting product';
        }

        if ($go_back == false) {
            return redirect('admin/products')
            ->with($alert_type, $alert_message);
        }

        try {
            return Redirect::back()
            ->with($alert_type, $alert_message);
        } catch(\Exception $e) {
            return redirect('admin/products')
            ->with($alert_type, $alert_message);
        }
    }

    public static function uploadImages($product_id, $description = '')
    {
        $files = Input::file('images');

        $uploaded = false;

        foreach ($files as $file) {
            if (!is_null($file)) {
                $uploaded = true;
            }
        }

        if ($uploaded) {
            $count = 0;
            foreach ($files as $file) {

                $fileExt = strtolower($file->getClientOriginalExtension());
                if(!strstr(env('UPLOAD_IMAGE_TYPES'), $fileExt)) break;
                if($file->getSize() > intval(env('UPLOAD_MAX_SIZE_BYTES'))) break;
                $count++;
                $fileName = uniqid($count) . '.' . $fileExt;

                //check size: $file->getSize();
                //check if file exists
                $file->move('images/' . $product_id, $fileName);

                if(!file_exists('images/'.$product_id.'/index.php')) 
                    file_put_contents('images/'.$product_id.'/index.php', '<?php echo "forbidden";');

                ImageProcessor::make('images/' . $product_id . '/' . $fileName)
                ->resize(app('settings')->product_sm_thumb_w, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save('images/' . $product_id . '/sm_' . $fileName);

                self::AddImage($product_id, $fileName, $description);
            }

            return $count;
        } else return false;
    }

    public static function createDefaultImage($product_id, $fileName)
    {

        ImageProcessor::make('images/' . $product_id . '/' . $fileName)
        ->resize(app('settings')->product_main_thumb_w, null, function ($constraint) {
            $constraint->aspectRatio();
        })
        ->save('images/' . $product_id . '/mn_' . $fileName);

    }

    public static function addImage($product_id, $file_name, $description) 
    {

        $image = new Image();
        $image->description = $description;
        $image->product_id = $product_id;
        $image->file_name = $file_name;
        $image->save();

        $product = Product::find($product_id);
        if($product->image_id == NULL) {
            $product->image_id = $image->id;
            self::createDefaultImage($product_id, $image->file_name);
            $product->save();
        }
    }

    public static function setDefaultImage($product_id, $image_id = null) 
    {

        //echo $product_id; exit();
        $image = Image::where('product_id', '=', $product_id);

        if ($image->count() > 0) {

            if ($image_id == null) {

                $min_image = Image::where('product_id', '=', $product_id)->firstOrFail();
                $min_image->save();
            } 
            else {

                $image = Image::find($image_id);
                $image->save();
            }
        }
         //if any product image
    }

    public function postUnflag() 
    {

        try {

            $id = Session::get('next_action_item');
            $product = Product::find($id);
            $product->reported = 0;

            $product->save();

            ReportedProduct::where('product_id', '=', $id)->delete();

        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => 'Error unflagging product'], 400);
        } 

        return Response::json([
            'success' => true,
            'unflagged' => true,
            'message' => 'Product unflagged'], 200);

    }

    public function postMultipleDelete()
    {

        $selected_products = Input::get('products');

        $cnt = 0;

        foreach($selected_products as $product_id) {
            $this->destroy($product_id, $back=false);
            $cnt++;
        } 

        return Redirect::back()
        ->with('success',  $cnt.' products deleted');
    }

    public function getUpdatePagination($per_page=null)
    {
        if(is_numeric($per_page)) {
            Settings::set('admin_products_pagination', $per_page);
            return Redirect::back();
        } else
        return Redirect::back()->with('error', 'Error updating pagination');    
    }

}
