<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MuaSchedule extends Model
{
    protected $table        = 'tbl_mua_schedules';


    // Relations table
    public function mua()
    {
        return $this->belongsTo('App\Models\Mua', 'mua_id');
    }
}
