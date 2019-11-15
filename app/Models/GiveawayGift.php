<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiveawayGift extends Model {
    protected $table    = 'tbl_giveaway_gifts';

    //RELATION TABLE
    public function giveaway() {
        return $this->belongsTo('App\Models\Giveaway', 'giveaway_id')->withDefault();
    }
    public function winner() {
        return $this->belongsTo('App\Models\GiveawayParticipants', 'winner_id')->withDefault();
    }
}
