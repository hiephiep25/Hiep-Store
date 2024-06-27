@extends('front.layout.master')
@section('title','Đăng kí')
@section('body')
<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="./"><i class="fa fa-home"></i></a>
                    <span>Đăng kí</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login -->
<div class="register-login-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="login-form">
                    <h2>Đăng kí</h2>
                    @if(session('notification'))
                    <div class="alert alert-warning" role="alert">
                        {{session('notification')}}
                    </div>
                    @endif
                    <form action="" method="post">
                        @csrf
                        <div class="group-input">
                            <label for="name">Tên</label>
                            <input type="text" id="name" name="name">
                        </div>
                        <div class="group-input">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email">
                        </div>
                        <div class="group-input">
                            <label for="pass">Mật khẩu</label>
                            <input type="password" id="pass" name="password">
                        </div>
                        <div class="group-input">
                            <label for="con-pass">Xác nhận mật khẩu</label>
                            <input type="password" id="con-pass" name="password_confirmation">
                        </div>
                        <button type="submit" class="site-btn register-btn">Đăng kí</button>
                    </form>
                    <div class="switch-login">
                        <a href="./login" class="or-login">Đã có tài khoản? Đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
