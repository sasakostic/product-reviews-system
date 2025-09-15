<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model {
	protected $fillable = [];

	public function products() {
		return $this->hasMany('App\Product');
	}

	public function getReviewsCount() {
		$counter = 0;
		$products = $this->products()->with('reviews')->get();
		foreach ($products as $product) {
			$counter += $product->reviews()->count();
		}
		return $counter;
	}
}