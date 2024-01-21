<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\LoginService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'     => 'required',
            'password'  => 'required|string',
        ], [
            'email.required' => 'Please enter email',
            'email.email' => 'Email is invalid',
        ]);

        $credentials = $request->only(['email', 'password']);
        $auth = $this->loginService->login($credentials, $request->remember ?? false);

        return response()->json([
            'access_token' => $auth['token'],
            'token_type' => 'Bearer',
            'expires_at' => $auth['expires']
        ])->withCookie(COOKIE_AUTHORIZATION, 'Bearer ' . $auth['token'], config('sanctum.expiration'));
    }

    public function verify(Request $request)
    {
        return response()->json([
            'is_login' => $this->loginService->verify($request)
        ]);
    }

    public function logout(Request $request)
    {
        $this->loginService->logout($request);
        return response()->json();
    }
}
