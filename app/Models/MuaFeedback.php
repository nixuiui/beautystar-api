<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MuaFeedback extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_mua_feedback';
    protected $dates = ['deleted_at'];

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id')->withDefault();
    }
}
