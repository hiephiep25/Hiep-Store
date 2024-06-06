<!DOCTYPE html>
<html lang="zxx">

<head>
    <base href="{{ asset('/') }}">
    <meta charset="UTF-8">
    <meta name="description" content="codelean Template">
    <meta name="keywords" content="codelean, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="front/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="front/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="front/css/themify-icons.css" type="text/css">
    <link rel="stylesheet" href="front/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="front/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="front/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="front/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="front/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="front/css/style.css" type="text/css">
</head>

<body>
    <!-- Start coding here -->
    <!-- Page preloder -->
    {{-- <div id="preloder">
        <div class="loader"></div>
    </div> --}}
    <!-- Header -->

    <div class="container">
        <div class="chatbox">
            <div class="chatbox__support">
                <div class="chatbox__header">
                    <div class="chatbox__image--header">
                        <img src="front/img/chat/chatbot.png" alt="image">
                    </div>
                    <div class="chatbox__content--header">
                        <h4 class="chatbox__heading--header">Bot</h4>
                        <p class="chatbox__description--header">Xin chào, tôi là Bot, tôi có thể giúp gì được cho bạn?</p>
                    </div>
                </div>
                <div class="chatbox__messages">
                    <div></div>
                </div>
                <div class="chatbox__footer">
                    <input type="text" placeholder="Nhập câu hỏi...">
                    <button class="chatbox__send--footer send__button">Gửi</button>
                </div>
            </div>
            <div class="chatbox__button">
                <button><img src="front/img/chat/chatbox-icon.svg" /></button>
            </div>
        </div>
    </div>

    <header class="header-section">
        <div class="header-top">
            <div class="container">
                <div class="ht-left">
                    <div class="mail-service">
                        <i class="fa fa-envelope"></i>
                        hiep.nd200213@sis.hust.edu.vn
                    </div>
                    <div class="phone-service">
                        <i class="fa fa-phone"></i>
                        0366125502
                    </div>
                </div>
            </div>
            <div class="ht-right">
                <a href="./login" class="login-panel"><i class="fa fa-user"></i>Đăng nhập</a>
                <div class="top-social">
                    <a href="#"><i class="ti-facebook"></i></a>
                    <a href="#"><i class="ti-twitter-alt"></i></a>
                    <a href="#"><i class="ti-instagram"></i></a>
                    <a href="#"><i class="ti-pinterest"></i></a>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="inner-header">
                <div class="row">
                    <div class="col-lg-2 col-md-2">
                        <div class="logo">
                            <a href="index.html">
                                <img src="front/img/logo.png" width="200" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <form action="shop">
                            <div class="advanced-search">
                                <button type="button" class="category-btn">Tìm kiếm</button>
                                <div class="input-group">
                                    <input name="search" type="text" value="{{request('search')}}" placeholder="Bạn cần mua gì?">
                                    <button type="submit"><i class="ti-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-3 col-md-3 text-right">
                        <ul class="nav-right">
                            <li class="cart-icon">
                                <a href="./cart">
                                    <i class="icon_cart_alt"></i>
                                    <span>{{Cart::count()}}</span>
                                </a>
                                <div class="cart-hover">
                                    <div class="select-items">
                                        <table>
                                            <tbody>
                                                @foreach(Cart::content() as $cart)
                                                <tr>
                                                    <td class="si-pic"><img style="height:50px" src="{{$cart->options->image}}" alt=""></td>
                                                    <td class="si-text">
                                                        <div class="product-selected">
                                                            <p>{{number_format($cart->price)}} x {{$cart->qty}}</p>
                                                            <h6>{{$cart->name}}</h6>
                                                        </div>
                                                    </td>
                                                    <td class="si-close">
                                                        <i onclick="window.location='./cart/delete/{{$cart->rowId}}'" class="ti-close"></i>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="select-total">
                                        <span>Tổng tiền:</span>
                                        <h5>{{ number_format((float)str_replace(',', '', Cart::total()), 0, '.', ',') }} VND</h5>
                                    </div>
                                    <div class="select-button">
                                        <a href="./cart" class="primary-btn view-card">Xem giỏ hàng</a>
                                        <a href="check-out.html" class="primary-btn checkout-btn">Thanh toán</a>
                                    </div>
                                </div>
                            </li>
                            <li class="cart-price">{{ number_format((float)str_replace(',', '', Cart::subtotal()), 0, '.', ',') }} VND</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-item">
            <div class="container">
                <div class="nav-depart">
                    <div class="depart-btn">
                        <i class="ti-menu"></i>
                        <span>Danh mục sản phẩm</span>
                        <ul class="depart-hover">
                            @foreach ($categories as $category)
                                <li><a href="{{ url('shop/' . $category->id) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <nav class="nav-menu mobile-menu">
                    <ul>
                        <li class="{{ (request()->segment(1)=='') ? 'active' :'' }}"><a href="./">Trang chủ</a></li>
                        <li class="{{ (request()->segment(1)=='shop') ? 'active' :'' }}"><a href="./shop">Cửa hàng</a></li>
                        <li class="{{ (request()->segment(1)=='contact') ? 'active' :'' }}"><a href="./contact">Liên hệ</a></li>
                        <li class="{{ (request()->segment(1)=='cart') ? 'active' :'' }}"><a href="./cart">Giỏ hàng</a></li>
                    </ul>
                </nav>
                <div class="mobile-menu-wrap"></div>
            </div>
        </div>
    </header>

    @yield('body')

    <!-- Footer -->
    <footer class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer-left">
                        <div class="footer-logo">
                            <a href="index.html">
                                <img src="front/img/logo.png" height="100" alt="">
                            </a>
                        </div>
                        <ul>
                            <li>Hà Nội</li>
                            <li>SDT: 0366125502</li>
                            <li>Email: hiep.nd200213@sis.hust.edu.vn</li>
                        </ul>
                        <div class="footer-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1">
                    <div class="footer-widget">
                        <h5>Thông tin cửa hàng</h5>
                        <ul>
                            <li><a href="">Về chúng tôi</a></li>
                            <li><a href="">Thủ tục thanh toán</a></li>
                            <li><a href="">Liên hệ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="newslatter-item">
                        <h5>Thông tin khuyến mại, giảm giá</h5>
                        <p>Nhập email để biết thêm về ưu đãi đặc biệt của chúng tôi</p>
                        <form action="#" class="subscribe-form">
                            <input type="text" placeholder="Nhập email">
                            <button type="button">Nhận thông tin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-reserved">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="payment-pic">
                            <img src="front/img/payment-method.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Js Plugins -->
    <script src="front/js/jquery-3.3.1.min.js"></script>
    <script src="front/js/bootstrap.min.js"></script>
    <script src="front/js/jquery-ui.min.js"></script>
    <script src="front/js/jquery.countdown.min.js"></script>
    <script src="front/js/jquery.nice-select.min.js"></script>
    <script src="front/js/jquery.zoom.min.js"></script>
    <script src="front/js/jquery.dd.min.js"></script>
    <script src="front/js/jquery.slicknav.js"></script>
    <script src="front/js/owl.carousel.min.js"></script>
    <script src="front/js/owlcarousel2-filter.min.js"></script>
    <script src="front/js/main.js"></script>
</body>

</html>
