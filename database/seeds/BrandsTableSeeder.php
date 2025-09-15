<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Brand;

class BrandsTableSeeder extends Seeder {

	public function run() {
		//DB::table('categories')->delete();
		Brand::truncate();

		$brands = array(
			array(
				'id' => 1,
				'name' => 'Unspecified',
				'slug' => 'unspecified',
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
			),
		);

		DB::table('brands')->insert($brands);
	}

}