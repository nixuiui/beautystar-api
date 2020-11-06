<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MuaOrderStatus extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_mua_order_status';
    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
        });
    }

    //RELATION table
    public function order()
    {
        return $this->belongsTo('App\Models\MuaOrder', 'order_id');
    }
    public function status()
    {
        return $this->belongsTo('App\Models\SetLibrary', 'status_id')->withDefault();
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id')->withDefault();
    }

    public static function mapData($data, $additionalAttribute = null)
    {
        $result = [
            "id" => $data->id,
            "order_id" => $data->order_id,
            "status_id" => $data->status->name,
            "status" => $data->status->name,
            "user_id" => $data->user_id,
            "user" => $data->user->name,
            "comment" => $data->comment,
            "created_at" => date("Y-m-d H:i:s", strtotime($data->created_at)),
        ];
        if ($additionalAttribute) {
            $result = array_merge($result, $additionalAttribute);
        }
        return $result;
    }
}
