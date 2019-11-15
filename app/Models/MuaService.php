<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MuaService extends Model
{
    use SoftDeletes;
    protected $table    = 'tbl_mua_services';
    protected $dates 	= ['deleted_at'];
    protected $appends  = ['is_promo', 'price_formatted', 'final_price', 'final_price_formatted'];

//     protected static function boot() {
//         parent::boot();
//         static::deleting(function($data) {
//         });
//     }

    //RELATION table
  	public function mua() {
            return $this->belongsTo('App\Models\Mua', 'mua_id')->withDefault();
  	}
  	public function category() {
            return $this->belongsTo('App\Models\MuaServiceCategory', 'category_id')->withDefault();
  	}
  	public function servicePackages() {
            return $this->hasMany('App\Models\MuaServicePackage', 'package_id');
    }
    
    public function getPriceFormattedAttribute(){
        return formatUang($this->price);
    }
    public function getIsPromoAttribute(){
        if($this->promo)
            return true;
        return false;
    }
    public function getFinalPriceAttribute(){
        if($this->promo)
            return $this->promo;
        return $this->price;
    }
    public function getFinalPriceFormattedAttribute(){
        return formatUang($this->promo);
    }

}
