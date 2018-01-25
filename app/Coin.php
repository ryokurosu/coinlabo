<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
	protected $fillable = [
		'name', 'unit', 'per','alias'
	];
	public function imagePath(){
		return url('/'.$this->alias.'.png');
	}


}
