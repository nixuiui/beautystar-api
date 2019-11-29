<?php

namespace App\Http\Controllers;

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

}
