<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Auth;
use View;
use Input;
use Redirect;

use App\Widget;


class WidgetsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAdmin');        
    }
    
    public function index() 
    {

        $widgets = Widget::get();
        
        return view('admin/widgets/index')->with('widgets', $widgets);
    }
    
    public function show($id) 
    {
        $widget = Widget::find($id);
        
        return view('admin/widgets/show')
        ->with('widget', $widget);
    }

    
    public function edit($id) 
    {
        try {
            $widget = Widget::find($id);
        } catch(\Exception $e) {
            return Redirect::to('admin/widgets')->with('error', 'Widget nof found');
        }
        
        return view('admin/widgets/edit')->with('widget', $widget);
    }
    
    public function update($id) 
    {

        try {
            $widget = Widget::find($id);
            $widget->code = Input::get('code');            
            
            $widget->save();
        } catch(\Exception $e) {
            return Redirect::to('admin/widgets/' . $id . '/edit')->with('error', 'Error updating ad')->with('widget', $widget);
        }
        
        return Redirect::to('admin/widgets/' . $id . '/edit')->with('success', 'Widget updated')->with('widget', $widget);
    }
    
}
