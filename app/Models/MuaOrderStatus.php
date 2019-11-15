<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MuaOrderStatus extends Model
{
    use SoftDeletes;
    protected $table    = 'tbl_mua_order_status';
    protected $dates 	= ['deleted_at'];

    protected static function boot() {
        parent::boot();
        static::deleting(function($data) {
        });
    }

    //RELATION table
  	public function order() {
        return $this->belongsTo('App\Models\MuaOrder', 'order_id');
  	}
  	public function status() {
        return $this->belongsTo('App\Models\SetLibrary', 'status_id')->withDefault();
  	}
}
