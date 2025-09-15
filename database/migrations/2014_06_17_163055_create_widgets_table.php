<?php

use Illuminate\Database\Migrations\Migration;

class CreateWidgetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('widgets', function ($table) {
			$table->increments('id')->unsigned()->index();
			$table->string('name');
			$table->string('slug')->index();
			$table->text('code');			
			$table->timestamps();			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('widgets');
	}

}
