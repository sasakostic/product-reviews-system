<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\ReviewReportingReason;

class ReviewReportingReasonsTableSeeder extends Seeder {

	public function run() {
		
		ReviewReportingReason::truncate();

		$reasons = array(
			array(
				'id' => 1,
				'text' => 'User didn\'t try the product',
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
			),
			array(
				'id' => 2,
				'text' => 'Vulgar language',
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
			),
			array(
				'id' => 3,
				'text' => 'Spam',
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
			),
			array(
				'id' => 4,
				'text' => 'Duplicate review',
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
			),
			array(
				'id' => 5,
				'text' => 'Wrong product',
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
			),
			array(
				'id' => 6,
				'text' => 'Not a review',
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
			),
			
		);

		DB::table('review_reporting_reasons')->insert($reasons);
	}

}