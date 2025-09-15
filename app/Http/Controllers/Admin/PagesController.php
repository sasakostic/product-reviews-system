<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use View;
use Input;
use Redirect;
use URL;

use App\Page;

class PagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAdmin');        
    }
    
    public function index()
    {

        $pages = Page::orderBy('id', 'DESC')->get();
        
        return view('admin/pages/index', compact('pages'));
    }
    
    public function create() 
    {
        return view('admin/pages/create');
    }
    
    public function store(Request $request) 
    {

        $this->validate($request, ['title' => 'required|min:1|unique:pages',
            'slug' => 'unique:pages']);

        $alert_type = 'success';
        $alert_message = 'Page created';
        
        try {
            $new_page = new Page();
            $new_page->title = Input::get('title');
            $new_page->slug = Input::get('slug');
            if (Input::get('slug') == '') {
                $new_page->slug = str_slug(Input::get('title'), '-');
            }
            
            $new_page->content = Input::get('content');
            $new_page->save();
        }
        catch(\Exception $e) {
            $alert_type = 'error';
            $alert_message = 'Error creating page';
        }

        if(Input::get('save') == 'save_and_new')
            return redirect('admin/pages/create')->with('success', 'Page created. Add new one bellow');
        else 
            return Redirect::to('admin/pages/' . $new_page->id . '/edit')->with($alert_type, $alert_message);
    }

    public function edit($page_id)
    {
        try {
            $page = Page::find($page_id);
        } catch(\Exception $e) {
            return Redirect::to('admin/pages/')->with('error', 'Page not found');
        }
        return view('admin/pages/edit', compact('page'));
    }

    public function update($page_id) 
    {

        try {
            $page = Page::find($page_id);
            $page->title = Input::get('title');
            $page->slug = Input::get('slug');
            if (Input::get('slug') == '') {
                $page->slug = str_slug(Input::get('title'), '-');
            }

            $page->content = Input::get('content');
            $page->save();
        } catch(\Exception $e) {
            return Redirect::to('admin/pages/' . $page_id . '/edit')
            ->with('error', 'Error updating page')
            ->with('page', $page);
        }

        if(Input::get('update') == 'update_and_new')
            return redirect('admin/pages/create')->with('success', 'Page updated. Add new one bellow');
        else 
            return Redirect::to('admin/pages/' . $page_id . '/edit')
        ->with('success', 'Page updated')
        ->with('page', $page);
    }

    public function destroy($page_id, $go_back = true) 
    {

        $alert_type = 'success';
        $alert_message = 'Page deleted';

        try {
            $page = Page::find($page_id);
            $page->delete();
        } catch(\Exception $e) {
            $alert_type = 'error';
            $alert_message = 'Error deleting page';
        }

        if ($go_back == false) {
            return Redirect::to('admin/pages')->with($alert_type, $alert_message);
        }

        return Redirect::to('admin/pages')
        ->with('success', 'Page deleted');
    }

    public function postMultipleDelete()
    {

        $selected_pages = Input::get('pages');

        $cnt = 0;

        foreach($selected_pages as $page_id) {
            $this->destroy($page_id, $back=false);
            $cnt++;
        } 

        return Redirect::back()
        ->with('success',  $cnt.' pages deleted');
    }

}
