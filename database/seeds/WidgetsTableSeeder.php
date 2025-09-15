<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Widget;

class WidgetsTableSeeder extends Seeder {

	public function run() {
		
		Widget::truncate();

		$widgets = array(
			
			//Home widgets
			array(
				'name' => 'Home top',
				'code' => '',
				'slug' => 'home-top',
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),
			array(
				'name' => 'Home bottom',			
				'code' => '',
				'slug' => 'home-bottom',
			
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),			
			array(
				'name' => 'Home top right',				
				'code' => '',
				'slug' => 'home-top-right',	
			
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),		

			//Search results widgets
			array(
				'name' => 'Search results top',
				'code' => '',
				'slug' => 'search-results-top',
			
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),
			array(
				'name' => 'Search results bottom',			
				'code' => '',
				'slug' => 'search-results-bottom',		
			
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),			
			array(
				'name' => 'Search results top right',				
				'code' => '',
				'slug' => 'search-results-top-right',	
			
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),

			//Products widgets
			array(
				'name' => 'Products top',
				'code' => '',
				'slug' => 'products-top',
			
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),
			array(
				'name' => 'Products bottom',			
				'code' => '',
				'slug' => 'products-bottom',		
			
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),			
			array(
				'name' => 'Products top right',				
				'code' => '',
				'slug' => 'products-top-right',	
			
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),	


			//Product details widgets
			array(
				'name' => 'Product details top',
				'code' => '',
				'slug' => 'product-details-top',
			
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),
			array(
				'name' => 'Products details bottom',			
				'code' => '',
				'slug' => 'product-details-bottom',		
			
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),			
			array(
				'name' => 'Products details top right',				
				'code' => '',
				'slug' => 'product-details-top-right',	
			
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),	

			//Reviews widgets
			array(
				'name' => 'Reviews top',
				'code' => '',
				'slug' => 'reviews-top',
			
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),
			array(
				'name' => 'Reviews bottom',			
				'code' => '',
				'slug' => 'reviews-bottom',		
			
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),			
			array(
				'name' => 'Reviews top right',				
				'code' => '',
				'slug' => 'reviews-top-right',	
			
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),


			//Categories widgets
			array(
				'name' => 'Categories top',
				'code' => '',
				'slug' => 'categories-top',
			
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),
			array(
				'name' => 'Categories bottom',			
				'code' => '',
				'slug' => 'categories-bottom',		
			
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),			
			array(
				'name' => 'Categories top right',				
				'code' => '',				
				'slug' => 'categories-top-right',	
			
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),


			//Brands widgets
			array(
				'name' => 'Brands top',
				'code' => '',
				'slug' => 'brands-top',										
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),
			array(
				'name' => 'Brands bottom',			
				'code' => '',
				'slug' => 'brands-bottom',												
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),			
			array(
				'name' => 'Brands top right',				
				'code' => '',
				'slug' => 'brands-top-right',											
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),

			//User profil widgets
			array(
				'name' => 'User profile top',
				'code' => '',
				'slug' => 'user-profile-top',										
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),
			array(
				'name' => 'User profile bottom',			
				'code' => '',
				'slug' => 'user-profile-bottom',												
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),			
			array(
				'name' => 'User profile top right',				
				'code' => '',
				'slug' => 'user-profile-top-right',											
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				),


			);

DB::table('widgets')->insert($widgets);
}

}