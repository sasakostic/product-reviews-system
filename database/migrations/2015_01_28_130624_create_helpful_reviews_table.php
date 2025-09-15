<?php

use Illuminate\Database\Migrations\Migration;

class CreateHelpfulReviewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('helpful_reviews', function ($table) {
			$table->increments('id')->unsigned()->index();
			$table->integer('review_id')->unsigned()->index();
			$table->timestamps();			
			
			$table->foreign('review_id')
			->references('id')->on('reviews')
			->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('helpful_reviews');
	}

}
