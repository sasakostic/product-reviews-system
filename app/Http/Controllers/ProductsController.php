<?php namespace App\Http\Controllers;

use App\Http\Controllers\UserController as User;
use Illuminate\Http\Request;

use Input;
use View;
use Form;
use Auth;
use DB;
use Response;
use Session;

use App\Product;
use App\Brand;
use App\Category;
use App\Image;
use App\Review;
use App\FavoritedProduct;
use App\ReportedProduct;
use App\ProductReportingReason;
use App\ReviewReportingReason;
use App\Widget;
use App\ProductList;

class ProductsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'store']]);  
        $this->middleware('isActive', ['only' => ['create', 'store']]);  
        $this->middleware('AjaxAuth', ['only' => ['postToggleFavorited', 'postReport']]);
    }

    public function index() 
    {

        $meta_description = 'List and search all products by category, brand and product name';

        if (!Input::has('order')) {
            $products_query = Product::OrderBy('id', 'DESC');
            $button_highlight = 'button_newest';
        }

        if (Input::get('order') == 'rating') {
            $products_query = Product::OrderBy('rating', 'DESC')->OrderBy('reviews_count', 'DESC');

            $button_highlight = 'button_rating';
        }

        if (Input::get('order') == 'reviews') {
            $products_query = Product::OrderBy('reviews_count', 'DESC');
            $button_highlight = 'button_reviews';
        }

        $category_id = Input::get('category_id');
        $brand_id = Input::get('brand_id');

        if ($category_id > 0 && $brand_id == 0) {
            $products_query->where('category_id', '=', $category_id);

        }

        if ($category_id > 0 && $brand_id > 0) {
            $products_query->where('category_id', '=', $category_id)
            ->where('brand_id', '=', $brand_id);
        }

        if ($category_id == 0 && $brand_id > 0) {
            $products_query->where('brand_id', '=', $brand_id);
        }

        if (Input::has('name')) {
            $products_query->where('name', 'LIKE', '%' . Input::get('name') . '%');
        }

        $products = $products_query->where('active', '=', 1)->paginate(app('settings')->front_end_pagination);

        $brands = Brand::OrderBy('name', 'ASC')
        ->where('id', '>', 1)
        ->lists('name', 'id')->all();

        $brands_all = [0 => 'All'];
        $brand_unspec = [1 => Brand::find(1)->name];

        $brands = $brands_all + $brands + $brand_unspec;

        $categories = Category::OrderBy('name', 'ASC')
        ->where('id', '>', 1)
        ->lists('name', 'id')->all();

        $categories_all = [0 => 'All'];
        $category_unspec = [1 => Category::find(1)->name];

        $categories = $categories_all + $categories + $category_unspec;

        if(Input::has('brand_id') && Input::get('brand_id') <> 0) $brand_name = Brand::find(Input::get('brand_id'))->name; 
        else $brand_name = '';

        if(Input::has('category_id') && Input::get('category_id') <> 0) $category_name = Category::find(Input::get('category_id'))->name; 
        else $category_name = '';

        $widgets = Widget::whereIn('slug', [
            'products-top', 
            'products-bottom', 
            'products-top-right'])
        ->lists('code', 'slug'); 

        return view('products/index', compact(
            'button_highlight',
            'meta_description', 
            'widgets',
            'categories',
            'brands', 
            'products', 
            'brand_name',
            'category_name'));

    }

    public function create()
    {
        $meta_description = 'Add new product';

        $brands = Brand::OrderBy('name', 'ASC')->where('id', '>', 1)->lists('name', 'id')->all();


        $choose_brand = [1 => 'Choose brand'];
        $brand_unspec = [1 => Brand::find(1)->name];


        $brands = $choose_brand + $brand_unspec + $brands;

        $categories = Category::OrderBy('name', 'ASC')->where('id', '>', 1)->lists('name', 'id')->all();


        $choose_category = [1 => 'Choose category'];
        $category_unspec = [1 => Category::find(1)->name];

        $categories = $choose_category + $category_unspec + $categories;

        return view('products/add', compact(
            'meta_description',
            'categories',
            'brands'));

    }

    public function store(Request $request)
    {

        if(app('settings')->users_add_products == 0) return view('errors/custom')
            ->with('error_message', 'Users cannot add new products at the moment');

        $this->validate($request, ['name' => 'required|min:1|unique:products']);

        try {
            $new_product = new Product();
            $new_product->name = Input::get('name');
            $new_product->slug = str_slug(Input::get('name'), '-');
            $new_product->category_id = Input::get('category_id');
            $new_product->brand_id = Input::get('brand_id');
            $new_product->active = 1;
            $new_product->save();

        } catch(\Exception $e) {
            $alert_type = 'error';
            $alert_message = 'Error adding product';
        }

        return redirect('product-' . $new_product->id . '/write_review/')
        ->with('success', 'Product added');
    }

    public function show($product_id)
    {

        $product = Product::where('active', '=', 1)
        ->where('id', '=', $product_id)
        ->first();

        if(!$product) return view('errors/custom')
            ->with('error_message', 'Product not found');

        if(Auth::Guest()) 
            $is_favorited = 0;
        else 
            $is_favorited = FavoritedProduct::where('product_id', '=', $product_id)->count();

        $sort_by = Input::get('sort_by');

        try {

            $reviews = Review::where('product_id', '=', $product_id)->where('active', '=', 1);
            $reviews_count = $reviews->count();

            if (Input::has('review')) $reviews->where('id', '=', Input::get('review'));

            $images = Image::where('product_id', '=', $product_id)->get();


            $top_in_category = Product::where('category_id', '=', $product->category_id)
            ->where('rating', '>', 0)
            ->where('active', '=', 1)
            ->where('discontinued', '=', 0)
            ->OrderBy('rating', 'DESC')
            ->OrderBy('reviews_count', 'DESC')
            ->take(5)
            ->get();

            $top_of_brand = Product::where('brand_id', '=', $product->brand_id)
            ->where('rating', '>', 0)
            ->where('active', '=', 1)
            ->where('discontinued', '=', 0)
            ->OrderBy('rating', 'DESC')
            ->OrderBy('reviews_count', 'DESC')
            ->take(5)
            ->get();

            switch ($sort_by) {
                case 'rating':
                $reviews->OrderBy('rating', 'DESC');

                break;

                case 'helpful':
                $reviews->OrderBy('helpful_sum', 'DESC');                

                break;

                default:
                $sort_by = 'newest';
                $reviews->OrderBy('id', 'DESC');

                break;
            }

            if(Input::has('rating')) {
                $reviews->where('rating', '=', Input::get('rating'));
            }; 

            $reviews = $reviews->where('active', '=', 1)
            ->paginate(app('settings')->front_end_pagination);


            $review_id = null;

            if (User::ReviewedProduct($product_id) == true) {

                $user_reviewed_product = 1;
                $review = Review::where('product_id', '=', $product_id)
                ->first();

                $review_id = $review->id;

            } else {
                $user_reviewed_product = 0;
            }

            $product_rating = round($product->rating);

        } catch(\Exception $e) {
            return view('errors/404');
        }

        $product_reporting_reasons = ProductReportingReason::OrderBy('ID', 'DESC')->get();
        $review_reporting_reasons = ReviewReportingReason::OrderBy('ID', 'DESC')->get();

        if($product->rating > 0)
            $rating = ': rated '.$product->rating.' out of 5. See '.$product->reviews->count().' reviews';
        else $rating = ': not reviewed yet';

        $meta_description = $product->brand->name .' '. $product->name . $rating;

        if($product->images->count() > 0) {
            if($product->rating < 1) $meta_description .= '. See '.$product->images->count(). ' images';
            else $meta_description .= ' and '.$product->images->count(). ' images';
        } 

        $widgets = Widget::whereIn('slug', [
            'product-details-top', 
            'product-details-bottom', 
            'product-details-top-right'])
        ->lists('code', 'slug'); 

        return view('products/show', compact(
            'meta_description',
            'product', 
            'widgets', 
            'is_favorited', 
            'can_edit',
            'product_reporting_reasons', 
            'review_reporting_reasons', 
            'reviews_count', 
            'top_in_category', 
            'top_of_brand', 
            'product_rating', 
            'reviews', 
            'images', 
            'user_reviewed_product', 
            'review_id', 
            'sort_by'));

    }

    public function getFind()
    {
        $meta_description = 'Find product and write a review';
        return view('products/find', compact('meta_description'));
    }


    public function getSearch()
    {

        $name = Input::get('name');

        $words = explode(' ', $name);

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
            foreach($words as $key => $word) 
            {
                if($key > 0) $products_query->orWhere('products.name', 'LIKE', '%' . $word . '%');    
            }
        }

        foreach($words as $word) { 
            $products_query->orWhere('categories.name', 'LIKE', '%' . $word . '%');
            $products_query->orWhere('brands.name', 'LIKE', '%' . $word . '%');
        }    

        $products = $products_query->where('products.active', '=', 1)
        ->GroupBy('products.id')
        ->paginate(app('settings')->front_end_pagination);

        $meta_description = 'Find product and write a review';
        return View::make('home/write_review_results', 
            compact(
                'meta_description', 
                'products'));
    }

    public static function recalculateStats($product_id)
    {

        $reviews_count = Review::where('product_id', '=', $product_id)->where('active', '=', 1)->count();
        $reviews_sum = Review::where('product_id', '=', $product_id)->where('active', '=', 1)->sum('rating');

        $product = Product::find($product_id);
        $product->reviews_count = $reviews_count;

        $product->one_star = Review::where('product_id', '=', $product_id)->where('active', '=', 1)->where('rating', '=', 1)->count();
        $product->two_stars = Review::where('product_id', '=', $product_id)->where('active', '=', 1)->where('rating', '=', 2)->count();
        $product->three_stars = Review::where('product_id', '=', $product_id)->where('active', '=', 1)->where('rating', '=', 3)->count();
        $product->four_stars = Review::where('product_id', '=', $product_id)->where('active', '=', 1)->where('rating', '=', 4)->count();
        $product->five_stars = Review::where('product_id', '=', $product_id)->where('active', '=', 1)->where('rating', '=', 5)->count();

        if($reviews_count > 0)
            $product->rating = $reviews_sum / $reviews_count;
        else $product->rating = 0;

        if($reviews_count > 0) {
            $product->one_star_percent = ($product->one_star / $reviews_count) * 100;
            $product->two_stars_percent = ($product->two_stars / $reviews_count) * 100;
            $product->three_stars_percent = ($product->three_stars / $reviews_count) * 100;
            $product->four_stars_percent = ($product->four_stars / $reviews_count) * 100;
            $product->five_stars_percent = ($product->five_stars / $reviews_count) * 100;
        } else {
            $product->one_star_percent = 0;
            $product->two_stars_percent = 0;
            $product->three_stars_percent = 0;
            $product->four_stars_percent = 0;
            $product->five_stars_percent = 0;
        }

        $product->save();
    }

    public function postToggleFavorited()
    {

        try {

            $favorited = false;
            $unfavorited = false;

            $product_id = Session::get('next_action_item');

            if(!FavoritedProduct::where('product_id', '=', $product_id)->exists()) {
                $favorite = new FavoritedProduct();
                $favorite->product_id = $product_id;

                $favorite->save();

                $favorited = true;
                $message = 'Product favorited';

            } else {

                $favorite = FavoritedProduct::where('product_id', '=', $product_id)
                ->delete();

                $unfavorited = true;
                $message = 'Product unfavorited';
            }
        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => 'Error (un)favoriting product'], 400);
        }

        return Response::json([
            'success' => true,
            'favorited' => $favorited, 
            'unfavorited' => $unfavorited,         
            'message' => $message], 200);
    }

    public function postReport()
    {

        try {

            if(app('settings')->users_report_products) {
                $product_id = Session::get('next_action_item');
                $product = Product::find($product_id);
                $product->reported = 1;
                $product->save();

                $reported = new ReportedProduct();
                $reported->product_id = $product_id;
                if(Input::get('comment') == '') $reported->reason = Input::get('reason'); else 
                $reported->reason = Input::get('reason').':<br />'.Input::get('comment');
                $reported->save();                

            } else {
                return Response::json([
                    'success' => false,
                    'message' => 'Users cannot report products'], 400);
            }

        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => 'Error reporting product'], 400);
        }

        return Response::json([
            'success' => true,
            'reported' => true,
            'message' => 'Product reported'], 200);
    }   

    public function getFeaturedLists()
    {
        $meta_description = 'List and search all products by category, brand and product name';

        $featured_product_lists = ProductList::OrderBy('updated_at', 'DESC')
        ->where('public', '=', 1)
        ->where('featured', '=', 1)
        ->paginate(12);

        return View::make('products/featured', 
            compact(
                'meta_description', 
                'featured_product_lists'));
    }

}
