<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\Mua;

trait DownpaymentTrait {

    public function getMuaDownpayment($totalCost, $muaId) {
        $mua = Mua::find($muaId);
        $totalDP = $totalCost;
        $sizeDP = $mua->downpayments->count();
        if($sizeDP > 0) {
            for($i=0; $i<$sizeDP; $i++) {
                if($totalCost <= $mua->downpayments[$i]->max) {
                    if($mua->downpayments[$i]->is_used_dp)
                        $totalDP = $mua->downpayments[$i]->dp;
                    else
                        $totalDP = $totalCost;
                    break;
                }
            }
            if($totalCost > $mua->downpayments[$sizeDP-1]->max) {
                if($mua->downpayments[$sizeDP-1]->is_used_dp)
                    $totalDP = $mua->downpayments[$sizeDP-1]->dp;
                else
                    $totalDP = $totalCost;
            }
        }
        if($totalCost < $totalDP) $totalDP = $totalCost;
        return $totalDP;
    }

}