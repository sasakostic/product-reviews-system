<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\SettingsController as Settings;
use Illuminate\Http\Request;

use View;
use Input;
use Redirect;

use App\Brand;
use App\Product;

class BrandsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAdmin');             
    }
    
    public function index()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(app('settings')->admin_brands_pagination);
        return view('admin/brands/index', compact('brands'));
    }

    public function getSearch()
    {

        $search_terms = Input::get('search_terms');
        $brands = Brand::where('name', 'LIKE', '%' . $search_terms . '%')
        ->orWhere('id', '=', $search_terms)
        ->orderBy('id', 'DESC')
        ->paginate(app('settings')->admin_brands_pagination);

        return view('admin/brands/index', compact('brands'));    

    }

    public function create()
    {
        return view('admin/brands/create');
    }

    public function store(Request $request)
    {

        $this->validate($request, ['name' => 'required|min:1|unique:brands']);

        try {

            $new_brand = new Brand();
            $new_brand->name = Input::get('name');
            $new_brand->slug = Input::get('slug');
            $new_brand->meta_description = Input::get('meta_description');

            if (Input::get('slug') == '') {
                $new_brand->slug = str_slug(Input::get('name'), '-');
            }

            $new_brand->save();
        }
        catch(\Exception $e) {
            return Redirect::to('admin/brands')
            ->with('error', 'Error adding brand');        
        }    

        return self::handleSaveButton();

    }

    public static function handleSaveButton()
    {

        if(Input::get('save') == 'save_and_new')
            return redirect('admin/brands/create')
        ->with('success', 'Brand added. Add new one bellow');
        else 
            return Redirect::to('admin/brands')
        ->with('success', 'Brand added');

    }

    public function edit($id) 
    {

        try {
            $brand = Brand::find($id);
        }
        catch(\Exception $e) {
            return Redirect::to('admin/brands')
            ->with('error', 'Brand not found');
        }

        return view('admin/brands/edit', compact('brand'));
    }

    public function update(Request $request, $id) 
    {

        $this->validate($request, ['name' => 'required|min:1']);

        try {
            $brand = Brand::find($id);
            $brand->name = Input::get('name');
            $brand->slug = Input::get('slug');
            $brand->meta_description = Input::get('meta_description');
            if (Input::get('slug') == '') {
                $brand->slug = str_slug(Input::get('name'), '-');
            }

            $brand->save();
        }
        catch(\Exception $e) {
            return Redirect::to('admin/brands/' . $id . '/edit')
            ->with('error', 'Error updating brand')
            ->with('brand', $brand);
        }

        return self::handleUpdateButton($brand);   
    }

    public static function handleUpdateButton($brand)
    {

        if(Input::get('update') == 'update_and_new')
            return redirect('admin/brands/create')
        ->with('success', 'Brand updated. Add new one bellow');
        else 
            return Redirect::to('admin/brands/' . $brand->id . '/edit')
        ->with('success', 'Brand updated')
        ->with('brand', $brand);

    }

    public function destroy($id, $go_back = true) 
    {
        if ($id != 1) {

            $alert_type = 'success';
            $alert_message = 'Brand deleted';

            try {
                $brand = Brand::find($id);
                if (!$brand->products->isEmpty()) {
                    return Redirect::to('admin/brands/' . $id . '/delete_what');
                }
                $brand->delete();
            }
            catch(\Exception $e) {
                $alert_type = 'error';
                $alert_message = 'Error deleting brand';
            }

            if ($go_back == false) {
                return Redirect::to('admin/brands')
                ->with($alert_type, $alert_message);
            }

            try {
                return Redirect::back()
                ->with($alert_type, $alert_message);            
            }
            catch(\Exception $e) {
                return Redirect::to('admin/brands')
                ->with($alert_type, $alert_message);
            }
        } 
        else {
            return Redirect::to('admin/brands')
            ->with('error', 'Brand cannot be deleted');
        }
    }

    public function postMultipleDelete()
    {

        $selected_brands = Input::get('brands');

        foreach($selected_brands as $brand_id) {
            $brand = Brand::find($brand_id);
            if($brand->products->count() > 0) 
                return $this->getDeleteNonEmpty($selected_brands);            
        };

        $cnt = 0;

        foreach($selected_brands as $brand_id) {
            $this->destroy($brand_id, $back=false);
            $cnt++;
        } 

        return Redirect::back()
        ->with('success',  $cnt.' brands deleted');
    }

    public function getDeleteNonEmpty($selected_brands) 
    {
        return view('admin/brands/delete-non-empty')
        ->with('brands', serialize($selected_brands));
    }

    public function postDeleteNonEmpty() 
    {
        $brands = Input::get('brands');
        $brands = unserialize($brands);

        $delete_type = Input::get('type');

        $cnt = 0;
        $products_count = 0;

        foreach($brands as $brand_id) {
            $brand = Brand::find($brand_id);
            $products_count += $brand->products->count();

            if($delete_type == 'delete_assign') Product::where('brand_id', '=', $brand_id)->update(['brand_id' => 1]);
            if($delete_type == 'delete_products') Product::where('brand_id', '=', $brand_id)->delete();


            $brand->delete();
            $cnt++;
        }    

        if($delete_type == 'delete_assign') $products_removed = ' and '.$products_count. ' products moved to Unspecified brand';
        if($delete_type == 'delete_products') $products_removed = ' along with '.$products_count. ' products of those brands';

        return Redirect::to('admin/brands')
        ->with('success', $cnt.' brands deleted' . $products_removed);
    }

    public function getUpdatePagination($per_page=null)
    {
        if(is_numeric($per_page)) {
            Settings::set('admin_brands_pagination', $per_page);
            return Redirect::back();
        } else 
        return Redirect::back()->with('error', 'Error updating pagination');    
    }
}
