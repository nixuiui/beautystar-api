<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
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

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(app('auth')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        app('auth')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(app('auth')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $data = [
            'id' => app('auth')->id(),
            'name' => app('auth')->user()->name,
            'username' => app('auth')->user()->username,
            'email' => app('auth')->user()->email,
            'balance' => app('auth')->user()->balance,
            'gender' => app('auth')->user()->gender,
            'birth_date' => app('auth')->user()->birth_date,
            // 'photo' => app('auth')->user()->photo,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => app('auth')->factory()->getTTL() * 60
        ];
        return $this->responseOK(null, $data);
    }
}