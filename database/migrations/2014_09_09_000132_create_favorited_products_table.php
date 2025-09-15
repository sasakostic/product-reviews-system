<?php

use Illuminate\Database\Migrations\Migration;

class CreateFavoritedProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('favorited_products', function ($table) {
			$table->increments('id')->unsigned()->index();
			$table->integer('product_id')->unsigned()->index();
			$table->timestamps();			
			
			$table->foreign('product_id')
			->references('id')->on('products')
			->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('favorited_products');
	}

}
