<?php

namespace App\Http\Controllers\MuaDashboard;

use App\Http\Controllers\Controller;
use App\Models\MuaDP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class DownpaymentController extends Controller
{
    
    public function index() {
        $downpayment = MuaDP::where("mua_id", Auth::user()->mua->id)->orderBy("max", "ASC")->get();
        $data = $downpayment->map(function($item){
            return MuaDP::mapData($item);
        });
        return $this->responseOK(null, $data);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'max'           => 'required|numeric',
            'is_used_dp'    => 'required|in:0,1',
            'dp'            => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return $this->responseNotValidInput("Ada field yang tidak valid", $validator->errors());
        }

        $downpayment                = new MuaDP;
        $downpayment->max           = $request->max;
        $downpayment->is_used_dp    = $request->is_used_dp;
        $downpayment->dp            = $request->is_used_dp ? $request->dp : 0;
        $downpayment->mua_id        = Auth::user()->mua->id;
        $downpayment->save();

        return $this->responseOK(null, MuaDP::mapData($downpayment));
    }
    
    public function edit(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'max'           => 'required|numeric',
            'is_used_dp'    => 'required|in:0,1',
            'dp'            => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return $this->responseNotValidInput("Ada field yang tidak valid", $validator->errors());
        }

        $downpayment = MuaDP::where("mua_id", Auth::user()->mua->id)
                            ->where("id", $id)
                            ->first();
        
        if(!$downpayment) return $this->responseError("Data dp tidak ada", null);

        $downpayment->max           = $request->max;
        $downpayment->is_used_dp    = $request->is_used_dp;
        $downpayment->dp            = $request->is_used_dp ? $request->dp : 0;
        $downpayment->mua_id        = Auth::user()->mua->id;
        $downpayment->save();

        return $this->responseOK(null, MuaDP::mapData($downpayment));
    }
    
    public function detele($id) {
        $downpayment = MuaDP::where("mua_id", Auth::user()->mua->id)
                                ->where("id", $id)
                                ->first();

        if(!$downpayment) return $this->responseError("Data dp tidak ada", null);

        if($downpayment->delete()) return $this->responseOK("dp berhasil dihapus", null);

        return $this->responseError("Kesalahan saat menghapus data", null);
    }
    
    public function detail($id) {
        $downpayment = MuaDP::where("mua_id", Auth::user()->mua->id)
                                ->where("id", $id)
                                ->first();
        return $this->responseOK(null, MuaDP::mapData($downpayment));
    }

}
