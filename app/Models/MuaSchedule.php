<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MuaSchedule extends Model
{
    protected $table        = 'tbl_mua_schedules';


    // Relations table
    public function mua() {
        return $this->belongsTo('App\Models\Mua', 'mua_id');
    }

    public static function mapData($data, $additionalAttribute = null) {
        $result = [
            "id" => $data->id,
            "title" => $data->title,
            "description" => $data->description,
            "start_time" => $data->start_time,
            "start_time_formatted" => hariTanggalWaktu($data->start_time),
            "end_time" => $data->end_time,
            "end_time_formatted" => hariTanggalWaktu($data->end_time),
            "color" => $data->color,
            "mua_id" => $data->mua_id,
        ];
        if($additionalAttribute) {
            $result = array_merge($result, $additionalAttribute);
        }
        return $result;
    }
}
