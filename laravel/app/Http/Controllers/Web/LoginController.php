<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class LoginController extends Controller
{
    public function index(){
        return view('front.login.index');
    }

    public function checkLogin(Request $request){
        $credentials = [
            'email'=> $request->email,
            'password'=> $request->password,
            'role' => User::ROLE_CUSTOMER,
        ];

        $remember = $request->remember;
        if( Auth::attempt($credentials, $remember)){
            return redirect('');
        } else{
            return back()->with('notification','Tài khoản hoặc mật khẩu không đúng!');
        }
    }

    public function logout(){
        Auth::logout();
        return back();
    }
}
