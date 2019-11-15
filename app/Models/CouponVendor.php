<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class CouponVendor extends Model
{
    use SoftDeletes;
    protected $table    = 'tbl_coupon_vendors';
    protected $dates 	= ['deleted_at'];

    protected static function boot() {
        parent::boot();
        static::deleting(function($data) {
        });
    }

    //RELATION table
  	public function coupon() {
        return $this->belongsTo('App\Models\Coupon', 'coupon_id')->withDefault();
    }

}
