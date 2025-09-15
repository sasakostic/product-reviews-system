<?php namespace App\Http\Controllers;

//use App\Http\Controllers\Admin\SettingsController as Settings;
use Illuminate\Http\Request;

use View;
use Input;
use Redirect;
use Auth;

//use App\Category;
//use App\Product;
use App\ProductList;

class ProductListsController extends Controller
{

    private $is_admin;

    public function __construct()
    {
        $this->middleware('auth');  
        $this->is_admin = Auth::user()->admin;
    }
    
    public function index()
    {

        $product_lists = ProductList::orderBy('id', 'DESC')
        ->paginate(app('settings')->admin_categories_pagination);
        return view('account/lists/index', compact('product_lists'));
    }


    public function create() 
    {
        return view('account/lists/create')
        ->with('is_admin', $this->is_admin);
    }

    public function store(Request $request) 
    {

        $this->validate($request, ['name' => 'required|min:1']);

        try {

            $new_list = new ProductList();
            $new_list->name = Input::get('name');
            $new_list->slug = Input::get('slug');
            $new_list->description = Input::get('description');
            if (Input::get('slug') == '') {
                $new_list->slug = str_slug(Input::get('name'), '-');
            }
            if(Input::has('featured'))
                $new_list->featured = Input::get('featured');
            else $new_list->featured = 0;   
            if (Input::has('public')) $new_list->public = Input::get('public');
            else $new_list->public = 0;
            $new_list->save();
        }
        catch(\Exception $e) {
            return Redirect::to('account/lists')->with('error', 'Error adding list');
        }

        if(Input::get('save') == 'save_and_new')
            return redirect('account/lists/create')
        ->with('is_admin', $this->is_admin)
        ->with('success', 'List added. Add new one bellow');
        else 
            return Redirect::to('account/lists')->with('success', 'List added');
    }

    public function edit($id) 
    {
        try {
            $list = ProductList::find($id);
        }
        catch(\Exception $e) {
            return Redirect::to('account/lists')->with('error', 'List not found');
        }

        return view('account/lists/edit', compact('list'))
        ->with('is_admin', $this->is_admin);
    }

    public function update(Request $request, $id) 
    {

        $this->validate($request, ['name' => 'required|min:1']);

        try {
            $list = ProductList::find($id);
            $list->name = Input::get('name');
            $list->slug = Input::get('slug');
            $list->description = Input::get('description');
            if (Input::get('slug') == '') {
                $list->slug = str_slug(Input::get('name'), '-');
            }
            if(Input::has('featured'))
                $list->featured = Input::get('featured');
            else $list->featured = 0; 
            if (Input::has('public')) $list->public = Input::get('public');
            else $list->public = 0;
            $list->save();
        }
        catch(\Exception $e) {
            return Redirect::to('account/lists/' . $id .'/edit')->with('error', 'Error updating list')->with('list', $list);
        }

        if(Input::get('update') == 'update_and_new')
            return redirect('account/lists/create')
        ->with('success', 'List updated. Add new one bellow')
        ->with('is_admin', $this->is_admin);
        else 
            return Redirect::to('account/lists/' . $id .'/edit')
        ->with('success', 'List updated')
        ->with('list', $list)
        ->with('is_admin', $this->is_admin);
    }

    public function destroy($id, $go_back = true) 
    {

        $alert_type = 'success';
        $alert_message = 'List deleted';

        try {
            $list = ProductList::find($id);
            $list->delete();
        }
        catch(\Exception $e) {
            $alert_type = 'error';
            $alert_message = 'Error deleting list';
        }

        if ($go_back == false) {
            return Redirect::to('account/lists')
            ->with($alert_type, $alert_message);
        }

        try {
            return Redirect::back()
            ->with($alert_type, $alert_message);
        }
        catch(\Exception $e) {
            return Redirect::to('account/lists')
            ->with($alert_type, $alert_message);
        }

    }


    public function postMultipleDelete()
    {

        $selected_lists = Input::get('lists');

        $cnt = 0;

        foreach($selected_lists as $list_id){
            $this->destroy($list_id, $back=false);
            $cnt++;
        } 

        return Redirect::back()
        ->with('success',  $cnt.' lists deleted');
    }

}
