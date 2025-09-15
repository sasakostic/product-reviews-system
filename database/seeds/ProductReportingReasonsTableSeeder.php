<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\ProductReportingReason;

class ProductReportingReasonsTableSeeder extends Seeder {

	public function run() {
		
		ProductReportingReason::truncate();

		$reasons = array(
			array(
				'id' => 1,
				'text' => 'Product is discontinued',
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
			),
			array(
				'id' => 2,
				'text' => 'Mistake in product description',
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
			),
			array(
				'id' => 3,
				'text' => 'Wrong product name',
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
			),			
		);

		DB::table('product_reporting_reasons')->insert($reasons);
	}

}