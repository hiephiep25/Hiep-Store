<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\LoginService;
use Illuminate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\JsonResponse;

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
            'email.required' => 'Hãy nhập email',
            'email.email' => 'Email không hợp lệ',
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

    public function forgotPassword(Request $request) : JsonResponse
    {
        $email = $request->input('email');
        $result = $this->loginService->forgotPassword($email);

        if ($result) {

            return response()->json(['message' => 'Thư đã được gửi, hãy kiểm tra email của bạn'], 200);
        }

        return response()->json(['message' => 'Không tìm thấy email'], 401);
    }

    public function resetPassword(ChangePasswordRequest $request) : JsonResponse
    {
        $token = $request->token;
        $password = $request->password;

        $result = $this->loginService->resetPassword($token, $password);

        if ($result['status'] === 'error') {

            return response()->json(['message' => $result['message']], 401);
        }

        return response()->json(['message' => $result['message']], 200);
    }
}
