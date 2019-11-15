<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table    = 'tbl_password_resets';
    public $timestamps = false;

    //RELATION table
  	public function user() {
  		return $this->belongsTo('App\Model\User', 'email');
  	}
}
