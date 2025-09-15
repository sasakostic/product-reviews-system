<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class HelpfulReview extends Model {
	protected $fillable = [];

	public function review() {
		return $this->belongsTo('App\Review');
	}
}