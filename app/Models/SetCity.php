<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetCity extends Model {
    protected $table    = 'set_cities';

    //RELATION TABLE
  	public function mua() {
  		return $this->hasMany('App\Models\Mua', 'city_id');
  	}

	public static function mapData($data) {
		return [
			'id' => $data->id,
			'name' => $data->name,
			'province_id' => $data->province_id
		];
	}
}
