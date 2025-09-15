<?php namespace App\Http\Controllers;

use Input;
use View;
use DB;

use App\Category;
use App\Widget;

class CategoriesController extends Controller
{

    public function index() 
    {

        $meta_description = 'All product categories with number of reviews and products';

        $categories_query = DB::table('categories')
        ->select(DB::raw('categories.*, count(reviews.id) as reviews, (select count(products.id) from products where products.category_id = categories.id) as products'))
        ->LeftJoin('products', 'categories.id', '=', 'products.category_id')
        ->LeftJoin('reviews', 'reviews.product_id', '=', 'products.id')
        ->GroupBy('categories.id')
        ->OrderBy('reviews', 'DESC');
        
        $latest_added = true;

        if (Input::has('letter')) {
            if(Input::get('letter') == 'other') {
                $categories_query->whereRaw('ASCII(UPPER(LEFT(categories.name,1))) NOT BETWEEN 64 AND 90');
            } else {
                $categories_query->where('categories.name', 'LIKE', Input::get('letter') . '%');
            }

            $latest_added = false;
        }
        
        $categories = $categories_query->paginate(app('settings')->front_end_pagination);
        
        $letters_q = DB::select('select distinct UCASE(substring(name,1,1)) as letter
            from categories ORDER BY letter ASC');
        $letters = array();
        
        foreach ($letters_q as $letter) array_push($letters, $letter->letter);
        $alphabet = range('A', 'Z');

        $starting_nonalpha_cnt = DB::select('SELECT count(id) as cnt FROM categories WHERE ASCII(UPPER(LEFT(name,1))) NOT BETWEEN 64 AND 90');    
        $starting_nonalpha_cnt = $starting_nonalpha_cnt[0]->cnt;

        $widgets = Widget::whereIn('slug', [
            'categories-top', 
            'categories-bottom', 
            'categories-top-right'])
        ->lists('code', 'slug'); 

        return view('categories/index', compact(
            'meta_description', 
            'widgets',
            'alphabet', 
            'letters',
            'categories',
            'latest_added', 
            'starting_nonalpha_cnt'));
    }
}
