<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class BankController extends Controller
{
    
    public function index() {
        $bank = BankAccount::where("user_id", Auth::id())->get();
        $data = $bank->map(function($item) {
            return BankAccount::mapData($item);
        });
        return $this->responseOK(null, $data);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'bank_id'       => 'required|exists:set_banks,id',
            'number'        => 'required|numeric',
            'owner_name'    => 'required'
        ]);
        if ($validator->fails()) {
            return $this->responseNotValidInput("Ada field yang tidak valid", $validator->errors());
        }

        $bank = new BankAccount;
        $bank->bank_id = $request->bank_id;
        $bank->number = $request->number;
        $bank->owner_name = $request->owner_name;
        $bank->user_id = Auth::id();
        $bank->save();

        return $this->responseOK(null, BankAccount::mapData($bank));
    }
    
    public function edit(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'bank_id'       => 'required|exists:set_banks,id',
            'number'        => 'required|numeric',
            'owner_name'    => 'required'
        ]);
        if ($validator->fails()) {
            return $this->responseNotValidInput("Ada field yang tidak valid", $validator->errors());
        }

        $bank = BankAccount::where("user_id", Auth::id())->where("id", $id)->first();

        if(!$bank) return $this->responseError("Data bank tidak ada", null);

        $bank->bank_id = $request->bank_id;
        $bank->number = $request->number;
        $bank->owner_name = $request->owner_name;
        $bank->save();

        return $this->responseOK(null, BankAccount::mapData($bank));
    }
    
    public function detele($id) {
        $bank = BankAccount::where("user_id", Auth::id())->where("id", $id)->first();

        if(!$bank) return $this->responseError("Data bank tidak ada", null);

        if($bank->delete()) return $this->responseOK("Bank berhasil dihapus", null);

        return $this->responseError("Kesalahan saat menghapus data", null);
    }
    
    public function detail($id) {
        $bank = BankAccount::where("user_id", Auth::id())->where("id", $id)->first();

        if(!$bank) return $this->responseError("Data bank tidak ditemukan", null);

        return $this->responseOK(null, BankAccount::mapData($bank));
    }

}
