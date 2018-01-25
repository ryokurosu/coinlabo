<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

	protected $fillable = [
		'user_id', 'url', 'title', 'thumbnail' , 'active' ,'count'
	];

	public function scopeActive($query)
	{
		return $query->where('active', 1);
	}

	public function activate(){
		$this->active = 1;
		$this->save();
	}


	public function inactivate(){
		$this->active = 0;
		$this->save();
	}

	public function user(){
		return $this->belongsTo('App\User');
	}

	public function comments(){
		return $this->hasMany('App\Comment');
	}

	public function imagePath(){
		return url('/images/'.$this->thumbnail);
	}
}
