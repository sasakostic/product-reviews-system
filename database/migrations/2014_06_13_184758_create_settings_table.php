<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('settings', function (Blueprint $table) {
			
			$table->increments('id')->unsigned()->index();

			$table->string('site_name');
			$table->string('site_description');
			$table->string('meta_description');
			
			$table->string('facebook');
			$table->string('twitter');
			$table->string('youtube');
			
			$table->string('date_format');
			
			$table->string('logo');
			$table->string('favicon');

			$table->text('header_code');
			$table->text('footer_code');
			
			$table->tinyInteger('review_moderation')->default(0);
			$table->tinyInteger('review_title')->default(1);
			$table->tinyInteger('review_pros_cons')->default(1);
			$table->integer('review_len')->default(7000);
			$table->integer('review_preview_len')->default(300);
			$table->tinyInteger('review_report')->default(1);
			$table->tinyInteger('review_favorite')->default(1);
			$table->tinyInteger('review_helpful')->default(1);
			$table->text('review_writing_tips');
			$table->tinyInteger('review_edit')->default(1);
			$table->tinyInteger('review_delete')->default(1);

			$table->integer('product_description_len')->default(200);

			$table->tinyInteger('users_add_products')->default(1);
			$table->tinyInteger('users_add_product_images')->default(1);
			$table->tinyInteger('users_list_product_images')->default(1);
			$table->tinyInteger('users_delete_product_images')->default(1);
			$table->tinyInteger('users_report_products')->default(1);

			$table->integer('product_sm_thumb_w');
			$table->integer('product_sm_thumb_h');

			$table->integer('product_main_thumb_w');
			$table->integer('product_main_thumb_h');

			$table->tinyInteger('email_confirmation')->default(1);
			$table->tinyInteger('recaptcha_registration')->default(0);
			$table->tinyInteger('recaptcha_contact')->default(0);

			$table->integer('front_end_pagination');
			
			$table->integer('admin_products_pagination');
			$table->integer('admin_reviews_pagination');
			$table->integer('admin_images_pagination');
			$table->integer('admin_categories_pagination');
			$table->integer('admin_brands_pagination');
			$table->integer('admin_users_pagination');

			$table->dateTime('new_products_since');
			$table->dateTime('new_reviews_since');
			$table->dateTime('new_images_since');
			$table->dateTime('new_users_since');
			
			$table->timestamps();			

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('settings');
	}

}
