<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiveawayParticipants extends Model {
    protected $table    = 'tbl_giveaway_participants';

    //RELATION TABLE
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id')->withDefault();
    }
}
