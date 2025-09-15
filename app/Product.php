<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

	protected $fillable = ['brand_id', 'category_id'];

	public function reviews() {
		return $this->hasMany('App\Review');
	}

	public function images() {
		return $this->hasMany('App\Image');
	}

	public function image() {
		return $this->belongsTo('App\Image');
	}

	public function category() {
		return $this->belongsTo('App\Category');
	}

	public function brand() {
		return $this->belongsTo('App\Brand');
	}

	public function favorites(){
		return $this->hasMany('App\FavoritedProduct');
	}

	public function reports() {
		return $this->hasMany('App\ReportedProduct');
	}

}