@extends('front.layout.master')
@section('title','Thanh toán')
@section('body')
<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="./"><i class="fa fa-home"></i></a>
                    <a href="./shop">Cửa hàng</a>
                    <span>Thanh toán</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Check out -->
<div class="checkout-section spad">
    <div class="container">
        <form action="" method="post" class="checkout-form">
            @csrf
            <div class="row">
                @if(Cart::count()>0)
                <div class="col-lg-6">
                    <h4>Thông tin đơn hàng</h4>
                    <div class="row">
                        <input type="hidden" id="user_id" name="user_id" value="{{Auth::user()->id  ?? ''}}">
                        <div class="col-lg-6">
                            <label for="fir"> Họ tên <span>*</span></label>
                            <input type="text" id="first_name" name="name" value="{{Auth::user()->name ?? ''}}" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="email"> Email <span>*</span></label>
                            <input type="text" id="email" name="email" value="{{Auth::user()->email ?? ''}}" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="phone"> SDT <span>*</span></label>
                            <input type="text" id="phone" name="phone" value="{{Auth::user()->phone ?? ''}}" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="phone"> Địa chỉ <span>*</span></label>
                            <input type="text" id="address" name="address" value="{{Auth::user()->address ?? ''}}" required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="place-order">
                        <h4>Đơn hàng của bạn</h4>
                        <div class="order-total">
                            <ul class="order-table">
                                <li>Thực phẩm <span>Tổng tiền</span></li>
                                @foreach($carts as $cart)
                                <li class="fw-normal">{{$cart->name}} x {{$cart->qty}} <span>{{$cart->price * $cart->qty}} VND</span></li>
                                @endforeach
                                <li class="fw-normal">Tổng tiền <span>{{$subtotal}} VND</span></li>
                                <li class="total-price">Thành tiền <span>{{$total}} VND</span></li>
                            </ul>
                            <div class="payment-check">
                                <div class="pc-item">
                                    <label for="pc-check">
                                        Thanh toán sau khi nhận hàng
                                        <input type="radio" id="pc-check" name="payment_type" value="pay_later" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="pc-item">
                                    <label for="pc-paypal">
                                        Thanh toán đơn hàng trực tuyến
                                        <input type="radio" id="pc-paypal" name="payment_type" value="online_payment">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="order-btn">
                                @if(Auth::check())
                                <button type="submit" class="site-btn place-btn">Đặt hàng</button>
                                @else
                                Bạn cần <a href="./login">đăng nhập</a> để có thể thanh toán
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
                @else
                <div class="col-lg-12">
                    <h4>Giỏ hàng của bạn trống</h4>
                </div>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
