<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
	protected $fillable = [
		'title', 'text', 'url','thumbnail'
	];
	public function imagePath(){
		return url('/images/'.$this->thumbnail);
	}


}
