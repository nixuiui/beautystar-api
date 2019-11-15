<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetCategory extends Model {
    protected $table    = 'set_categories';

    //RELATION TABLE
  	public function libraries() {
  		return $this->hasMany('App\Models\SetLibrary', 'category_id');
  	}
}
