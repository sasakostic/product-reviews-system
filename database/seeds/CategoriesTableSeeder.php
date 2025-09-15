<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Category;

class CategoriesTableSeeder extends Seeder {

	public function run() {
		//DB::table('categories')->delete();
		Category::truncate();

		$categories = array(
			array(
				'id' => 1,
				'name' => 'Unspecified',
				'slug' => 'unspecified',
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
			),
		);

		DB::table('categories')->insert($categories);
	}

}