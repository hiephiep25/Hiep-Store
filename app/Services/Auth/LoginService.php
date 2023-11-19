<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginService
{
    public function login(array $data, bool $remember): array
    {
        $isAuth = Auth::attempt($data, $remember);

        abort_if(!$isAuth, Response::HTTP_UNAUTHORIZED, 'Your email or password is incorrect');

        return [
            'token' => Auth::user()->createToken('authToken')->plainTextToken,
            'expires' => now()->addMinutes(config('sanctum.expiration'))
        ];
    }

    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        return DB::table('personal_access_tokens')->where('id', explode('|', $token, 2)[0])->delete();
    }

    public function verify(Request $request): bool
    {
        if (!$request->cookie(COOKIE_AUTHORIZATION)) {
            return false;
        }

        $request->headers->set(COOKIE_AUTHORIZATION, $request->cookie(COOKIE_AUTHORIZATION));
        return Auth::guard('sanctum')->check();
    }
}
