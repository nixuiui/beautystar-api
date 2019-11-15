<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MuaDP extends Model
{
    protected $table    = 'tbl_mua_downpayments';
    protected $appends = ['max_formatted', 'dp_formatted'];

    //RELATION table
  	public function mua() {
            return $this->belongsTo('App\Models\Mua', 'mua_id')->withDefault();
    }
    
    public function getMaxFormattedAttribute(){
      return formatUang($this->max);
    }
    public function getDPFormattedAttribute(){
      return formatUang($this->dp);
    }
}
