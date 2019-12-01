<?php

namespace App\Http\Controllers\MuaDashboard;

use App\Http\Controllers\Controller;
use App\Models\MuaFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class FeedbackController extends Controller
{
    
    public function index() {
        $feedback = MuaFeedback::where("mua_id", Auth::user()->mua->id)->get();
        $data = $feedback->map(function($item){
            return [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'user' => $item->user->name,
                'order_id' => $item->order_id,
                'rate' => $item->rate,
                'comment' => $item->comment,
                'created_at' => $item->created_at,
                'created_at_formatted' => hariTanggalWaktu($item->created_at)
            ];
        });
        return $this->responseOK(null, $data);
    }

}
