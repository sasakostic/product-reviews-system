<?php

use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('images', function ($table) {
			$table->increments('id')->unsigned()->index();
			$table->integer('product_id')->unsigned();
			$table->string('file_name');
			$table->string('description', 100);
			$table->timestamps();

		});
				
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('images');
	}

}
