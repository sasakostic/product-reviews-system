<?php namespace App\Http\Controllers;

use Input;
use View;
use DB;

use App\Brand;
use App\Widget;


class BrandsController extends Controller
{
  public function __construct()
  {
    //echo $this->sidebar_highlight;
  }

  public function index() 
  {

    $meta_description = 'All product brands with number of reviews and products';

    $brands_query = DB::table('brands')
    ->select(DB::raw('brands.*, count(reviews.id) as reviews, (select count(products.id) from products where products.brand_id = brands.id) as products'))
    ->LeftJoin('products', 'brands.id', '=', 'products.brand_id')
    ->LeftJoin('reviews', 'reviews.product_id', '=', 'products.id')
    ->GroupBy('brands.id')
    ->OrderBy('reviews', 'DESC');

    $latest_added = true;

    if (Input::has('letter')) {
      if(Input::get('letter') == 'other') {
        $brands_query->whereRaw('ASCII(UPPER(LEFT(brands.name,1))) NOT BETWEEN 64 AND 90');
      } else {
        $brands_query->where('brands.name', 'LIKE', Input::get('letter') . '%');
      }

      $latest_added = false;

    }

    $brands = $brands_query->paginate(app('settings')->front_end_pagination);

    $letters_q = DB::select('select distinct UCASE(substring(name,1,1)) as letter
      from brands ORDER BY letter ASC');
    $letters = array();

    foreach ($letters_q as $letter) array_push($letters, $letter->letter);
    $alphabet = range('A', 'Z');

    $starting_nonalpha_cnt = DB::select('SELECT count(id) as cnt FROM brands WHERE ASCII(UPPER(LEFT(name,1))) NOT BETWEEN 64 AND 90');

    $starting_nonalpha_cnt = $starting_nonalpha_cnt[0]->cnt;

    $widgets = Widget::whereIn('slug', [
      'brands-top', 
      'brands-bottom', 
      'brands-top-right'])
    ->lists('code', 'slug');

    return view('brands/index', compact(
      'meta_description', 
      'widgets',
      'alphabet', 
      'letters', 
      'brands', 
      'latest_added', 
      'starting_nonalpha_cnt'
      ));

  }

}
