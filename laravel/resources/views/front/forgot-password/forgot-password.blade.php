@extends('front.layout.master')
@section('title','Quên mật khẩu')
@section('body')
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="./"><i class="fa fa-home"></i></a>
                    <span>Quên mật khẩu</span>
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
                    <h2>Quên mật khẩu</h2>

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
                        <button type="submit" class="site-btn login-btn">Gửi</button>
                    </form>
                    <div class="switch-login">
                        <a href="./login" class="or-login">Đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
