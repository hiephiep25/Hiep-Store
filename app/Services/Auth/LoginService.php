<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\PasswordReset;

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

    public function forgotPassword($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return false;
        }

        $passwordReset = PasswordReset::where('email', $email)->first();

        if ($passwordReset) {
            PasswordReset::where('email', $email)->delete();
        }

        $token = hash::make(Str::random(40));

        PasswordReset::insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::to($user->email)->send(new SendMail($user, $token));

        return true;
    }

    public function resetPassword($token, $password)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();

        if (!$passwordReset) {

            return ['status' => 'error', 'message' => 'Token không hợp lệ'];
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user) {

            return ['status' => 'error', 'message' => 'Không tìm thấy user'];
        }

        $user->password = Hash::make($password);
        $user->save();

        PasswordReset::where('email', $user->email)->delete();

        return ['status' => 'success', 'message' => 'Mật khẩu đã được đổi'];
    }
}
