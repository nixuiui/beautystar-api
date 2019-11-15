<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_coupons';
    protected $dates = ['deleted_at'];

    protected static function boot() {
        parent::boot();
        static::deleting(function ($data) {
        });
    }

    //RELATION table
    public function couponServiceCategories() {
        return $this->hasMany('App\Models\CouponServiceCategory', 'coupon_id');
    }
    public function couponVendors() {
        return $this->hasMany('App\Models\CouponVendor', 'coupon_id');
    }
}
