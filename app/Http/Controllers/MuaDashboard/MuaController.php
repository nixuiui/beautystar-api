<?php

namespace App\Http\Controllers\MuaDashboard;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mua;
use App\Models\MuaPortfolio;
use App\Models\MuaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class MuaController extends Controller {
    
    public function muaInformation() {
        $mua = Mua::where('user_id', Auth::id())->first();
        if($mua) {
            $data = Mua::mapData($mua);
            return $this->responseOK(null, $data);
        }
        return $this->responseError("Anda belum terdaftar sebagai Makeup Artist", null);
    }

    public function serviceCreate(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'category_id'   => 'required|exists:tbl_mua_service_categories,id',
            'description'   => 'required',
            'price'         => 'required|numeric',
            'promo'         => 'nullable|numeric',
            'min_person'    => 'nullable|numeric',
            'duration'      => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return $this->responseNotValidInput("Ada field yang tidak valid", $validator->errors());
        }

        if(Auth::user()->mua) {
            $service                 = new MuaService;
            $service->mua_id         = Auth::user()->mua->id;
            $service->name           = $request->name;
            $service->category_id    = $request->category_id;
            $service->description    = $request->description;
            $service->price          = $request->price;
            $service->promo          = $request->promo;
            $service->min_person     = $request->min_person ?: 1;
            $service->is_premium     = $request->is_premium ? 1 : 0;
            $service->duration       = $request->duration;
            $service->save();

            $data = MuaService::mapData($service);
            return $this->responseOK("Berhasil menambah data", $data);
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

    public function portfolio() {
        $porfolios = MuaPortfolio::where("mua_id", Auth::user()->mua->id)->get();
        $data = $porfolios->map(function($data){
            return MuaPortfolio::mapData($data);
        });
        return $this->responseOK(null, $data);
    }

    public function portfolioDelete($id) {
        // LOAD DETAIL SERVICE
        $posrtfolio = MuaPortfolio::where("mua_id", Auth::user()->mua->id)->where("id", $id)->first();
        if($posrtfolio) {
            if($posrtfolio->delete())
                return $this->responseOK("Portfolio berhasil dihapus", null);
            return $this->responseError("Gagal menghapus portfolio", null);
        }
        return $this->responseError("Data tidak ditemukan", null);
    }

    public function portfolioUpload(Request $input) {
        $data = ["file" => $input->file];
        $data_string = json_encode($data);

        $ch = curl_init(env('APP_URL_WEB') . '/ajax/mua-dashboard/portfolio/api');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );

        // DECODE JSON DATA
        // {
        //     "success": "OK",
        //     "message": null,
        //     "data": "201911292206301575039990.png"
        // }
        $result = json_decode(curl_exec($ch));
        if($result->success == "OK") {
            $portfolio = new MuaPortfolio;
            $portfolio->mua_id = Auth::user()->mua->id;
            $portfolio->photo = $result->data;
            $portfolio->service_id = $input->service_id;
            if($portfolio->save())
                return $this->responseOK(null, MuaPortfolio::mapData($portfolio));
            else
                return $this->responseError("Gagal menyimpan portfolio", null);
        }
        else {
            return $this->responseError("Gagal upload File", null);
        }
    }

}
