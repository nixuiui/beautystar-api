<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WalletHistory;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller {

    public function accountInformation() {
        $token = [
            'access_token' => "",
            'token_type' => 'bearer',
            'expires_in' => 0
        ];
        $data = User::mapData(app('auth')->user(), $token);
        return $this->responseOK(null, $data);
    }

    public function editPassword(Request $input) {
        $validator = Validator::make($input->all(), [
            'old_password'      => 'required',
            'password'          => 'required',
            'password_confirm'  => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return $this->responseNotValidInput("Ada field yang tidak valid", $validator->errors());
        }

        if(Hash::check($input->old_password, Auth::user()->password)) {
            $user = Auth::user();
            $user->password = app('hash')->make($input->password);
            $user->save();
            return $this->responseOK("Password berhasil diganti", null);
        }
        return $this->responseError("Password lama yang Anda masukkan salah", null);
    }
    
    public function editGeneral(Request $input) {
        $validator = Validator::make($input->all(), [
            'name'          => 'required',
            'birth_date'    => 'nullable|date',
            'phone_number'  => 'nullable|numeric|unique:tbl_users,no_hp,' . Auth::id(),
            'email'         => 'nullable|email|unique:tbl_users,email,' . Auth::id(),
            'gender'        => 'nullable|in:1101,1102'
        ]);
        if ($validator->fails()) {
            return $this->responseNotValidInput("Ada field yang tidak valid", $validator->errors());
        }
        
        $user = Auth::user();
        if($input->name) $user->name = $input->name;
        if($input->birth_date) $user->birth_date = $input->birth_date;
        if($input->phone_number) $user->no_hp = $input->phone_number;
        if($input->email) $user->email = $input->email;
        if($input->gender) $user->gender = $input->gender;
        $user->save();

        return $this->responseOK(null, User::mapData($user));
    }

    public function income() {
        $data = WalletHistory::where('user_id', Auth::user()->id)->get();
        $data = $data->map(function($item) {
            return WalletHistory::mapData($item);
        });
        return $this->responseOK(null, $data);
    }

}
