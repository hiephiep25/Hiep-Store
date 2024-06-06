@extends('front.layout.master')

@section('title', 'Cửa hàng')

@section('body')
<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="./"><i class="fa fa-home"></i></a>
                    <span>Cửa hàng</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product -->
<section class="product-shop spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
                <div class="filter-widget">
                    <h4 class="fw-title">Loại thực phẩm</h4>
                    <ul class="filter-catagories">
                        @foreach ($categories as $category)
                            <li><a href="#">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="filter-widget">
                    <h4 class="fw-title">Giá (nghìn VND)</h4>
                    <div class="filter-range-wrap">
                        <div class="range-slider">
                            <div class="price-input">
                                <input type="text" id="minamount">
                                <input type="text" id="maxamount">
                            </div>
                        </div>
                        <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content" data-min="5" data-max="1000">
                            <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                            <span tabindex="8" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                            <span tabindex="8" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                        </div>
                    </div>
                    <a href="#" class="filter-btn">Lọc</a>
                </div>
            </div>
            <div class="col-lg-9 order-1 order-lg-2">
                <div class="product-show-option">
                    <div class="row">
                        <div class="col-lg-7 col-md-7">
                            <div class="select-option">
                                <select class="sorting">
                                    <option value="">Default sorting</option>
                                </select>
                                <select class="p-show">
                                    <option value="">Hiển thị</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-list">
                    <div class="row">
                        @foreach ($products as $product)
                        <div class="col-lg-4 col-sm-6">
                            <div class="product-item">
                                <div class="pi-pic">
                                    <img src="{{ $product->image }}" alt="">
                                    <div class="icon">
                                        <i class="icon_heart_alt"></i>
                                    </div>
                                    <ul>
                                        <li class="w-icon active"><a href="#"><i class="icon_cart_alt"></i></a></li>
                                        <li class="quick-view"><a href="shop/product/{{ $product->id }}">Chi tiết</a></li>
                                    </ul>
                                </div>
                                <div class="pi-text">
                                    <div class="catagory-name">{{ $product->description }}</div>
                                    <a href="#">
                                        <h5>{{ $product->name }}</h5>
                                    </a>
                                    <div class="product-price">
                                        {{ $product->price_per_qty }} VND
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <span>{!! $products->withQueryString()->links('pagination::bootstrap-5') !!}</span>
            </div>
        </div>
    </div>
</section>

@endsection
