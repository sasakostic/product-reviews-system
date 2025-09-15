<?php

use Illuminate\Database\Migrations\Migration;

class CreateReportedProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('reported_products', function ($table) {
			$table->increments('id')->unsigned()->index();
			$table->integer('product_id')->unsigned();
			$table->string('reason');
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
		Schema::drop('reported_products');
	}

}
