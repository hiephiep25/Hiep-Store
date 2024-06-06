<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class RegisterController extends Controller
{
    public function index(){
        return view('front.register.index');
    }

    public function register(Request $request){
        if($request->password != $request->password_confirmation){
            return back()->with('notification', 'Xác nhận mật khẩu không khớp');
        }

        $data = [
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'role'=> User::ROLE_CUSTOMER,
        ];
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->level= $data['level'];
        $user->save();
       return redirect('./login')->with('notification', 'Đăng kí thành công!');
    }

}
