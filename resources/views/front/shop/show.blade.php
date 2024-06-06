@php
    use Carbon\Carbon;
@endphp

@extends('front.layout.master')

@section('title', 'Thực phẩm')

@section('body')
<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="index.html"><i class="fa fa-home"></i></a>
                    <a href="./">Cửa hàng</a>
                    <span>Chi tiết</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product -->
<section class="product-shop spad page-details">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">

            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="product-pic-zoom">
                            <img class="product-big-img" src="{{ $product->image }}" alt="">
                            <div class="zoom-icon">
                                <i class="fa fa-search-plus"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="product-details">
                            <div class="pd-title">
                                <span>{{ $product->code }}</span>
                                <h3>{{ $product->name }}</h3>
                                <a href="#" class="heart-icon"><i class="icon_heart_alt"></i></a>
                            </div>
                            <div class="pd-desc">
                                <p>{{ $product->description }}</p>
                                <h4>{{ $product->price_per_qty }} VND</h4>
                            </div>
                            <div class="quantity">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1">
                                    </div>
                                    <a href="#" class="primary-btn pd-cart">Thêm giỏ hàng</a>
                                </div>
                            </div>
                            <ul class="pd-tags">
                                <li><span>Brand: </span>{{ $product->brand }}</li>
                                <li><span>Loại thực phẩm: </span>{{ $product->category->name }}</li>
                                <li><span>NSX:</span> {{ Carbon::parse($product->manufacture_day)->format('d-m-Y') }}</li>
                                <li><span>HSD:</span> {{ Carbon::parse($product->expiry_day)->format('d-m-Y') }}</li>
                            </ul>
                            <div class="pd-share">
                                <div class="p-code">Số lượng còn lại: {{ $product->qty }}</div>
                                <div class="pd-social">
                                    <a href="#"><i class="ti-facebook"></i></a>
                                    <a href="#"><i class="ti-twitter-alt"></i></a>
                                    <a href="#"><i class="ti-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Related Products -->
<div class="related-products spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Sản phẩm liên quan</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($relatedProducts as $relatedProduct)
            <div class="col-lg-3 col-sm-6">
                @include('front.components.product-item', ['product' => $relatedProduct])
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

