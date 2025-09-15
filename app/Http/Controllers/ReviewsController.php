<?php namespace App\Http\Controllers;

use App\Http\Controllers\ProductsController as Products;

use Auth;
use Input;
use View;
use Redirect;
use DB;
use Response;
use Request;
use Session;

use App\Review;
use App\Brand;
use App\Category;
use App\Product;
use App\FavoritedReview;
use App\HelpfulReview;
use App\ReportedReview;
use App\ReviewReportingReason;
use App\Widget;

class ReviewsController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth', ['only' => ['create', 'store', 'edit', 'update']]);    
        $this->middleware('isActive', ['only' => ['create', 'store', 'edit', 'update']]);    

        $this->middleware( 'AjaxAuth', ['only' => ['postHelpful', 'postToggleFavorited','postReport']]);            

    }

    public function index()
    {

        $search_terms = Input::get('search_terms');
        $category_id = Input::get('category_id');
        $brand_id = Input::get('brand_id');        

        try {

            $reviews_query = Review::select(DB::raw('reviews.*'))
            ->Join('products as p', 'reviews.product_id', '=', 'p.id')
            ->Join('categories as c', 'p.category_id', '=', 'c.id')
            ->Join('brands as b', 'p.brand_id', '=', 'b.id')
            ->leftJoin('helpful_reviews as h', 'reviews.id', '=', 'h.review_id')
            ->where('reviews.active', '=', 1)
            ->GroupBy('reviews.id');
            $button_highlight = 'button_newest';


            if ($category_id > 0 && $brand_id == 0) {
                $reviews_query->where('c.id', $category_id);
            }

            if ($category_id > 0 && $brand_id > 0) {
                $reviews_query->where('c.id', '=', $category_id)
                ->where('b.id', '=', $brand_id);
            }

            if ($category_id == 0 && $brand_id > 0) {
                $reviews_query->where('b.id', '=', $brand_id);
            }

        
            if (Input::has('featured')) {
                $reviews_query->whereNotNull('featured_on');
            }

            if(Input::has('search_terms')) {
                $reviews_query->where('reviews.text', 'LIKE', '%' . $search_terms . '%')
                ->orWhere('title', 'LIKE', '%' . $search_terms . '%')
                ->orWhere('pros', 'LIKE', '%' . $search_terms . '%')
                ->orWhere('cons', 'LIKE', '%' . $search_terms . '%');
            }

            $reviews = $reviews_query->OrderBy('reviews.id', 'DESC')->paginate(app('settings')->front_end_pagination);

            $brands = Brand::orderBy('name', 'ASC')->where('id', '>', 1)->lists('name', 'id')->all();
            $brands_all = [0 => 'All'];
            $brand_unspec = [1 => Brand::find(1)->name];
            $brands = $brands_all + $brands + $brand_unspec;

            $categories = Category::orderBy('name', 'ASC')->where('id', '>', 1)->lists('name', 'id')->all();
            $categories_all = [0 => 'All'];
            $category_unspec = [1 => Category::find(1)->name];
            $categories = $categories_all + $categories + $category_unspec;
        }

        catch(\Exception $e) {
        }

        $review_reporting_reasons = ReviewReportingReason::OrderBy('ID', 'DESC')->get();
        $meta_description = 'List and search all product reviews';

        $widgets = Widget::whereIn('slug', [
            'reviews-top', 
            'reviews-bottom', 
            'reviews-top-right'])
        ->lists('code', 'slug'); 
        
        return view('reviews/index', compact(
            'meta_description', 
            'widgets',
            'reviews',
            'review_reporting_reasons',
            'categories', 
            'brands', 
            'search_terms', 
            'button_highlight'));
    }

    public function create($product_id)
    {
        if (\App\Http\Controllers\UserController::reviewedProduct($product_id) == true) {

            $review = Review::where('product_id', '=', $product_id)->first();

            $review->id;

            return redirect('reviews/' . $review->id . '/edit');

        }  else {
            $product = Product::find($product_id);
            $meta_description = 'Write review for '.$product->brand->name.' '.$product->name;
            return view('products/write_review', compact('meta_description', 'product'));

        }
    }

    public function store()
    {

        $product_id = Input::get('product_id');

    //try catch
        $review = new Review();
        $review->product_id = $product_id;

        $review->rating = Input::get('rating');

       

            $message = "Review will be visible after it gets approved";
        } else {
            $review->active = 1;

            $message = "Review added";
        }

        if (app('settings')->review_title == 1) $review->title = Input::get('title');

        if (app('settings')->review_pros_cons == 1) {
            $review->pros = Input::get('pros');

            $review->cons = Input::get('cons');
        }

        $review->text = Input::get('text');

        $review->save();


        $product = Product::find($product_id);

        Products::recalculateStats($product_id);

        return redirect('product/' . $product->id . '/' . $product->slug)
        ->with('success', $message);

    }

    public function edit($review_id)
    {

        if (app('settings')->review_edit == 0) return view('errors/404');

        $review = Review::find($review_id);
      
    }

    public function update($review_id)
    { 

        if (app('settings')->review_edit == 0) return view('errors/404');

        $review = Review::find($review_id);
        if (/* */) {
            $review->rating = Input::get('rating');
            $review->title = Input::get('title');
            $review->pros = Input::get('pros');
            $review->cons = Input::get('cons');
            $review->text = Input::get('text');
            $review->save();

            Products::recalculateStats($review->product_id);

            return Redirect::to('account/reviews')
            ->with('success', 'Review updated');
        } else {
            return view('errors/404');
        }
    }

    public function destroy($review_id)
    {

        if (app('settings')->review_delete == 0) return view('errors/404');

        try {
            $review = Review::find($review_id);
            if (/* */) {
                $product_id = $review->product_id;
                $review->delete();
                Products::recalculateStats($product_id);
            } else {
                return Redirect::to('account/reviews')->with('error', 'Error deleting review');
            }
        } catch(\Exception $e) {

            return Redirect::to('account/reviews')->with('error', 'Error deleting review');
        }

        return Redirect::to('account/reviews')->with('success', 'Review deleted');
    }

    public function postHelpful()
    {

        try {

            $review_id = Session::get('next_action_item');

            $review = Review::find($review_id);

            if(!$review) {
                return Response::json([
                    'success' => false,
                    'message' => 'Review not found'], 200);
            }

            if($review->active == 0) {
                return Response::json([
                    'success' => false,
                    'message' => 'Review currently not active'], 200);
            }

            if(/* */) {
                return Response::json([
                    'success' => false,
                    'message' => 'You cannot vote for your own review'], 200);
            }

            if(!HelpfulReview::->where('review_id', '=', $review_id)->exists()) {
                $helpful = Session::get('helpful_item');

                switch ($helpful) {
                    case '1':
                    $review->helpful_yes = $review->helpful_yes + 1;
                    $review->helpful_sum = $review->helpful_sum + 1;
                    break;

                    case '0':
                    $review->helpful_no = $review->helpful_no + 1;
                    $review->helpful_sum = $review->helpful_sum -1;
                    break;

                    default:
                    break;
                }

                $helpful_review_new = new HelpfulReview();
                $helpful_review_new->review_id = $review_id;
                $helpful_review_new->save();

                $review->save();       

            } else {
                return Response::json([
                    'success' => false,
                    'message' => 'Already voted'], 200);
            }

        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => 'Error'], 400);
        }

        return Response::json([
            'success' => true,
            'message' => 'Thank you'], 200);      

    }

    public function postToggleFavorited()
    {

        try {

            $favorited = false;
            $unfavorited = false;

            $review_id = Session::get('next_action_item');

            if(!FavoritedReview::where('review_id', '=', $review_id)->exists())
            {
                $favorite = new FavoritedReview();
                $favorite->review_id = $review_id;

                $favorite->save();   

                $favorited = true;
                $message = 'Review favorited';

            } else { 

                $favorite = FavoritedReview::where('review_id', '=', $review_id)
                ->delete();

                $unfavorited = true;
                $message = 'Review unfavorited';
            }

        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => 'Error (un)favoriting review'], 400);   
        }

        return Response::json([
            'success' => true,
            'favorited' => $favorited, 
            'unfavorited' => $unfavorited,         
            'message' => $message], 200);    

    }

    public static function isFavorited($review_id)
    {

        if(Auth::Guest()) return false;

        $favorited = FavoritedReview::where('review_id', '=', $review_id)->count();
        if ($favorited > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function postReport()
    {

        try {

            $review_id = Session::get('next_action_item');
            $review = Review::find($review_id);
            $review->reported = 1;
            $review->save();

            $reported = new ReportedReview();
            $reported->review_id = $review_id;
            if(Input::get('comment') == '') $reported->reason = Input::get('reason'); else 
            $reported->reason = Input::get('reason').':<br />'.Input::get('comment');
            $reported->save();
        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => 'Error reporting review'], 400);    
        }

        return Response::json([
            'success' => true,
            'message' => 'Review reported'], 200);    
    }
}
