<?php

/////////////////////// Remove: ////////////////////////
Route::controller('dev', 'DevelopmentController');
////////////////////////////////////////////////////////

Route::group(['prefix' => 'admin'], function () {

	Route::get('products/delete/{product_id}', 'Admin\ProductsController@destroy');
	Route::get('products/delete/{product_id}/{go_back}', 'Admin\ProductsController@destroy');	

	Route::get('categories/delete/{category_id}', 'Admin\CategoriesController@destroy');
	Route::get('categories/delete/{category_id}/{go_back}', 'Admin\CategoriesController@destroy');
	Route::post('categories/delete-non-empty', 'Admin\CategoriesController@postDeleteNonEmpty');

	Route::get('brands/delete/{brand_id}', 'Admin\BrandsController@destroy');
	Route::get('brands/delete/{brand_id}/{go_back}', 'Admin\BrandsController@destroy');
	Route::post('brands/delete-non-empty', 'Admin\BrandsController@postDeleteNonEmpty');

	Route::get('reviews/delete/{review_id}', 'Admin\ReviewsController@destroy');
	Route::get('reviews/delete/{review_id}/{go_back}', 'Admin\ReviewsController@destroy');

	Route::get('images/delete/{image_id}', 'Admin\ImagesController@destroy');

	Route::get('pages/delete/{page_id}', 'Admin\PagesController@destroy');
	Route::get('pages/delete/{page_id}/{go_back}', 'Admin\PagesController@destroy');

	Route::get('/', 'Admin\DashboardController@getIndex');
	Route::get('search', 'Admin\DashboardController@getSearch');

	Route::resource('products', 'Admin\ProductsController', 
		['except' => ['show']]);	

	Route::resource('reviews', 'Admin\ReviewsController', 
		['except' => ['create', 'store', 'show']]);	

	Route::resource('categories', 'Admin\CategoriesController', 
		['except' => ['show']]);	

	Route::resource('brands', 'Admin\BrandsController', 
		['except' => ['show']]);	

	Route::resource('images', 'Admin\ImagesController', 
		['except' => ['create', 'store', 'show']]);	

	Route::resource('widgets', 'Admin\WidgetsController', 
		['except' => ['create', 'store', 'destroy']]);	

	Route::resource('pages', 'Admin\ReviewsController');	


	Route::controllers([
		'products' => 'Admin\ProductsController',
		'reviews' => 'Admin\ReviewsController',
		'categories' => 'Admin\CategoriesController',
		'brands' => 'Admin\BrandsController',
		'images' => 'Admin\ImagesController',
		'settings' => 'Admin\SettingsController',
		'pages' => 'Admin\PagesController',
		]);

});

Route::get('/', 'HomeController@getIndex');
Route::get('search', 'HomeController@getSearch');
Route::get('add_product', 'ProductsController@create');

Route::get('register', 'RegistrationController@index');
Route::post('register', 'RegistrationController@store');

Route::get('confirm/{confirmationCode}', 'RegistrationController@confirmEmail');

Route::get('product/{product_id}/{slug?}', 'ProductsController@show');

Route::get('product-{product_id}/write_review', 'ReviewsController@create');
Route::get('reviews/delete/{review_id}', 'ReviewsController@destroy'); 

Route::get('page/{page_slug}', 'PagesController@show');

Route::get('sitemap.xml', 'SitemapController@generate');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'login' => 'LoginController',
	'products' => 'ProductsController',
	'reviews' => 'ReviewsController',
	'categories' => 'CategoriesController',
	'brands' => 'BrandsController',
	'contact' => 'ContactController',
	]);

Route::resource('products', 'ProductsController', 
	['except' => ['destroy']]);	

Route::resource('reviews', 'ReviewsController', 
	['except' => ['show']]);	

Route::resource('account/images', 'ImagesController', 
	['except' => ['create', 'show']]);	

Route::resource('categories', 'CategoriesController', 
	['only' => ['index']]);	

Route::resource('brands', 'BrandsController', 
	['only' => ['index']]);	

Route::resource('account/lists', 'ProductListsController', 
		['except' => ['show']]);

Route::controller('account/images', 'ImagesController');

Route::get('logout', 'LoginController@getLogout');


