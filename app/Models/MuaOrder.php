<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class MuaOrder extends Model
{
    use SoftDeletes;
    protected $table    = 'tbl_mua_orders';
    protected $dates 	= ['deleted_at'];
    protected $append   = ['phone'];

    protected static function boot() {
        parent::boot();
        static::deleting(function($data) {
        });
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });
    }

    //RELATION table
  	public function mua() {
        return $this->belongsTo('App\Models\Mua', 'mua_id')->withDefault();
  	}
  	public function client() {
        return $this->belongsTo('App\Models\User', 'user_id')->withDefault();
  	}
  	public function city() {
        return $this->belongsTo('App\Models\SetCity', 'city_id')->withDefault();
  	}
  	public function province() {
        return $this->belongsTo('App\Models\SetProvince', 'province_id')->withDefault();
  	}
  	public function status() {
        return $this->belongsTo('App\Models\SetLibrary', 'order_status_id')->withDefault();
  	}
  	public function bookingType() {
        return $this->belongsTo('App\Models\SetLibrary', 'booking_type_id')->withDefault();
  	}
  	public function details() {
        return $this->hasMany('App\Models\MuaOrderDetail', 'order_id');
  	}
  	public function statusHistories() {
        return $this->hasMany('App\Models\MuaOrderStatus', 'order_id');
      }
  	public function additionalCosts() {
        return $this->hasMany('App\Models\MuaOrderAdditionalCost', 'order_id');
      }
  	public function income() {
        return $this->hasOne('App\Models\WalletHistory', 'object_id');
      }
        

    public function getPhoneAttribute(){
      if($this->phone_number)
            return "+62" . $this->phone_number;
      return null;
      }
}
