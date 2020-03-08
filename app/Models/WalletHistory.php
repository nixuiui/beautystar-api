<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalletHistory extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_wallet_histories';
    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
        });
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });
    }

    //RELATION table
    public function category()
    {
        return $this->belongsTo('App\Models\SetLibrary', 'category_id')->withDefault();
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id')->withDefault();
    }
    public function object()
    {
        if ($this->category_id == 1601)
            return $this->belongsTo('App\Models\MuaOrder', 'object_id')->withDefault();
        return null;
    }

    public function getPhoneAttribute()
    {
        if ($this->phone_number) {
            return "+62" . $this->phone_number;
        }

        return null;
    }

    public static function mapData($data, $additionalAttribute = null) {
        $result = [
            "id" => $data->id,
            "user_id" => $data->user_id,
            "deb_cr" => $data->deb_cr,
            "deb_cr_formatted" => formatUang($data->deb_cr),
            "balance" => $data->balance,
            "balance_formatted" => formatUang($data->balance),
            "category_id" => $data->category_id,
            "category" => $data->category->name,
            "object_id" => $data->object_id,
            "comment" => $data->comment,
            "created_at" => $data->created_at
        ];
        if($additionalAttribute) {
            $result = array_merge($result, $additionalAttribute);
        }
        return $result;
    }
}
