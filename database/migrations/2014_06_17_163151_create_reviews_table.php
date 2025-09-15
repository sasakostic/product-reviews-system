<?php

use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('reviews', function ($table) {
			$table->increments('id')->unsigned()->index();
			$table->integer('user_id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->string('title', 100);
			$table->string('pros', 255);
			$table->string('cons', 255);
			$table->text('text');
			$table->integer('rating');
			$table->integer('helpful_yes')->default(0);
			$table->integer('helpful_no')->default(0);
			$table->integer('helpful_sum')->default(0);
			$table->tinyInteger('active')->default(0);
			$table->tinyInteger('reported')->default(0);
			$table->timestamp('featured_on')->nullable();
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
		Schema::drop('reviews');
	}

}
