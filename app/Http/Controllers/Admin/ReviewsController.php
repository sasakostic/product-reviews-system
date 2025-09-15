<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\SettingsController as Settings;
use App\Http\Controllers\ProductsController as Products;
use Illuminate\Http\Request;

use Input;
use View;
use Redirect;
use Auth;
use URL;
use Carbon\Carbon;
use Response;
use Session;

use App\Review;
use App\Product;
use App\User;
use App\ReportedReview;

class ReviewsController extends Controller
{

    public $reported_count;
    public $unpublished_count;
    public $featured_count;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['postUnflag', 'postTogglePublished', 'postToggleFeatured']]);
        $this->middleware('isAdmin');
        $this->middleware('AjaxAuth', ['only' => ['postUnflag', 'postTogglePublished', 'postToggleFeatured']]);

        $this->reported_count = Review::where('reported', '=', 1)->count();
        $this->unpublished_count = Review::where('active', '=', 0)->count();
        $this->featured_count = Review::where('active', '=', 1)->WhereNotNull('featured_on')->count();

    }

    public function index() 
    {

        Settings::set('new_reviews_since',  Carbon::now());

        $button_highlight = 'button_newest';

        $reviews_query = Review::orderBy('reviews.id', 'DESC');

        if (Input::has('search_terms') && !Input::has('reported') && !Input::has('published')) {
            $search_terms = Input::get('search_terms');
            
            $reviews_query->where('text',  'LIKE', '%'.$search_terms.'%')
            ->orWhere('title',  'LIKE', '%'.$search_terms.'%')
            ->orWhere('pros',  'LIKE', '%'.$search_terms.'%')
            ->orWhere('cons',  'LIKE', '%'.$search_terms.'%')
            ->orWhere('ID', '=', $search_terms);
        }

        $filter = '';

        if (Input::has('product_id')) {
            $product_id = Input::get('product_id');
            $reviews_query->where('product_id', '=', Input::get('product_id'));
            $filter = 'of product' . ' ' . Product::find($product_id)->name;
        }

        $reviews = $reviews_query->paginate(app('settings')->admin_reviews_pagination);

        return view('admin/reviews/index', compact(
            'button_highlight',
            'filter', 
            'reviews'))
        ->with('reported_count', $this->reported_count)
        ->with('unpublished_count', $this->unpublished_count)
        ->with('featured_count', $this->featured_count);
    }

    public function getSearch()
    {

    }

    public function getReported()
    {
        $reviews = Review::orderBy('reviews.id', 'DESC')
        ->where('reported', '=', 1)
        ->paginate(app('settings')->admin_reviews_pagination);
        
        $filter = '';

        $button_highlight = 'button_reported';

        return view('admin/reviews/index', compact(
            'button_highlight',
            'filter',
            'reviews'))
        ->with('reported_count', $this->reported_count)
        ->with('unpublished_count', $this->unpublished_count)
        ->with('featured_count', $this->featured_count);
    }

    public function getUnpublished()
    {
        $reviews = Review::orderBy('reviews.id', 'DESC')
        ->where('active', '=', 0)
        ->paginate(app('settings')->admin_reviews_pagination);
        
        $filter = '';
        
        $button_highlight = 'button_unpublished';

        return view('admin/reviews/index', compact(
            'button_highlight',
            'filter',
            'reviews'))
        ->with('reported_count', $this->reported_count)
        ->with('unpublished_count', $this->unpublished_count)
        ->with('featured_count', $this->featured_count);
    }

    public function getFeatured()
    {
        $reviews = Review::orderBy('featured_on', 'DESC')
        ->whereNotNull('featured_on')
        ->paginate(app('settings')->admin_reviews_pagination);
        
        $filter = '';

        $button_highlight = 'button_featured';

        return view('admin/reviews/index', compact(
            'button_highlight',
            'filter',
            'reviews'))
        ->with('reported_count', $this->reported_count)
        ->with('unpublished_count', $this->unpublished_count)
        ->with('featured_count', $this->featured_count);
    }

    
    public function getByProduct($product_id)
    {
        $reviews = Review::orderBy('reviews.id', 'DESC')
        ->where('product_id', '=', $product_id)
        ->paginate(app('settings')->admin_reviews_pagination);
        
        $filter = 'for product ' . Product::find($product_id)->name;

        $button_highlight = 'button_newest';

        return view('admin/reviews/index', compact(
            'button_highlight',
            'filter',
            'reviews'))
        ->with('reported_count', $this->reported_count)
        ->with('unpublished_count', $this->unpublished_count)
        ->with('featured_count', $this->featured_count);
    }

    public function edit($id) 
    {

        try {
            $review = Review::find($id);
        } catch(\Exception $e) {
            return Redirect::to('admin/reviews')->with('error', 'Review not found');
        }

        return view('admin/reviews/edit', compact('review'));
    }

    public function update(Request $request, $id) 
    {

        $this->validate($request, ['text' => 'required|min:10']);

        try {
            $review = Review::find($id);
            $review->title = Input::get('title');
            $review->pros = Input::get('pros');
            $review->cons = Input::get('cons');
            $review->text = Input::get('text');
            if(Input::has('featured'))
                $review->featured_on = Carbon::now();
            else $review->featured_on = NULL; 
            $review->active = Input::get('active');
            $review->save();
            Products::recalculateStats($review->product_id);
        } catch(\Exception $e) {
            return Redirect::to('admin/reviews/' . $id)->with('error', 'Error updating review');
        }

        return Redirect::to('admin/reviews/' . $id . '/edit')->with('success', 'Review updated')->with('review', $review);
    }

    public function postTogglePublished() 
    {
        try {

            $published = false;
            $unpublished = false;

            $id = Session::get('next_action_item');
            $review = Review::find($id);
            $product_id = $review->product_id;

            if ($review->active == 0) {
                $review->active = 1;
                $published = true;
                $message = 'Review published';
            } else {
                $review->active = 0;
                $unpublished = true;
                $message = 'Review unpublished';
            }

            $review->save();
            Products::recalculateStats($product_id);
        } catch (\Exception $e) {
            return Response::json([
                'success' => false, 
                'message' => 'Error un/publishing review'], 400);
        }

        return Response::json([
            'success' => true,
            'published' => $published, 
            'unpublished' => $unpublished,
            'message' => $message], 200);
    }


    public function postToggleFeatured() 
    {

        $featured = false;
        $unfeatured = false;

        try {

            $id = Session::get('next_action_item');

            $review = Review::find($id);

            if($review->featured_on == NULL)
            {
                $review->featured_on = Carbon::now();
                $review->save();

                $featured = true;
                $unfeatured = false;                
                $message = 'Review featured';                

            } else { 
                $review->featured_on = NULL;
                $review->save();

                $unfeatured = true;
                $featured = false;
                $message = 'Review unfeatured';
            }

        } catch (\Exception $e) {
            return Response::json([
                'success' => false, 
                'message' => 'Error un/featuring review'], 400);
        }

        return Response::json([
            'success' => true,
            'featured' => $featured, 
            'unfeatured' => $unfeatured,
            'message' => $message], 200);
    }

    public function postUnflag() 
    {

        try {

            $id = Session::get('next_action_item');
            $review = Review::find($id);
            $review->reported = 0;

            $review->save();

            ReportedReview::where('review_id', '=', $id)->delete();

        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => 'Error unflagging review'], 400);
        } 

        return Response::json([
            'success' => true,
            'unflagged' => true,
            'message' => 'Review unflagged'
            ], 200);
    }

    public function postMultipleDelete()
    {

        $selected_reviews = Input::get('reviews');

        $cnt = 0;

        foreach($selected_reviews as $review_id) {
            $this->destroy($review_id, $back=false);
            $cnt++;
        } 

        return Redirect::back()
        ->with('success',  $cnt.' reviews deleted');
    }

    public function destroy($id, $go_back = true) 
    {

        $alert_type = 'success';
        $alert_message = 'Review deleted';

        try {
            $review = Review::find($id);
            $product_id = $review->product_id;
            $review->delete();
            Products::recalculateStats($product_id);
        } catch(\Exception $e) {
            $alert_type = 'error';
            $alert_message = 'Error deleting user';
        }

        if ($go_back == false) {
            return Redirect::to('admin/reviews')->with($alert_type, $alert_message);
        }

        return Redirect::back()->with($alert_type, $alert_message);
    }

    public function getUpdatePagination($per_page=null)
    {
        if(is_numeric($per_page)) {
            Settings::set('admin_reviews_pagination', $per_page);
            return Redirect::back();
        } else
        return Redirect::back()->with('error', 'Error updating pagination');    
    }

}
