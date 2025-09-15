<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use View;
use Schema;
use Auth;
use Request;

use App\Setting;
use App\Page;

class EmptySettings{}

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	
	public function boot()
	{
		$this->app->singleton('settings', function ($app) {
			try {
				$settings = Setting::first();
			} catch (\Exception $e) {

				$settings = new EmptySettings();
				$settings->site_name = '';
				$settings->meta_description = '';
				$settings->meta_description = '';

				$settings->facebook = '';
				$settings->twitter = '';
				$settings->youtube = '';

				$settings->date_format = '';

				$settings->logo = '';
				$settings->favicon = '';

				$settings->header_code = '';
				$settings->footer_code = '';

				$settings->mail_to_address = '';
				$settings->mail_to_name = '';
				
				$settings->review_moderation = '';
				$settings->review_title = '';
				$settings->review_pros_cons = '';
				$settings->review_len = '';
				$settings->review_preview_len = '';
				$settings->review_report = '';
				$settings->review_favorite = '';
				$settings->review_helpful = '';
				$settings->review_writing_tips = '';
				$settings->review_edit = '';
				$settings->review_delete = '';

				$settings->product_description_len = '';

				$settings->users_add_products = '';
				$settings->users_add_product_images = '';
				$settings->users_list_product_images = '';
				$settings->users_delete_product_images = '';
				$settings->users_report_products = '';

				$settings->product_sm_thumb_w = '';
				$settings->product_sm_thumb_h = '';

				$settings->product_main_thumb_w = '';
				$settings->product_main_thumb_h = '';

				$settings->email_confirmation = '';
				$settings->recaptcha_registration = '';
				$settings->recaptcha_contact = '';

				$settings->front_end_pagination = '';

				$settings->admin_products_pagination = '';
				$settings->admin_reviews_pagination = '';
				$settings->admin_images_pagination = '';
				$settings->admin_categories_pagination = '';
				$settings->admin_brands_pagination = '';
				$settings->admin_users_pagination = '';

				$settings->new_products_since = '';
				$settings->new_reviews_since = '';
				$settings->new_images_since = '';
				$settings->new_users_since = '';

				return $settings;	
			}			
			return $settings;
		});
		
		$this->app->singleton('pages', function ($app) {
			try {
				$pages = Page::all();	
			} catch (\Exception $e) {
				return null;
			}			
			return $pages;
		});
		
		view()->share([
			'settings' => app('settings'), 
			'pages' => app('pages')
			]);	

		view()->composer('*', function ($view) {

			$menu_highlight = \Request::segment(1);
			$sidebar_highlight = \Request::segment(2);
						
			$view->with('menu_highlight', $menu_highlight)
			->with('sidebar_highlight', $sidebar_highlight);

		});
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
			);
	}

}
