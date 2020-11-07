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
  	public function vendorCategory() {
            return $this->belongsTo('App\Models\VendorCategory', 'vendor_category_id')->withDefault();
  	}
  	public function category() {
            return $this->belongsTo('App\Models\MuaServiceCategory', 'category_id')->withDefault();
  	}
  	public function servicePackages() {
            return $this->hasMany('App\Models\MuaServicePackage', 'package_id');
    }
    public function orders() {
      return $this->hasMany('App\Models\MuaOrderDetail', 'service_id');
    }
    public function portfolios() {
        return $this->hasMany('App\Models\MuaPortfolio', 'service_id');
    }
    
    // APPEND ATTRIBUTE
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
        if($this->promo)
            return formatUang($this->promo);
        return formatUang($this->price);
    }

    public static function mapData($data, $additionalAttribute = null) {
        $result = [
            "id" => $data->id,
            "mua_id" => $data->mua_id,
            "vendor_category_id" => $data->vendor_category_id,
            "vendor_category" => $data->vendorCategory->name,
            "service_category_id" => $data->category_id,
            "service_category" => $data->category->name,
            "name" => $data->name,
            "description" => $data->description,
            "price" => $data->price,
            "promo" => $data->promo ? $data->promo : null,
            "is_promo" => (boolean) $data->is_promo,
            "price_formatted" => $data->price_formatted,
            "final_price" => $data->final_price,
            "final_price_formatted" => $data->final_price_formatted,
            "created_at" => hariTanggal($data->created_at),
            "portfolios" => $data->portfolios->map(function($item){
                return MuaPortfolio::mapData($item);
            })
        ];
        if($additionalAttribute) {
            $result = array_merge($result, $additionalAttribute);
        }
        return $result;
    }

}
