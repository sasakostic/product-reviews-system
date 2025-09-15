<?php

use Illuminate\Database\Migrations\Migration;

class CreateReportedReviewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('reported_reviews', function ($table) {
			$table->increments('id')->unsigned()->index();
			$table->integer('review_id')->unsigned();
			$table->string('reason');
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
		Schema::drop('reported_reviews');
	}

}
