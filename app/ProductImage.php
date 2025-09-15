<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model {
	protected $fillable = [];

	public function product() {
		return $this->belongsTo('App\Product');
	}

}