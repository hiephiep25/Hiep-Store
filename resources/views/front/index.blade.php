@extends('front.layout.master')

@section('title', 'Trang chủ')

@section('body')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-items owl-carousel">
        <div class="single-hero-items set-bg" data-setbg="front/img/hero-1.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <span>Khuyến mại</span>
                        <h1>Black Friday</h1>
                        <p>Giảm giá cực ưu đãi</p>
                        <a href="#" class="primary-btn">Mua hàng</a>
                    </div>
                </div>
                <div class="off-card">
                    <h2>SALE<span>50%</span></h2>
                </div>
            </div>
        </div>
        <div class="single-hero-items set-bg" data-setbg="front/img/hero-1.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <span>Khuyến mại</span>
                        <h1>Sinh nhật cửa hàng</h1>
                        <p>Giảm giá cực ưu đãi</p>
                        <a href="#" class="primary-btn">Mua hàng</a>
                    </div>
                </div>
                <div class="off-card">
                    <h2>SALE<span>40%</span></h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner -->
<div class="banner-section spad">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="single-banner">
                    <img src="front/img/banner-1.jpg" alt="">
                    <div class="inner-text">
                        <h4>Dinh dưỡng</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="single-banner">
                    <img src="front/img/banner-2.jpg" alt="">
                    <div class="inner-text">
                        <h4>Tươi ngon</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="single-banner">
                    <img src="front/img/banner-3.jpg" alt="">
                    <div class="inner-text">
                        <h4>Đảm bảo chất lượng</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- banner -->
<div class="meat-banner spad">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <div class="product-large set-bg" data-setbg="front/img/products/meat.jpg">
                    <h2>Thực phẩm dinh dưỡng</h2>
                    <a href="#">Nhiều hơn</a>
                </div>
            </div>
            <div class="col-lg-8 offset-lg-1">
                <div class="filter-control">
                    <ul>
                        <li class="item active" data-tag="*" data-category="meat">Tất cả</li>
                        <li class="item" data-tag=".5" data-category="meat">Thịt</li>
                        <li class="item" data-tag=".4" data-category="meat">Trứng</li>
                        <li class="item" data-tag=".3" data-category="meat">Bơ sữa</li>
                        <li class="item" data-tag=".6" data-category="meat">Hải sản</li>
                        <li class="item" data-tag=".7" data-category="meat">Thực phẩm đóng hộp</li>
                    </ul>
                </div>
                <div class="product-slider owl-carousel meat">
                    @foreach ($meats as $product)
                    <div class="product-item item {{ $product->category_id }}">
                        <div class="pi-pic">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}">
                            <div class="icon"><i class="icon_heart_alt"></i></div>
                            <ul>
                                <li class="w-icon active"><a href=""><i class="icon_cart_alt"></i></a></li>
                                <li class="quick-view"><a href="shop/product/{{ $product->id }}">Chi tiết</a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="category-name">{{ $product->description }}</div>
                            <a href="">
                                <h5>{{ $product->name }}</h5>
                            </a>
                            <div class="product-price">
                                {{ $product->price }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @foreach ($eggs as $product)
                    <div class="product-item item {{ $product->category_id }}">
                        <div class="pi-pic">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}">
                            <div class="icon"><i class="icon_heart_alt"></i></div>
                            <ul>
                                <li class="w-icon active"><a href=""><i class="icon_cart_alt"></i></a></li>
                                <li class="quick-view"><a href="shop/product/{{ $product->id }}">Chi tiết</a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="category-name">{{ $product->description }}</div>
                            <a href="">
                                <h5>{{ $product->name }}</h5>
                            </a>
                            <div class="product-price">
                                {{ $product->price }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @foreach ($dairies as $product)
                    <div class="product-item item {{ $product->category_id }}">
                        <div class="pi-pic">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}">
                            <div class="icon"><i class="icon_heart_alt"></i></div>
                            <ul>
                                <li class="w-icon active"><a href=""><i class="icon_cart_alt"></i></a></li>
                                <li class="quick-view"><a href="shop/product/{{ $product->id }}">Chi tiết</a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="category-name">{{ $product->description }}</div>
                            <a href="">
                                <h5>{{ $product->name }}</h5>
                            </a>
                            <div class="product-price">
                                {{ $product->price }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @foreach ($seafoods as $product)
                    <div class="product-item item {{ $product->category_id }}">
                        <div class="pi-pic">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}">
                            <div class="icon"><i class="icon_heart_alt"></i></div>
                            <ul>
                                <li class="w-icon active"><a href=""><i class="icon_cart_alt"></i></a></li>
                                <li class="quick-view"><a href="shop/product/{{ $product->id }}">Chi tiết</a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="category-name">{{ $product->description }}</div>
                            <a href="">
                                <h5>{{ $product->name }}</h5>
                            </a>
                            <div class="product-price">
                                {{ $product->price }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @foreach ($cannedFoods as $product)
                    <div class="product-item item {{ $product->category_id }}">
                        <div class="pi-pic">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}">
                            <div class="icon"><i class="icon_heart_alt"></i></div>
                            <ul>
                                <li class="w-icon active"><a href=""><i class="icon_cart_alt"></i></a></li>
                                <li class="quick-view"><a href="shop/product/{{ $product->id }}">Chi tiết</a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="category-name">{{ $product->description }}</div>
                            <a href="">
                                <h5>{{ $product->name }}</h5>
                            </a>
                            <div class="product-price">
                                {{ $product->price }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Deal -->
<section class="deal-of-week set-bg spad" data-setbg="front/img/time-bg.jpg">
    <div class="container">
        <div class="col-lg-6 text-center">
            <div class="section-title">
                <h2>Khuyến mãi đặc biệt trong tuần</h2>
                <p>Giảm giá sản phẩm</p>
                <div class="product-price">
                    $35
                    <span>/ Tương ớt chinsu</span>
                </div>
            </div>
            <div class="countdown-timer" id="countdown">
                <div class="cd-item">
                    <span>56</span>
                    <p>Days</p>
                </div>
                <div class="cd-item">
                    <span>12</span>
                    <p>Hrs</p>
                </div>
                <div class="cd-item">
                    <span>48</span>
                    <p>Mins</p>
                </div>
                <div class="cd-item">
                    <span>52</span>
                    <p>Secs</p>
                </div>
            </div>
            <a href="" class="primary-btn">Mua ngay</a>
        </div>
    </div>
</section>
<!-- banner -->
<div class="vegetables-banner spad">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="filter-control">
                    <ul>
                        <li class="item active" data-tag="*" data-category="fruits">Tất cả</li>
                        <li class="item" data-tag=".1" data-category="fruits">Hoa quả</li>
                        <li class="item" data-tag=".2" data-category="fruits">Rau</li>
                        <li class="item" data-tag=".8" data-category="fruits">Đồ ăn vặt</li>
                        <li class="item" data-tag=".10" data-category="fruits">Đồ uống</li>
                        <li class="item" data-tag=".9" data-category="fruits">Gia vị và nước sốt</li>
                    </ul>
                </div>
                <div class="product-slider owl-carousel fruits">
                    @foreach ($fruits as $product)
                    <div class="product-item item {{ $product->category_id }}">
                        <div class="pi-pic">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}">
                            <div class="icon"><i class="icon_heart_alt"></i></div>
                            <ul>
                                <li class="w-icon active"><a href=""><i class="icon_cart_alt"></i></a></li>
                                <li class="quick-view"><a href="shop/product/{{ $product->id }}">Chi tiết</a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="category-name">{{ $product->description }}</div>
                            <a href="">
                                <h5>{{ $product->name }}</h5>
                            </a>
                            <div class="product-price">
                                {{ $product->price }}
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @foreach ($vegetables as $product)
                    <div class="product-item item {{ $product->category_id }}">
                        <div class="pi-pic">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}">
                            <div class="icon"><i class="icon_heart_alt"></i></div>
                            <ul>
                                <li class="w-icon active"><a href=""><i class="icon_cart_alt"></i></a></li>
                                <li class="quick-view"><a href="shop/product/{{ $product->id }}">Chi tiết</a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="category-name">{{ $product->description }}</div>
                            <a href="">
                                <h5>{{ $product->name }}</h5>
                            </a>
                            <div class="product-price">
                                {{ $product->price }}
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @foreach ($snacks as $product)
                    <div class="product-item item {{ $product->category_id }}">
                        <div class="pi-pic">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}">
                            <div class="icon"><i class="icon_heart_alt"></i></div>
                            <ul>
                                <li class="w-icon active"><a href=""><i class="icon_cart_alt"></i></a></li>
                                <li class="quick-view"><a href="shop/product/{{ $product->id }}">Chi tiết</a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="category-name">{{ $product->description }}</div>
                            <a href="">
                                <h5>{{ $product->name }}</h5>
                            </a>
                            <div class="product-price">
                                {{ $product->price }}
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @foreach ($drinks as $product)
                    <div class="product-item item {{ $product->category_id }}">
                        <div class="pi-pic">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}">
                            <div class="icon"><i class="icon_heart_alt"></i></div>
                            <ul>
                                <li class="w-icon active"><a href=""><i class="icon_cart_alt"></i></a></li>
                                <li class="quick-view"><a href="shop/product/{{ $product->id }}">Chi tiết</a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="category-name">{{ $product->description }}</div>
                            <a href="">
                                <h5>{{ $product->name }}</h5>
                            </a>
                            <div class="product-price">
                                {{ $product->price }}
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @foreach ($spices as $product)
                    <div class="product-item item {{ $product->category_id }}">
                        <div class="pi-pic">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}">
                            <div class="icon"><i class="icon_heart_alt"></i></div>
                            <ul>
                                <li class="w-icon active"><a href=""><i class="icon_cart_alt"></i></a></li>
                                <li class="quick-view"><a href="shop/product/{{ $product->id }}">Chi tiết</a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="category-name">{{ $product->description }}</div>
                            <a href="">
                                <h5>{{ $product->name }}</h5>
                            </a>
                            <div class="product-price">
                                {{ $product->price }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-3 offset-lg-1">
                <div class="product-large set-bg" data-setbg="front/img/products/vegetables.jpg">
                    <h2>Thực phẩm sạch</h2>
                    <a href="#">Nhiều hơn</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Insta -->
<div class="instagram-photo">
    <div class="insta-item set-bg" data-setbg="front/img/insta-1.jpg">
        <div class="inside-text">
            <i class="ti-instagram"></i>
            <h5><a href="#">Món ăn ngon</a></h5>
        </div>
    </div>
    <div class="insta-item set-bg" data-setbg="front/img/insta-2.jpg">
        <div class="inside-text">
            <i class="ti-instagram"></i>
            <h5><a href="#">Món ăn ngon</a></h5>
        </div>
    </div>
    <div class="insta-item set-bg" data-setbg="front/img/insta-3.jpg">
        <div class="inside-text">
            <i class="ti-instagram"></i>
            <h5><a href="#">Món ăn ngon</a></h5>
        </div>
    </div>
    <div class="insta-item set-bg" data-setbg="front/img/insta-4.jpg">
        <div class="inside-text">
            <i class="ti-instagram"></i>
            <h5><a href="#">Món ăn ngon</a></h5>
        </div>
    </div>
    <div class="insta-item set-bg" data-setbg="front/img/insta-5.jpg">
        <div class="inside-text">
            <i class="ti-instagram"></i>
            <h5><a href="#">Món ăn ngon</a></h5>
        </div>
    </div>
    <div class="insta-item set-bg" data-setbg="front/img/insta-6.jpg">
        <div class="inside-text">
            <i class="ti-instagram"></i>
            <h5><a href="#">Món ăn ngon</a></h5>
        </div>
    </div>
</div>
@endsection
