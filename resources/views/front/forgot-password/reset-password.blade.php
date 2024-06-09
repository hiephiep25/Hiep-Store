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
                    <h2>Đặt lại mật khẩu</h2>

                    @if(session('notification'))
                    <div class="alert alert-warning" role="alert">
                        {{session('notification')}}
                    </div>
                    @endif

                    <form action="" method="post">
                        @csrf
                        <div class="group-input">
                            <label for="pass">Mật khẩu</label>
                            <input type="password" id="pass" name="password">
                        </div>
                        <div class="group-input">
                            <label for="pass">Xác nhận mật khẩu</label>
                            <input type="password" id="pass" name="password_confirm">
                        </div>
                        <button type="submit" class="site-btn login-btn">Đổi mật khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
