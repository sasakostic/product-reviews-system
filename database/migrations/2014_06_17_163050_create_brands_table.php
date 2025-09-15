<?php

use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('brands', function ($table) {
			$table->increments('id')->unsigned()->index();
			$table->string('name')->index();
			$table->string('slug');
			$table->text('meta_description', 160);
			$table->timestamps();			
		});
		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('brands');
	}

}
