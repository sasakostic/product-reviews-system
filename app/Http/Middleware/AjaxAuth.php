<?php namespace App\Http\Middleware;

use Closure;
use Auth;
use Response;
use Request;
use Session;
use Input;

class AjaxAuth {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if(Input::has('next_action') && Input::get('next_action') != 'report_product' && Input::get('next_action') != 'report_review') {


			Session::set('next_action', Input::get('next_action'));
			Session::set('next_action_item', Input::get('next_action_item'));
			Session::set('helpful_item', Input::get('helpful_item'));
		}

		if(!Request::ajax()) {

			return Response::json([
				'success' => false, 
				'message' => 'Not ajax request'], 400);

		} else {

			if (Auth::guest()) 
				return Response::json([
					'success' =>false,
					'logged_in' => false], 401);           							
		}

		return $next($request);
	}

}
