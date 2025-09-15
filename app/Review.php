<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model {
	protected $fillable = [];

	public function product() {
		return $this->belongsTo('App\Product');
	}

	public function reports() {
		return $this->hasMany('App\ReportedReview');
	}

	public function favorites() {
		return $this->hasMany('App\FavoritedReview');
	}

}