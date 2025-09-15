<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\SettingsController as Settings;

use Input;
use View;
use Redirect;
use File;
use Carbon\Carbon;

use App\Product;
use App\Image;
use App\User;



class ImagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAdmin');        
    }
    
    public function index() 
    {

        Settings::set('new_images_since',  Carbon::now());

        if (Input::has('search_terms')) {
            $search_terms = Input::get('search_terms');
            $images_query = Image::where('file_name', 'LIKE', '%' . $search_terms . '%')
            ->orWhere('id', '=', $search_terms)
            ->orWhere('description', 'LIKE', '%' . $search_terms . '%')->orderBy('id', 'DESC');
        } else {
            $images_query = Image::orderBy('id', 'DESC');
        }
        
        $filter = '';
        if (Input::has('product_id')) {

            $product_id = Input::get('product_id');
            $images_query->where('product_id', '=', Input::get('product_id'));
            $filter = 'of product' . ' ' . Product::find($product_id)->name;
        }
        
        
        $images = $images_query->paginate(app('settings')->admin_images_pagination);

        return view('admin/images/index', compact('filter', 'images'));
    }
    
    public function edit($id) 
    {
        try {
            $image = Image::find($id);
        }
        catch(\Exception $e) {
            return Redirect::to('admin/images')
            ->with('error', 'Image not found');
        }
        
        return view('admin/images/edit', compact('image'));
    }
    
    public function update($id) 
    {

        try {
            $image = Image::find($id);
            $image->description = Input::get('description');
            $image->save();
        }
        catch(\Exception $e) {
            return Redirect::to('admin/images/' . $id .'/edit')
            ->with('error', 'Error updating image')
            ->with('image', $image);
        }
        
        return Redirect::to('admin/images/' . $id .'/edit')
        ->with('success', 'Image updated')
        ->with('image', $image);
    }

    public static function destroy($id, $multiple = false) 
    {

        try {
            $image = Image::find($id);
        }
        catch(\Exception $e) {
            return redirect('admin/products/' . $image_file->product_id . '/edit');
        }
        
        $image_file = 'images/' . $image->product_id . '/' . $image->file_name;
        $sm_image_file = 'images/' . $image->product_id . '/sm_' . $image->file_name;
        $mn_image_file = 'images/' . $image->product_id . '/mn_' . $image->file_name;
        
        if(File::exists($image_file)) File::delete($image_file);
        if(File::exists($sm_image_file)) File::delete($sm_image_file);
        if(File::exists($mn_image_file)) File::delete($mn_image_file);
        
        $product_id = $image->product_id;
        $image->delete();
        
        $product = Product::find($product_id);
        if($product->image_id == NULL) {
            $new_def_image = Image::where('product_id', '=', $product_id)->first();
            if($new_def_image) {
                $product->image_id = $new_def_image->id;
                ProductsController::createDefaultImage($product_id, $new_def_image->file_name);
                $product->save();
            }
        }        
        
        if(!$multiple) {
            return Redirect::to('admin/images')
            ->with('success', 'Image deleted');
        }
    }

    public function postMultipleDelete()
    {
        $selected_images = Input::get('images');

        $cnt = 0;

        foreach($selected_images as $image_id) {
            ImagesController::destroy($image_id,$multiple=true);
            $cnt++;
        } 

        return Redirect::back()
        ->with('success',  $cnt.' images deleted');
    }

    public function getUpdatePagination($per_page=null)
    {
        if(is_numeric($per_page)) {
            Settings::set('admin_images_pagination', $per_page);
            return Redirect::back();
        }
        else
           return Redirect::back()->with('error', 'Error updating pagination');    
   }   
}
