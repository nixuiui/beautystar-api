<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

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
            'birth_date'    => 'required|date',
            'phone_number'  => 'required|numeric',
            'gender'        => 'required|in:1101,1102'
        ]);
        if ($validator->fails()) {
            return $this->responseNotValidInput("Ada field yang tidak valid", $validator->errors());
        }
        
        $user = Auth::user();
        $user->name = $input->name;
        $user->birth_date = $input->birth_date;
        $user->no_hp = $input->phone_number;
        $user->gender = $input->gender;
        $user->save();

        return $this->responseOK(null, User::mapData($user));
    }

}
