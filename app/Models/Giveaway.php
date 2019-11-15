<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Giveaway extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_giveaways';
    protected $dates = ['deleted_at'];

    protected static function boot() {
        parent::boot();
        static::deleting(function ($data) {
        });
    }

    //RELATION table
    public function participants() {
        return $this->hasMany('App\Models\GiveawayParticipants', 'giveaway_id');
    }
    public function gifts() {
        return $this->hasMany('App\Models\GiveawayGift', 'giveaway_id');
    }
}
