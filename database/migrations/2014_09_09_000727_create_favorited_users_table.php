<?php

use Illuminate\Database\Migrations\Migration;

class CreateFavoritedUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('favorited_users', function ($table) {
			$table->increments('id')->unsigned()->index();
			$table->integer('favorited_user_id')->unsigned()->index();
			$table->timestamps();				
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('favorited_users');
	}

}
