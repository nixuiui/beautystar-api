<?php

namespace App\Http\Controllers\MuaDashboard;

use App\Http\Controllers\Controller;
use App\Models\Mua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class SettingController extends Controller
{
    
    public function index(Request $request) {
        $validator = Validator::make($request->all(), [
            'brand_name'    => 'required',
            'province_id'   => 'required|exists:set_provinces,id',
            'city_id'       => 'required|exists:set_cities,id',
            'address'       => 'required',
            'description'   => 'required',
            'instagram'     => 'nullable|alpha_dash',
            'facebook'      => 'nullable|alpha_dash',
        ]);
        if ($validator->fails()) {
            return $this->responseNotValidInput("Ada field yang tidak valid", $validator->errors());
        }

        $mua = Auth::user()->mua;
        $mua->brand_name = $request->brand_name;
        $mua->province_id = $request->province_id;
        $mua->city_id = $request->city_id;
        $mua->address = $request->address;
        $mua->description = $request->description;
        $mua->instagram = $request->instagram;
        $mua->facebook = $request->facebook;
        $mua->save();

        return $this->responseOK(null, Mua::mapData($mua));
    }

}
