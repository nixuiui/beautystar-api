<?php

namespace App\Http\Controllers\MuaDashboard;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mua;
use App\Models\MuaService;
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

    public function services() {
        if(Auth::user()->mua) {
            // LOAD ALL SERVICES
            $services = MuaService::where("mua_id", Auth::user()->mua->id)->get();
            $data = $services->map(function($item) {
                return MuaService::mapData($item);
            });
            return $this->responseOK(null, $data);
        }
        return $this->responseError("Anda belum terdaftar sebagai Makeup Artist", null);
    }

    public function serviceDetail($id) {
        if(Auth::user()->mua) {
            // LOAD DETAIL SERVICE
            $service = MuaService::where("mua_id", Auth::user()->mua->id)->where("id", $id)->first();
            if($service) {
                $additionalAttribute = [
                    'order_count' => $service->orders->count()
                ];
                $data = MuaService::mapData($service, $additionalAttribute);
                return $this->responseOK(null, $data);
            }
            return $this->responseError("Data tidak ditemukan", null);
        }
        return $this->responseError("Anda belum terdaftar sebagai Makeup Artist", null);
    }

    public function serviceDelete($id) {
        // LOAD DETAIL SERVICE
        $service = MuaService::where("mua_id", Auth::user()->mua->id)->where("id", $id)->first();
        if($service) {
            if($service->delete())
                return $this->responseOK("Data layanan berhasil dihapus", null);
            return $this->responseError("Gagal menghapus data layanan", null);
        }
        return $this->responseError("Data tidak ditemukan", null);
    }

}
