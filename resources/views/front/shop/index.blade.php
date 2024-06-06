@php
    $currentCategoryId = request()->segment(2);
@endphp

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
                @include('front.components.products-sidebar-filter')
            </div>
            <div class="col-lg-9 order-1 order-lg-2">
                <div class="product-show-option">
                    <div class="row">
                        <div class="col-lg-7 col-md-7">

                                <div class="select-option">
                                    <select name=sort_by class="sorting" onchange="this.form.submit()">
                                        <option {{request('sort_by')=='lastest'?'selected':''}} value="lastest">Mới nhất</option>
                                        <option {{request('sort_by')=='oldest'?'selected':''}} value="oldest">Cũ nhất</option>
                                        <option {{request('sort_by')=='price-ascending'?'selected':''}} value="price-ascending">Rẻ nhất</option>
                                        <option {{request('sort_by')=='price-descending'?'selected':''}} value="price-descending">Đắt nhất</option>
                                    </select>
                                    <select name="show" class="p-show" onchange="this.form.submit()">
                                        <option {{request('show')=='9'?'selected':''}} value="9">Hiển thị: 9</option>
                                        <option {{request('show')=='12'?'selected':''}} value="12">Hiển thị: 12</option>
                                        <option {{request('show')=='15'?'selected':''}} value="15">Hiển thị: 15</option>
                                    </select>
                                </div>

                        </div>
                    </div>
                </div>
                <div class="product-list">
                    <div class="row">
                        @foreach ($products as $product)
                        <div class="col-lg-4 col-sm-6">
                            @include('front.components.product-item', ['product' => $product])
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
