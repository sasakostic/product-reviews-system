<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Setting;
class SettingsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		//DB::table('categories')->delete();
		Setting::truncate();

		$settings = array (
				array(
				'id' => 1,
				
				'site_name' => 'Reviews',
				'site_description' => 'Product Reviews and Ratings',
				'meta_description' => 'Product reviews',
								
				'logo' => 'logo.png',
				'favicon' => 'favicon.ico',
				
				'header_code'	=>	'',
				'footer_code' => '',
				'date_format'	=>	'M j, Y',
				
				'product_sm_thumb_w'	=>	60, 
				'product_sm_thumb_h'	=>	60, 

				'product_main_thumb_w'	=>	200, 
				'product_main_thumb_h'	=>	200, 

				'front_end_pagination'	=>	7,		
				'admin_products_pagination'	=>	7,
				'admin_reviews_pagination'	=>	7,
				'admin_images_pagination'	=>	7,
				'admin_categories_pagination'	=>	7,
				'admin_brands_pagination'	=>	7,
				'admin_users_pagination'	=>	7,
				
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),
		);

		DB::table('settings')->insert($settings);
	}

}
