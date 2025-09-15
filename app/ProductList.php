<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductList extends Model {
	protected $fillable = [];

	public function product() {
		return $this->belongsTo('App\Product');
	}
	
}