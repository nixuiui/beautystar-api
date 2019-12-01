<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_address';
    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
        });
    }

    //RELATION table
    public function city()
    {
        return $this->belongsTo('App\Models\SetCity', 'city_id')->withDefault();
    }
    public function province()
    {
        return $this->belongsTo('App\Models\SetProvince', 'province_id')->withDefault();
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id')->withDefault();
    }

    public static function mapData($data, $additionalAttribute = null) {
        $result = [
            "id" => $data->id,
            "user_id" => $data->user_id,
            "name" => $data->name,
            "address" => $data->address,
            "province_id" => $data->province_id,
            "province" => $data->province->name,
            "city_id" => $data->city_id,
            "city" => $data->city->name
        ];
        if($additionalAttribute) {
            $result = array_merge($result, $additionalAttribute);
        }
        return $result;
    }
}
