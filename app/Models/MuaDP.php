<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MuaDP extends Model
{
    protected $table = 'tbl_mua_downpayments';

    //RELATION table
    public function mua()
    {
        return $this->belongsTo('App\Models\Mua', 'mua_id')->withDefault();
    }

    public static function mapData($data, $additionalAttribute = null)
    {
        $result = [
            "id" => $data->id,
            "max" => $data->max,
            "max_formatted" => formatUang($data->max),
            "is_used_dp" => $data->is_used_dp,
            "dp" => $data->dp,
            "dp_formatted" => formatUang($data->dp),
            "mua_id" => $data->mua_id
        ];
        if ($additionalAttribute) {
            $result = array_merge($result, $additionalAttribute);
        }
        return $result;
    }
}
