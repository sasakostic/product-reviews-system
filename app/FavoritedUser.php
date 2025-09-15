<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoritedUser extends Model {
	protected $fillable = [];

public function favorited_user() {
		return $this->belongsTo('App\User');
	}	
}