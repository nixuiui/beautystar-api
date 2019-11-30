<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MuaOrderDetail extends Model
{
    use SoftDeletes;
    protected $table    = 'tbl_mua_order_details';
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
    public function service() {
        return $this->belongsTo('App\Models\MuaService', 'service_id')->withTrashed();
    }
    
    public static function mapData($data, $additionalAttribute = null) {
        $result = [
            "id" => $data->id,
            "service_id" => $data->service_id,
            "service" => $data->service->name,
            "count" => $data->count,
            "price" => $data->price,
            "price_formatted" => formatUang($data->price),
            "dp_price" => $data->dp_price,
            "dp_price_formatted" => formatUang($data->dp_price),
            "total_price" => $data->total_price,
            "total_price_formatted" => formatUang($data->total_price),
            "total_dp_price" => $data->total_dp_price,
            "total_dp_price_formatted" => formatUang($data->total_dp_price)
        ];
        if($additionalAttribute) {
            $result = array_merge($result, $additionalAttribute);
        }
        return $result;
    }

}
