<?php namespace App\Http\Controllers;

use View;
use Input;
use DB;

use App\Brand;
use App\Category;
use App\Review;
use App\Product;
use App\Image;
use App\ReviewReportingReason;
use App\Widget;
use App\ProductList;

class HomeController extends Controller
{

	public function getIndex() 
	{
		$meta_description = app('settings')->meta_description;
		
		$reviews = Review::where('active', '=', 1)->OrderBy('id', 'DESC')->take(5)->get();

		$featured_reviews = Review::where('active', '=', 1)->whereNotNull('featured_on')->OrderBy('featured_on', 'DESC')->take(5)->get();

		$featured_categories = Category::OrderBy('updated_at', 'ASC')->where('featured', '=', 1)->get();

		$featured_product_lists = ProductList::OrderBy('updated_at', 'DESC')
		->where('public', '=', 1)
		->where('featured', '=', 1)
		->take(6)
		->get();

		$images = Image::OrderBy('id', 'DESC')->take(12)->get();

		$home_top_widget = Widget::where('slug', '=', 'home-top')->first()->code;
		$home_top_right_widget = Widget::where('slug', '=', 'home-top-right')->first()->code;
		$home_bottom_widget = Widget::where('slug', '=', 'home-bottom')->first()->code;

		$widgets = Widget::whereIn('slug', [
			'home-top', 
			'home-bottom', 
			'home-top-right'])
		->pluck('code', 'slug');  
		
		if ($reviews) {
			return view('home', compact(
				'meta_description',
				'widgets',
				'home_top_widget',
				'home_top_right_widget',
				'home_bottom_widget',
				'featured_categories', 
				'images', 
				'reviews', 
				'featured_reviews', 
				'featured_product_lists'));			
		} else {
			throw new \Exception('Please install the application');
		}
		
	}

	public function getSearch() 
	{
		
		$search_terms = Input::get('search_terms');
		
		$words = explode(' ', $search_terms);

		$meta_description = 'Search results for '.$search_terms;


		try {
			$products_query = Product::LeftJoin('categories', 'categories.id', '=', 'products.category_id')
			->LeftJoin('brands', 'brands.id', '=', 'products.brand_id')
			->select(
				'products.*',
				'categories.id as cid',
				'categories.name as cname',
				'brands.id as bid',
				'brands.name as bname'
				);

			$products_query->where('products.name', 'LIKE', '%' . $words[0] . '%');

			if(count($words > 1)) {
				foreach($words as $key => $word) {
					if($key > 0) $products_query->orWhere('products.name', 'LIKE', '%' . $word . '%');    
				}
			}

			foreach($words as $word) { 
				$products_query->orWhere('categories.name', 'LIKE', '%' . $word . '%');
				$products_query->orWhere('brands.name', 'LIKE', '%' . $word . '%');
			}    

			$products = $products_query->where('products.active', '=', 1)
			->OrderBy('products.rating', 'DESC')
			->OrderBy('products.reviews_count', 'DESC')
			->GroupBy('products.id')
			->paginate(app('settings')->front_end_pagination);			

		} catch(\Exception $e) {
			return view('/products/no_products', compact('search_terms'));
		}

		$reviews = Review::where('text', 'LIKE', '%' . $search_terms . '%')
		->orWhere('title', 'LIKE', '%' . $search_terms . '%')
		->orWhere('pros', 'LIKE', '%' . $search_terms . '%')
		->orWhere('cons', 'LIKE', '%' . $search_terms . '%')
		->where('active', '=', 1)
		->OrderBy('id', 'DESC')
		->paginate(app('settings')->front_end_pagination);		

		$brands = DB::table('brands')
		->select(DB::raw('brands.*, count(reviews.id) as reviews, (select count(products.id) from products where products.brand_id = brands.id) as products'))
		->LeftJoin('products', 'brands.id', '=', 'products.brand_id')
		->LeftJoin('reviews', 'reviews.product_id', '=', 'products.id')
		->where('brands.name', 'LIKE', '%' . $search_terms . '%')
		->GroupBy('brands.id')
		->OrderBy('reviews', 'DESC')
		->paginate(app('settings')->front_end_pagination);		

		$categories = DB::table('categories')
		->select(DB::raw('categories.*, count(reviews.id) as reviews, (select count(products.id) from products where products.category_id = categories.id) as products'))
		->LeftJoin('products', 'categories.id', '=', 'products.category_id')
		->LeftJoin('reviews', 'reviews.product_id', '=', 'products.id')
		->where('categories.name', 'LIKE', '%' . $search_terms . '%')
		->GroupBy('categories.id')
		->OrderBy('reviews', 'DESC')
		->paginate(app('settings')->front_end_pagination);

		$images = Image::where('description', 'LIKE', '%' . $search_terms . '%')
		->OrderBy('id', 'DESC')
		->paginate(app('settings')->front_end_pagination);

		$review_reporting_reasons = ReviewReportingReason::OrderBy('ID', 'DESC')->get();
		
		$widgets = Widget::whereIn('slug', [
			'search-results-top', 
			'search-results-bottom', 
			'search-results-top-right'])
		->pluck('code', 'slug'); 

		return view('home/search_results', compact(
			'meta_description',
			'widgets',
			'search_terms',
			'products',
			'reviews',
			'brands',
			'images',
			'categories',
			'review_reporting_reasons'
			));
	}
	
}
