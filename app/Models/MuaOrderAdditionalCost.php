<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MuaOrderAdditionalCost extends Model
{
    use SoftDeletes;
    protected $table    = 'tbl_mua_order_additional_costs';
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

    public static function mapData($data, $additionalAttribute = null)
    {
        $result = [
            "id" => $data->id,
            "cost_for" => $data->cost_for,
            "cost" => $data->cost,
            "cost_formatted" => formatUang($data->cost)
        ];
        if ($additionalAttribute) {
            $result = array_merge($result, $additionalAttribute);
        }
        return $result;
    }
}
