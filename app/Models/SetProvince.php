<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetProvince extends Model {
    protected $table    = 'set_provinces';

    //RELATION TABLE
  	public function mua() {
		return $this->hasMany('App\Models\Mua', 'province_id');
	}
  	public function city() {
		return $this->hasMany('App\Models\SetCity', 'province_id');
	}
}
