<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

	protected $fillable = [
		'user_id', 'url', 'title', 'rss' , 'thumbnail' ,'active'
	];
	public function user(){
		return $this->belongsTo('App\User');
	}

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

	public function imagePath(){
		return url('/images/'.$this->thumbnail);
	}

}
