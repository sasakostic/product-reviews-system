<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Eloquent::unguard();
		//Setting::truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		$this->call('SettingsTableSeeder');
		$this->call('CategoriesTableSeeder');
		$this->call('BrandsTableSeeder');
		$this->call('PagesTableSeeder');
		$this->call('ProductReportingReasonsTableSeeder');
		$this->call('ReviewReportingReasonsTableSeeder');
		$this->call('WidgetsTableSeeder');
	}

}
