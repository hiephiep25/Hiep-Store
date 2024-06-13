@extends('front.layout.master')
@section('title','Kết quả')
@section('body')
<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="./"><i class="fa fa-home"></i></a>
                    <a href="./checkout">Thanh toán</a>
                    <span>Kết quả</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Check out -->
<div class="checkout-section spad">
    <div class="container">
       <div class="col-lg-12">
            <h4>
                {{$notification}}
            </h4>
            <a href="./" class="primary-btn mt-5">Tiếp tục mua hàng</a>
       </div>
    </div>
</div>
@endsection
