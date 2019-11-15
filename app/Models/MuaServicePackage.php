<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MuaServicePackage extends Model
{
    use SoftDeletes;
    protected $table    = 'tbl_mua_service_packages';
    protected $dates 	= ['deleted_at'];

    protected static function boot() {
        parent::boot();
        static::deleting(function($data) {
        });
    }

    //RELATION table
  	public function package() {
        return $this->belongsTo('App\Models\MuaService', 'service_id')->withDefault();
  	}
}
