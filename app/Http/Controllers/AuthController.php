<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    
    public function login(Request $request) {
        $loginWithEmail = app('auth')->attempt(['email' => $request->username, 'password' => $request->password]);
        $loginWithUsername = app('auth')->attempt(['username' => $request->username, 'password' => $request->password]);
        if ($loginWithEmail) {
            $token = $loginWithEmail;
        }
        else if($loginWithUsername) {
            $token = $loginWithUsername;
        }
        else {
            return $this->responseError("Maaf user tidak ditemukan.", null);
        }

        return $this->respondWithToken($token);
    }

    public function username(Request $request) {
        if(User::where('username', $request->username)->first())
            return $this->responseError("Username sudah digunakan");
        return $this->responseOK("Username tersedia");
    }
    
    public function email(Request $request) {
        if(User::where('email', $request->email)->first())
            return $this->responseError("Email sudah digunakan");
        return $this->responseOK("Email tersedia");
    }
    
    public function logout() {
        app('auth')->logout();
        return $this->responseOK('Successfully logged out', null);
    }

    public function refresh() {
        return $this->respondWithToken(app('auth')->refresh());
    }

    protected function respondWithToken($token) {
        $token = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => app('auth')->factory()->getTTL() * 60
        ];
        $data = User::mapData(app('auth')->user(), $token);
        return $this->responseOK(null, $data);
    }
}