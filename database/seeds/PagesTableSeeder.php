<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Page;
class PagesTableSeeder extends Seeder {

	public function run() {
		//DB::table('categories')->delete();
		Page::truncate();

		$pages = array(
			array(
				'title' => 'About Us',
				'slug' => 'about-us',
				'content' => 'About us page',
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
			),
			array(
				'title' => 'Terms of use',
				'slug' => 'terms-of-use',
				'content' => 'Terms of use',
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
			),
			array(
				'title' => 'Privacy policy',
				'slug' => 'privacy-policy',
				'content' => 'Privacy policy',
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
			),
			array(
				'title' => 'FAQ',
				'slug' => 'faq',
				'content' => 'FAQ',
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
			),
		);

		DB::table('pages')->insert($pages);
	}

}