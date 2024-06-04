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
        <div class="single-hero-items set-bg" data-setbg="front/img/hero-2.jpg">
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
                    <h2>Thực phẩm thịt</h2>
                    <a href="#">Nhiều hơn</a>
                </div>
            </div>
            <div class="col-lg-8 offset-lg-1">
                <div class="filter-control">
                    <ul>
                        <li class="active">Bò</li>
                        <li>Lợn</li>
                        <li>Gà</li>
                        <li>Khác</li>
                    </ul>
                </div>
                <div class="product-slider owl-carousel">
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="front/img/products/product-1.jpg" alt="">
                            <div class="sale">Sale</div>
                            <div class="icon"><i class="icon_heart_alt"></i></div>
                            <ul>
                                <li class="w-icon active"><a href=""><i class="icon_cart_alt"></i></a></li>
                                <li class="quick-view"><a href="product.html">Chi tiết</a></li>
                                <li class="w-icon"><a href=""><i class="fa fa-random"></i></a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="category-name">Bò</div>
                            <a href="">
                                <h5>Thăn Bò</h5>
                            </a>
                            <div class="product-price">
                                $14
                                <span>$35</span>
                            </div>
                        </div>

                    </div>
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="front/img/products/product-2.jpg" alt="">
                            <div class="sale">Sale</div>
                            <div class="icon"><i class="icon_heart_alt"></i></div>
                            <ul>
                                <li class="w-icon active"><a href=""><i class="icon_cart_alt"></i></a></li>
                                <li class="quick-view"><a href="product.html">Chi tiết</a></li>
                                <li class="w-icon"><a href=""><i class="fa fa-random"></i></a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="category-name">Bò</div>
                            <a href="">
                                <h5>Nạc bò</h5>
                            </a>
                            <div class="product-price">
                                $14
                                <span>$35</span>
                            </div>
                        </div>

                    </div>
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="front/img/products/product-3.jpg" alt="">
                            <div class="sale">Sale</div>
                            <div class="icon"><i class="icon_heart_alt"></i></div>
                            <ul>
                                <li class="w-icon active"><a href=""><i class="icon_cart_alt"></i></a></li>
                                <li class="quick-view"><a href="product.html">Chi tiết</a></li>
                                <li class="w-icon"><a href=""><i class="fa fa-random"></i></a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="category-name">Bò</div>
                            <a href="">
                                <h5>Steak bò</h5>
                            </a>
                            <div class="product-price">
                                $14
                                <span>$35</span>
                            </div>
                        </div>

                    </div>
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="front/img/products/product-4.jpg" alt="">
                            <div class="sale">Sale</div>
                            <div class="icon"><i class="icon_heart_alt"></i></div>
                            <ul>
                                <li class="w-icon active"><a href=""><i class="icon_cart_alt"></i></a></li>
                                <li class="quick-view"><a href="product.html">Chi tiết</a></li>
                                <li class="w-icon"><a href=""><i class="fa fa-random"></i></a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="category-name">Bò</div>
                            <a href="">
                                <h5>Ba chỉ bò thái mỏng</h5>
                            </a>
                            <div class="product-price">
                                $14
                                <span>$35</span>
                            </div>
                        </div>

                    </div>
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
            <a href="" class="primary-btn">Shop now</a>
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
                        <li class="active">Hoa quả</li>
                        <li>Rau sạch</li>
                        <li>Rau ăn kèm</li>
                        <li>Khác</li>
                    </ul>
                </div>
                <div class="product-slider owl-carousel">
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="front/img/products/product1.jpg" alt="">
                            <div class="sale">Sale</div>
                            <div class="icon"><i class="icon_heart_alt"></i></div>
                            <ul>
                                <li class="w-icon active"><a href=""><i class="icon_cart_alt"></i></a></li>
                                <li class="quick-view"><a href="product.html">Chi tiết</a></li>
                                <li class="w-icon"><a href=""><i class="fa fa-random"></i></a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="category-name">Coat</div>
                            <a href="">
                                <h5>Pure Pineapple</h5>
                            </a>
                            <div class="product-price">
                                $14
                                <span>$35</span>
                            </div>
                        </div>

                    </div>
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="front/img/products/product2.jpg" alt="">
                            <div class="sale">Sale</div>
                            <div class="icon"><i class="icon_heart_alt"></i></div>
                            <ul>
                                <li class="w-icon active"><a href=""><i class="icon_cart_alt"></i></a></li>
                                <li class="quick-view"><a href="product.html">Chi tiết</a></li>
                                <li class="w-icon"><a href=""><i class="fa fa-random"></i></a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="category-name">Coat</div>
                            <a href="">
                                <h5>Pure Pineapple</h5>
                            </a>
                            <div class="product-price">
                                $14
                                <span>$35</span>
                            </div>
                        </div>

                    </div>
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="front/img/products/product3.jpg" alt="">
                            <div class="sale">Sale</div>
                            <div class="icon"><i class="icon_heart_alt"></i></div>
                            <ul>
                                <li class="w-icon active"><a href=""><i class="icon_cart_alt"></i></a></li>
                                <li class="quick-view"><a href="product.html">Chi tiết</a></li>
                                <li class="w-icon"><a href=""><i class="fa fa-random"></i></a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="category-name">Coat</div>
                            <a href="">
                                <h5>Pure Pineapple</h5>
                            </a>
                            <div class="product-price">
                                $14
                                <span>$35</span>
                            </div>
                        </div>

                    </div>
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="front/img/products/product4.jpg" alt="">
                            <div class="sale">Sale</div>
                            <div class="icon"><i class="icon_heart_alt"></i></div>
                            <ul>
                                <li class="w-icon active"><a href=""><i class="icon_cart_alt"></i></a></li>
                                <li class="quick-view"><a href="product.html">Chi tiết</a></li>
                                <li class="w-icon"><a href=""><i class="fa fa-random"></i></a></li>
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="category-name">Coat</div>
                            <a href="">
                                <h5>Pure Pineapple</h5>
                            </a>
                            <div class="product-price">
                                $14
                                <span>$35</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 offset-lg-1">
                <div class="product-large set-bg" data-setbg="front/img/products/vegetables.jpg">
                    <h2>Rau củ quả</h2>
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
