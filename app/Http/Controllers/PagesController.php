<?php namespace App\Http\Controllers;

use App\Page;

class PagesController extends Controller
{     
	public function show($page_slug) 
	{
		$page = Page::where('slug', '=', $page_slug)->firstOrFail();
		$pages = Page::all();
		return view('pages/view')
		->with('pages', $pages)
		->with('page', $page)
		->with('meta_description', substr($page->content, 0, 155));
	}    
}
