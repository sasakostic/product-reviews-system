<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoritesList extends Model {
	protected $fillable = [];

	public function products() {
		return $this->hasMany('App\Product');
	}

}