<?php namespace App\Http\Middleware;

use Closure;
use Response;
use Request;
use Session;
use Input;

class AJAX {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if(!Request::ajax()) {
			return Response::json([
				'success' => false, 
				'message' => 'Not ajax request'], 400);
		}

		return $next($request);
	}

}
