<?php

namespace App\Http\Controllers\MuaDashboard;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MuaController extends Controller {
    
    public function muaInformation() {
        $mua = Mua::where('user_id', Auth::id())->first();
        if($mua) {
            $data = Mua::mapData($mua);
            return $this->responseOK(null, $data);
        }
        return $this->responseError("Anda belum terdaftar sebagai Makeup Artist", null);
    }

}
