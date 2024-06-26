<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailResetPassword;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{

    public function index(){
        return view('front.forgot-password.forgot-password');
    }

    public function forgotPassword(Request $request){
        $email = $request->email;
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

        Mail::to($user->email)->send(new SendMailResetPassword($user, $token));

        return view('front.forgot-password.result-forgot-password');
    }

    public function show() {
        return view('front.forgot-password.reset-password');
    }

    public function resetPassword(Request $request) {
        $token = $request->token;
        $password = $request->password;
        $passwordConfirm = $request->password_confirm;

        if ($password != $passwordConfirm) {

            return back()->with('notification','Xác nhận mật khẩu không đúng');
        }

        $passwordReset = PasswordReset::where('token', $token)->first();

        if (!$passwordReset) {

            return back()->with('notification', 'Token không hợp lệ');
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user) {

            return back()->with('notification', 'Không tìm thấy user');
        }

        $user->password = Hash::make($password);
        $user->save();

        PasswordReset::where('email', $user->email)->delete();

        return redirect()->route('login')->with('notification', 'Mật khẩu đã được đổi');
    }
}
