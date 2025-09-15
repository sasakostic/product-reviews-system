<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Auth;
use Input;
use File;
use View;
use Redirect;

use App\Image;
use App\Product;

class ImagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isActive');
    }

    public function index() 
    {

        if(app('settings')->users_list_product_images == 0) return view('errors/404');

        $images = NULL;

        return view('account/images/index', compact('images'));
    }

    public function store() 
    {

        $product_id = Input::get('product_id');

        $product = Product::find($product_id);
        $uploaded = Admin\ProductsController::uploadImages($product_id, Input::get('description'));

        if ($uploaded) return redirect('product/' . $product->id . '/' . $product->slug)
            ->with('success', "Image added");
        else 
            return redirect('product/' . $product->id . '/' . $product->slug)
        ->with('error', "Image not uploaded");

    }

    public function edit($id) 
    {

        try {
            $image = Image::find($id);
        }
        catch(\Exception $e) {
            return Redirect::to('account/images')
            ->with('error', 'Image not found');
        }

        return view('account/images/edit')
        ->with('image', $image);
    }

    public function update($id) 
    {

        try {
            $image = Image::find($id);
            $image->description = Input::get('description');
            $image->save();
        } catch(\Exception $e) {
            return Redirect::to('account/images/' . $id . '/edit')->with('error', 'Error updating image')
            ->with('image', $image);
        }

    

        return Redirect::to('account/images/' . $id . '/edit')->with('success', 'Image updated')
        ->with('image', $image);
    }

    public function destroy($id) 
    {

        if(app('settings')->users_delete_product_images == 0) return view('errors/404');

        try {
            $image = Image::where('id', '=', $id)
            ->first();          
        } catch (exception $e) {
            return Redirect::to('account/images');
        }

        if(!$image) 
            return Redirect::to('account/images')
        ->with('error', 'Error deleting image');



        $file = 'images/' . $image->product_id .'/'. $image->file_name;
        $sm_thumb_file = 'images/' . $image->product_id .'/sm_'. $image->file_name;

        if (File::exists($file)) {
            File::delete($file);
        }

        if (File::exists($sm_thumb_file)) {
            File::delete($sm_thumb_file);
        }

        $product_id = $image->product_id;
        $image->delete();

        $product = Product::find($product_id);
        if($product->image_id == NULL) {
            $new_def_image = Image::where('product_id', '=', $product_id)->first();
            if($new_def_image) {
                $product->image_id = $new_def_image->id;
                $product->save();
            }
        }

        return Redirect::to('account/images')
        ->with('success', 'Image deleted');

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

}
