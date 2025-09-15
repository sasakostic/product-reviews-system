<?php

use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('products', function ($table) {
			$table->increments('id')->unsigned()->index();
			$table->string('name')->index();
			$table->string('slug');
			$table->text('description');
			$table->integer('category_id')->unsigned()->default(1)->index();
			$table->integer('brand_id')->unsigned()->default(1)->index();
			$table->integer('image_id')->unsigned()->index()->nullable();
			$table->decimal('rating', 2,1)->default(0);
			$table->integer('reviews_count')->default(0);
			$table->integer('one_star')->default(0);
			$table->integer('two_stars')->default(0);
			$table->integer('three_stars')->default(0);
			$table->integer('four_stars')->default(0);
			$table->integer('five_stars')->default(0);
			$table->integer('one_star_percent')->default(0);
			$table->integer('two_stars_percent')->default(0);
			$table->integer('three_stars_percent')->default(0);
			$table->integer('four_stars_percent')->default(0);
			$table->integer('five_stars_percent')->default(0);
			$table->text('affiliate_code');
			$table->tinyInteger('discontinued')->default(0)->index()->nullable();
			$table->tinyInteger('reported')->default(0)->index();
			$table->tinyInteger('active')->default(0)->index();
			$table->timestamps();			

			$table->foreign('category_id')
			->references('id')->on('categories')
			->onDelete('cascade');

			$table->foreign('brand_id')
			->references('id')->on('brands')
			->onDelete('cascade');	
			
		});
		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('products');
	}

}
