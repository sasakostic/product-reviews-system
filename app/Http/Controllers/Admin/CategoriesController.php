<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\SettingsController as Settings;
use Illuminate\Http\Request;

use View;
use Input;
use Redirect;

use App\Category;
use App\Product;

class CategoriesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAdmin');             
    }
    
    public function index()
    {
        $categories = Category::orderBy('id', 'DESC')
        ->paginate(app('settings')->admin_categories_pagination);
        return view('admin/categories/index', compact('categories'));
    }


    public function getSearch()
    {

        $search_terms = Input::get('search_terms');
        $categories = Category::where('name', 'LIKE', '%' . $search_terms . '%')
        ->orWhere('id', '=', $search_terms)
        ->orderBy('id', 'DESC')
        ->paginate(app('settings')->admin_categories_pagination);

        return view('admin/categories/index', compact('categories'));    

    }

    public function create() 
    {
        return view('admin/categories/create');
    }

    public function store(Request $request) 
    {

        $this->validate($request, ['name' => 'required|min:1|unique:categories']);

        try {
            $new_category = new Category();
            $new_category->name = Input::get('name');
            $new_category->slug = Input::get('slug');
            $new_category->meta_description = Input::get('meta_description');
            if (Input::get('slug') == '') {
                $new_category->slug = str_slug(Input::get('name'), '-');
            }
            if(Input::has('featured'))
                $new_category->featured = Input::get('featured');
            else $new_category->featured = 0;   
            $new_category->save();
        }
        catch(\Exception $e) {
            return Redirect::to('admin/categories')->with('error', 'Error adding category');
        }

        if(Input::get('save') == 'save_and_new')
            return redirect('admin/categories/create')->with('success', 'Category added. Add new one bellow');
        else 
            return Redirect::to('admin/categories')->with('success', 'Category added');
    }

    public function edit($id) 
    {
        try {
            $category = Category::find($id);
        }
        catch(\Exception $e) {
            return Redirect::to('admin/categories')->with('error', 'Category not found');
        }

        return view('admin/categories/edit', compact('category'));
    }

    public function update(Request $request, $id) 
    {

        $this->validate($request, ['name' => 'required|min:1']);

        try {
            $category = Category::find($id);
            $category->name = Input::get('name');
            $category->slug = Input::get('slug');
            $category->meta_description = Input::get('meta_description');
            if (Input::get('slug') == '') {
                $category->slug = str_slug(Input::get('name'), '-');
            }
            if(Input::has('featured'))
                $category->featured = Input::get('featured');
            else $category->featured = 0; 
            $category->save();
        }
        catch(\Exception $e) {
            return Redirect::to('admin/categories/' . $id .'/edit')->with('error', 'Error updating category')->with('category', $category);
        }

        if(Input::get('update') == 'update_and_new')
            return redirect('admin/categories/create')->with('success', 'Category updated. Add new one bellow');
        else 
            return Redirect::to('admin/categories/' . $id .'/edit')->with('success', 'Category updated')->with('category', $category);
    }

    public function destroy($id, $go_back = true) 
    {
        if ($id != 1) {

            $alert_type = 'success';
            $alert_message = 'Category deleted';

            try {
                $category = Category::find($id);
                if (!$category->products->isEmpty()) {
                    return Redirect::to('admin/categories/' . $id . '/delete_what');
                }
                $category->delete();
            }
            catch(\Exception $e) {
                $alert_type = 'error';
                $alert_message = 'Error deleting category';
            }

            if ($go_back == false) {
                return Redirect::to('admin/categories')
                ->with($alert_type, $alert_message);
            }

            try {
                return Redirect::back()
                ->with($alert_type, $alert_message);
            }
            catch(\Exception $e) {
                return Redirect::to('admin/categories')
                ->with($alert_type, $alert_message);
            }
        } else {
            return Redirect::to('admin/categories')
            ->with('error', 'Category cannot be deleted');
        }
    }


    public function postMultipleDelete()
    {

        $selected_categories = Input::get('categories');

        foreach($selected_categories as $category_id){
            $category = Category::find($category_id);
            if($category->products->count() > 0) 
                return $this->getDeleteNonEmpty($selected_categories);            
        };

        $cnt = 0;

        foreach($selected_categories as $category_id){
            $this->destroy($category_id, $back=false);
            $cnt++;
        } 

        return Redirect::back()
        ->with('success',  $cnt.' categories deleted');
    }

    public function getDeleteNonEmpty($selected_categories) 
    {
        return view('admin/categories/delete-non-empty')
        ->with('categories', serialize($selected_categories));
    }

    public function postDeleteNonEmpty() 
    { 
        $categories = Input::get('categories');
        $categories = unserialize($categories);

        $delete_type = Input::get('type');

        $cnt = 0;
        $products_count = 0;

        foreach($categories as $category_id) {
            $category = Category::find($category_id);
            $products_count += $category->products->count();

            if($delete_type == 'delete_assign') Product::where('category_id', '=', $category_id)->update(['category_id' => 1]);
            if($delete_type == 'delete_products') Product::where('category_id', '=', $category_id)->delete();


            $category->delete();
            $cnt++;
        }    

        if($delete_type == 'delete_assign') $products_removed = ' and '.$products_count. ' products moved to Unspecified category';
        if($delete_type == 'delete_products') $products_removed = ' along with '.$products_count. ' products of those categories';

        return Redirect::to('admin/categories')
        ->with('success', $cnt.' categories deleted' . $products_removed);
    }

    public function getUpdatePagination($per_page=null)
    {
        if(is_numeric($per_page)) {
            Settings::set('admin_categories_pagination', $per_page);
            return Redirect::back();
        } else
        return Redirect::back()->with('error', 'Error updating pagination');    
    }
}
