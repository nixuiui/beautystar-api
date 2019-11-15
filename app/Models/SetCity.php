<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetCity extends Model {
    protected $table    = 'set_cities';

    //RELATION TABLE
  	public function mua() {
  		return $this->hasMany('App\Models\Mua', 'city_id');
  	}
}
