<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use View;
use Input;
use Carbon\Carbon;

use App\Review;
use App\Product;
use App\Image;
use App\User;
use App\Category;
use App\Brand;
use App\Page;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAdmin');        
    }
    
    public function getIndex() 
    {
        
        $products_count = Product::count();
        $inactive_products_count = Product::where('active', '=', 0)->count();
        $reported_products_count = Product::where('reported', '=', 1)->count();
        $new_products_count = Product::where('created_at', '>', app('settings')->new_products_since)
        ->count();

        $reviews_count = Review::count();
        $unpublished_reviews_count = Review::where('active', '=', 0)->count();
        $reported_reviews_count = Review::where('reported', '=', 1)->count();
        $new_reviews_count = Review::where('created_at', '>', app('settings')->new_reviews_since)
        ->count();

        $images_count = Image::count();
        $new_images_count = Image::where('created_at', '>', app('settings')->new_images_since)
        ->count();

        $reported_reviews_count = Review::where('reported', '=', 1)->count();
        $categories_count = Category::count();
        $brands_count = Brand::count();
        
        $users_count = User::count();
        $new_users_count = User::where('created_at', '>', app('settings')->new_users_since)->count();

        $last_7_days_products = Product::where('created_at', '>', Carbon::now()->subDays(7))->count();
        $last_7_days_reviews = Review::where('created_at', '>', Carbon::now()->subDays(7))->count();
        $last_7_days_images = Image::where('created_at', '>', Carbon::now()->subDays(7))->count();
        $last_7_days_users = User::where('created_at', '>', Carbon::now()->subDays(7))->count();

        $last_30_days_products = Product::where('created_at', '>', Carbon::now()->subDays(30))->count();
        $last_30_days_reviews = Review::where('created_at', '>', Carbon::now()->subDays(30))->count();
        $last_30_days_images = Image::where('created_at', '>', Carbon::now()->subDays(30))->count();
        $last_30_days_users = User::where('created_at', '>', Carbon::now()->subDays(30))->count();

        $last_365_days_products = Product::where('created_at', '>', Carbon::now()->subDays(365))->count();
        $last_365_days_reviews = Review::where('created_at', '>', Carbon::now()->subDays(365))->count();
        $last_365_days_images = Image::where('created_at', '>', Carbon::now()->subDays(365))->count();
        $last_365_days_users = User::where('created_at', '>', Carbon::now()->subDays(365))->count();
        
        return view('admin/overview/index', compact(
            'products_count', 
            'inactive_products_count',
            'reported_products_count',
            'new_products_count', 
            'images_count', 
            'new_images_count', 
            'reviews_count', 
            'unpublished_reviews_count', 
            'reported_reviews_count',
            'new_reviews_count', 
            'categories_count', 
            'brands_count', 
            'users_count', 
            'new_users_count', 
            'last_7_days_products', 
            'last_7_days_reviews', 
            'last_7_days_images', 
            'last_7_days_users', 
            'last_30_days_products', 
            'last_30_days_reviews', 
            'last_30_days_images', 
            'last_30_days_users', 
            'last_365_days_products',
            'last_365_days_reviews', 
            'last_365_days_images', 
            'last_365_days_users'));
    }
    
    public function getSearch() 
    {

        $search_terms = Input::get('search_terms_all');
        
        $products = Product::where('name', 'LIKE', '%' . $search_terms . '%')
        ->orWhere('id', '=', $search_terms)
        ->orderBy('id', 'DESC')
        ->paginate(app('settings')->admin_products_pagination);

        $reviews = Review::where('text', 'LIKE', '%' . $search_terms . '%')
        ->orWhere('title', 'LIKE', '%' . $search_terms . '%')
        ->orWhere('pros', 'LIKE', '%' . $search_terms . '%')
        ->orWhere('cons', 'LIKE', '%' . $search_terms . '%')
        ->orWhere('id', '=', $search_terms)
        ->orderBy('reported', 'DESC')
        ->orderBy('id', 'DESC')
        ->paginate(app('settings')->admin_reviews_pagination);

        $images = Image::where('file_name', 'LIKE', '%' . $search_terms . '%')
        ->orWhere('description', 'LIKE', '%' . $search_terms . '%')
        ->orWhere('id', '=', $search_terms)
        ->orderBy('id', 'DESC')
        ->paginate(app('settings')->admin_images_pagination);

        $categories = Category::where('name', 'LIKE', '%' . $search_terms . '%')
        ->orWhere('id', '=', $search_terms)
        ->orderBy('id', 'DESC')
        ->paginate(app('settings')->admin_categories_pagination);
        
        $brands = Brand::where('name', 'LIKE', '%' . $search_terms . '%')
        ->orWhere('id', '=', $search_terms)
        ->orderBy('id', 'DESC')
        ->paginate(app('settings')->admin_brands_pagination);
        
        $pages = Page::where('title', 'LIKE', '%' . $search_terms . '%')
        ->orWhere('slug', 'LIKE', '%' . $search_terms . '%')
        ->orWhere('content', 'LIKE', '%' . $search_terms . '%')
        ->orderBy('id', 'DESC')->get();        

        return view('admin/overview/search', compact(
            'search_terms',
            'products', 
            'reviews', 
            'images',
            'categories',
            'brands',
            'pages', 
            'users'));
    }
}
