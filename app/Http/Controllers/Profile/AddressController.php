<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AddressController extends Controller
{
    
    public function index() {
        $address = Address::where("user_id", Auth::id())->get();
        $data = $address->map(function($item) {
            return Address::mapData($item);
        });
        return $this->responseOK(null, $data);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'address'       => 'required',
            'province_id'   => 'required|exists:set_provinces,id',
            'city_id'       => 'required|exists:set_cities,id'
        ]);
        if ($validator->fails()) {
            return $this->responseNotValidInput("Ada field yang tidak valid", $validator->errors());
        }

        $address = new Address;
        $address->name = $request->name;
        $address->address = $request->address;
        $address->province_id = $request->province_id;
        $address->city_id = $request->city_id;
        $address->user_id = Auth::id();
        $address->save();

        return $this->responseOK(null, Address::mapData($address));
    }
    
    public function edit(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'address'       => 'required',
            'province_id'   => 'required|exists:set_provinces,id',
            'city_id'       => 'required|exists:set_cities,id'
        ]);
        if ($validator->fails()) {
            return $this->responseNotValidInput("Ada field yang tidak valid", $validator->errors());
        }

        $address = Address::where("user_id", Auth::id())->where("id", $id)->first();

        if(!$address) return $this->responseError("Data alamat tidak ada", null);

        $address->name = $request->name;
        $address->address = $request->address;
        $address->province_id = $request->province_id;
        $address->city_id = $request->city_id;
        $address->save();

        return $this->responseOK(null, Address::mapData($address));
    }
    
    public function detele($id) {
        $address = Address::where("user_id", Auth::id())->where("id", $id)->first();

        if(!$address) return $this->responseError("Data alamat tidak ada", null);

        if($address->delete()) return $this->responseOK("Alamat berhasil dihapus", null);

        return $this->responseError("Kesalahan saat menghapus data", null);
    }
    
    public function detail($id) {
        $address = Address::where("user_id", Auth::id())->where("id", $id)->first();

        if(!$address) return $this->responseError("Data alamat tidak ditemukan", null);

        return $this->responseOK(null, Address::mapData($address));
    }

}
