<?php namespace App\Exceptions;

use Exception;
use PDOException;
use ErrorException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;

use Redirect;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
	'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		
		if($e instanceof NotFoundHttpException)
		{
			return response()->view('errors/404');
		}

		elseif($e instanceof TokenMismatchException)
		{
			return response()->view('errors/token');
		}
		
		elseif($e instanceof PDOException)
		{
			if(!file_exists(storage_path('app/installed')))
			return Redirect::to('install.php');
			else return response()->view('errors/error');
		}
		
		elseif ($e instanceof ErrorException) {
			return response()->view('errors/error_null');
		}

		elseif ($e instanceof ModelNotFoundException) {
			return response()->view('errors/404');
		}
		

		elseif($e instanceof QueryException)
		{
			if(!file_exists(storage_path('app/installed')))
			return Redirect::to('install.php');
			else return response()->view('errors/error');
		}
		
		else return response()->view('errors/error');
		//return parent::render($request, $e);


	}

}
