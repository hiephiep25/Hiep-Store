@extends('front.layout.master')
@section('title','Giỏ hàng')
@section('body')
<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="./"><i class="fa fa-home"></i></a>
                    <a href="./shop">Cửa hàng</a>
                    <span>Giỏ hàng</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shopping Cart -->
<div class="shopping-cart spad">
    <div class="container">
        <div class="row">
            @if(Cart::count() > 0)
            <div class="col-lg-12">
                <div class="cart-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Ảnh</th>
                                <th class="p-name">Tên thực phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                                <th><i onclick="confirm('Are you sure') ===true? window.location='./cart/destroy' :'' " class="ti-close" style="cursor: pointer"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carts as $cart)
                            <tr>
                                <td class="cart-pic first-row"><img style="height:120px" src="{{$cart->options->image}}" alt=""></td>
                                <td class="cart-title first-row">
                                    <h5>{{$cart->name}}</h5>
                                </td>
                                <td class="p-price first-row"> {{number_format($cart->price)}} VND</td>
                                <td class="qua-col first-row">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="text" value="{{$cart->qty}}" data-rowid="{{$cart->rowId}}">
                                        </div>
                                    </div>
                                </td>
                                <td class="total-price first-row"> {{number_format($cart->price * $cart->qty)}} VND</td>
                                <td class="close-td first-row"><a href="./cart/delete/{{$cart->rowId}}"><i class="ti-close"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="cart-buttons">
                            <a href="./shop" class="primary-btn continue-shop">Tiếp tục mua hàng</a>
                            <a href="#" class="primary-btn up-cart">Cập nhật giỏ hàng</a>
                        </div>
                        <div class="discount-coupon">
                            <h6>Mã giảm giá</h6>
                            <form action="#" class="coupon-form">
                                <input type="text" placeholder="Nhập mã">
                                <button type="submit" class="site-btn coupon-btn">Áp dụng</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4 offset-lg-4">
                        <div class="proceed-checkout">
                            <ul>
                                <li class="subtotal">Tổng tiền <span> {{$subtotal}} VND</span></li>
                                <li class="cart-total">Thành tiền <span> {{$total}} VND</span></li>
                            </ul>
                            <a href="./checkout" class="proceed-btn">Thanh toán</a>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class=col-lg-12>
                <h4>Giỏ hàng của bạn trống!</h4>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
