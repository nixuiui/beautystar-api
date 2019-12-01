<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_bank_accounts';
    protected $dates = ['deleted_at'];

    protected static function boot() {
        parent::boot();
        static::deleting(function ($data) {
        });
    }

    //RELATION table
    public function bank() {
        return $this->belongsTo('App\Models\SetBank', 'bank_id')->withDefault();
    }

    public static function mapData($data, $additionalAttribute = null) {
        $result = [
            "id" => $data->id,
            "user_id" => $data->user_id,
            "bank_id" => $data->bank_id,
            "bank_name" => $data->bank->name,
            "bank_code" => $data->bank->code,
            "number" => $data->number,
            "owner_name" => $data->owner_name
        ];
        if($additionalAttribute) {
            $result = array_merge($result, $additionalAttribute);
        }
        return $result;
    }
}
