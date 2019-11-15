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
}
