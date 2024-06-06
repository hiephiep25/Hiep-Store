@extends('front.layout.master')
@section('title','Đăng nhập')
@section('body')
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="./"><i class="fa fa-home"></i></a>
                    <span>Đăng nhập</span>
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
                    <h2>Đăng nhập</h2>

                    @if(session('notification'))
                    <div class="alert alert-warning" role="alert">
                        {{session('notification')}}
                    </div>
                    @endif

                    <form action="" method="post">
                        @csrf
                        <div class="group-input">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email">
                        </div>
                        <div class="group-input">
                            <label for="pass">Mật khẩu</label>
                            <input type="password" id="pass" name="password">
                        </div>
                        <div class="group-input gi-check">
                            <div class="gi-more">
                                <label for="save-pass">
                                Nhớ mật khẩu
                                <input type="checkbox" id="save-pass" name="remember">
                                <span class="checkmark"></span>
                            </label>
                            <a href="./admin/password-reset" class="forget-pass">Bạn quên mật khẩu?</a>
                            </div>
                        </div>
                        <button type="submit" class="site-btn login-btn">Đăng nhập</button>
                    </form>
                    <div class="switch-login">
                        <a href="./register" class="or-login">Chưa có tài khoản? Đăng ký</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
