<?php

use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('categories', function ($table) {
			$table->increments('id')->unsigned()->index();
			$table->string('name')->index();
			$table->string('slug');
			$table->text('meta_description', 160);
			$table->integer('featured')->default(0);
			$table->timestamps();			
		});
		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('categories');
	}

}
