@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $title ?? 'Jewelry Shop' }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Spectral:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    @stack('styles')
    <style>
        .footer {
            background: #ededed;
            padding: 30px 0 0 0;
            font-size: 15px;
            color: #222;

        }

        .footer #introduce-box {
            margin-bottom: 20px;
        }

        .footer #address-box img {
            max-width: 180px;
            margin-bottom: 15px;
        }

        .footer #address-list .tit-name {
            font-weight: bold;
            display: inline-block;
            width: 80px;
        }

        .footer #address-list .tit-contain {
            display: inline-block;
            margin-bottom: 5px;
        }

        .footer .introduce-title {
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
            font-size: 20px;
            letter-spacing: 0.5px;
        }

        .footer .introduce-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer .introduce-list li {
            margin-bottom: 5px;
        }

        .footer .introduce-list a {
            color: #222;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer .introduce-list a:hover {
            color: #bfa46b;
        }

        .footer #contact-box .introduce-title {
            margin-top: 0;
        }

        .footer .contact-form {
            margin-bottom: 15px;
        }

        .footer #mail-box {
            display: flex;
        }

        .footer #mail-box input[type="email"] {
            flex: 1;
            padding: 7px 12px;
            border: 1px solid #ccc;
            border-radius: 0;
            outline: none;
            font-size: 15px;
            background: #fff;
        }

        .footer #mail-box .btn {
            background: #bfa46b;
            color: #fff;
            border: none;
            border-radius: 0;
            padding: 7px 22px;
            font-weight: bold;
            transition: background 0.2s;
            font-size: 16px;
        }

        .footer #mail-box .btn:hover {
            background: #a08a54;
        }

        .footer .social-link {
            margin-top: 10px;
        }

        .footer .social-link a {
            display: inline-block;
            width: 38px;
            height: 38px;
            line-height: 38px;
            background: #fff;
            color: #444;
            border-radius: 3px;
            text-align: center;
            margin-right: 6px;
            font-size: 22px;
            border: 1px solid #ccc;
            transition: background 0.2s, color 0.2s;
        }

        .footer .social-link a:hover {
            background: #bfa46b;
            color: #fff;
            border-color: #bfa46b;
        }

        .footer #trademark-box {
            border-top: 1px solid #ddd;
            margin-top: 25px;
            padding-top: 18px;
            padding-bottom: 10px;
        }

        .footer #trademark-list {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer #trademark-list li {
            margin-right: 18px;
            margin-bottom: 8px;
        }

        .footer #payment-methods {
            font-weight: bold;
            text-transform: uppercase;
            margin-right: 18px;
            color: #444;
            font-size: 17px;
        }

        .footer #trademark-list img {
            height: 36px;
            width: auto;
            vertical-align: middle;
            border-radius: 2px;
            background: #fff;
            border: 1px solid #eee;
            padding: 2px 8px;
        }

        .footer .cpr {
            font-size: 15px;
            color: #222;
            margin: 0;
            padding: 13px 0 5px 0;
            border-top: 1px solid #ddd;
        }

        .footer .cpr a {
            color: #0f9ed8;
            text-decoration: none;
        }

        .footer .cpr a:hover {
            text-decoration: underline;
        }

        @media (max-width: 991px) {
            .footer #introduce-box>div {
                margin-bottom: 20px;
            }

            .footer #trademark-list {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
    @stack('head')
</head>

<body ng-app="appMain" class="home option2">
    <div id="fb-root"></div>
    <div class="wrapper page-home">

        <div id="header" class="header" style="background: #fff; border-bottom: 1px solid #eee;">
            <section class="top-link clearfix" style="background: #f8f9fa; border-bottom: 1px solid #eee; padding: 8px 0;">
                <div class="container">
                    <div class="row" style="display: flex; align-items: center;">
                        <div class="col-md-6 col-xs-12" style="display: flex; align-items: center;">
                            <span style="color: #f4436c; font-size: 18px; font-weight: 600; display: flex; align-items: center;">
                                <i class="fa fa-phone" style="color: #f4436c; margin-right: 6px; font-size: 18px;"></i>
                                Hotline: 0908 77 00 95
                            </span>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <ul class="nav navbar-nav navbar-right hidden-xs" style="font-size: 15px;">
                                <li><a href="kiem-tra-don-hang.html" style="color: #888;"><i class="fa fa-pencil-square-o"></i> Kiểm tra đơn hàng</a></li>
                                <li><a href="gio-hang.html" style="color: #888;"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
                                <li><a href="dang-nhap.html" style="color: #888;"><i class="fa fa-sign-in"></i> Đăng nhập</a></li>
                                <li><a href="dang-ky.html" style="color: #888;"><i class="fa fa-key"></i> Đăng ký</a></li>
                            </ul>
                            <!-- Mobile menu -->
                            <div class="visible-xs" style="display: flex; justify-content: flex-end; gap: 8px;">
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="userMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 6px 12px;">
                                        <i class="fa fa-user"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="userMenu">
                                        <li><a href="dang-ky.html"><i class="fa fa-sign-in"></i> Đăng ký</a></li>
                                        <li><a href="dang-nhap.html"><i class="fa fa-key"></i> Đăng nhập</a></li>
                                    </ul>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="quickMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 6px 12px;">
                                        <i class="fa fa-list"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="quickMenu">
                                        <li><a href="kiem-tra-don-hang.html"><i class="fa fa-pencil-square-o"></i> Kiểm tra đơn hàng</a></li>
                                        <li><a href="gio-hang.html"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Main header -->
            <div class="container" style="padding: 18px 0 12px 0;">
                <div class="row" style="align-items: center; display: flex;">
                    <!-- Logo -->
                    <div class="col-xs-12 col-sm-3 text-center" style="display: flex; align-items: center; justify-content: center;">
                        <a href="index.htm" class="logo" title="Fashion Store">
                            <img src="{{ asset('Uploads/shop2198/images/logo2.png') }}" alt="Fashion Store" style="max-height: 70px;">
                        </a>
                    </div>
                    <!-- Search box -->
                    <div class="col-xs-12 col-sm-6" style="display: flex; align-items: center; justify-content: center;">
                        <form class="search form-inline" style="width: 100%; display: flex;">
                            <input type="text" name="search" class="form-control" style="flex:1; height: 40px; border-radius: 0; border: 1px solid #ccc;" placeholder="Nhập từ khóa tìm kiếm...">
                            <button class="btn" style="background: #9c8656; color: #fff; border-radius: 0; height: 40px; min-width: 110px; font-weight: bold; margin-left: -1px;">Tìm kiếm</button>
                        </form>
                    </div>
                    <!-- Cart & User -->
                    <div class="col-xs-12 col-sm-3 text-right" style="display: flex; align-items: center; justify-content: flex-end; gap: 18px;">
                        <!-- Sửa phần giỏ hàng -->
                        <div style="position: relative;">
                            <a href="gio-hang.html" style="
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #bfa46b;
        border-radius: 50%;
        width: 54px;
        height: 54px;
        color: #bfa46b;
        font-size: 28px;
        position: relative;
        background: #fff;
        ">
                                <i class="fa fa-shopping-cart" style="margin:0; color: #bfa46b;"></i>
                                <span style="
            position: absolute;
            top: -8px;
            right: -8px;
            background: #009688;
            color: #fff;
            border-radius: 50px;
            font-size: 18px;
            min-width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border: 3px solid #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.07);
            ">
                                    0
                                </span>
                            </a>
                        </div>
                        <div>
                            <a href="dang-nhap.html" style="display: inline-block; border: 2px solid #bfa46b; border-radius: 50%; width: 44px; height: 44px; text-align: center; line-height: 40px; color: #9c8656; font-size: 22px;">
                                <i class="fa fa-user"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Menu -->
            <div style="background: #9c8656;">
                <div class="container">
                    <ul class="nav" style="margin: 0; padding: 0; display: flex; list-style: none;">
                        <li style="background: #5a4321; color: #fff; font-weight: bold;">
                            <a href="#" style="display: block; padding: 14px 28px; color: #fff; text-transform: uppercase; font-weight: bold; letter-spacing: 1px;">
                                <i class="fa fa-bars"></i> DANH MỤC SẢN PHẨM
                            </a>
                        </li>
                        <li><a href="trang-chu.html" style="display: block; padding: 14px 28px; color: #fff;">Trang chủ</a></li>
                        <li><a href="gioi-thieu.html" style="display: block; padding: 14px 28px; color: #fff;">Giới thiệu</a></li>
                        <li><a href="san-pham.html" style="display: block; padding: 14px 28px; color: #fff;">Sản phẩm</a></li>
                        <li><a href="tin-tuc.html" style="display: block; padding: 14px 28px; color: #fff;">Tin tức</a></li>
                        <li><a href="lien-he.html" style="display: block; padding: 14px 28px; color: #fff;">Liên hệ</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <main>
            @yield('content')
        </main>
        <!-- Footer -->
        <div class="footer">
            <footer id="footer">
                <div class="container">
                    <!-- introduce-box -->
                    <div id="introduce-box" class="row">
                        <div class="col-md-3">
                            <div id="address-box">
                                <a href="index.htm"><img src="Uploads\shop2198\images\logo2.png" alt="logo"></a>
                                <div id="address-list">
                                    <div class="tit-name">Địa chỉ:</div>
                                    <div class="tit-contain">1005 Quang Trung, P.14, Q.G&#242; Vấp, Tp.HCM</div>
                                    <div class="tit-name">Điện thoại:</div>
                                    <div class="tit-contain">(08) 66 85 85 38</div>
                                    <div class="tit-name">Email:</div>
                                    <div class="tit-contain">run02@runtime.vn</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="introduce-title">Về ch&#250;ng t&#244;i</div>
                                    <ul class="introduce-list">
                                        <li class="item">
                                            <a href="gioi-thieu.html">
                                                Giới thiệu
                                            </a>
                                        </li>
                                        <li class="item">
                                            <a href="content\giao-hang-doi-tra.html">
                                                Giao h&#224;ng - Đổi trả
                                            </a>
                                        </li>
                                        <li class="item">
                                            <a href="content\chinh-sach-bao-mat.html">
                                                Ch&#237;nh s&#225;ch bảo mật
                                            </a>
                                        </li>
                                        <li class="item">
                                            <a href="lien-he.html">
                                                Li&#234;n hệ
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <div class="introduce-title">Trợ gi&#250;p</div>
                                    <ul class="introduce-list">
                                        <li class="item">
                                            <a href="content\huong-dan-mua-hang.html">
                                                Hướng dẫn mua h&#224;ng
                                            </a>
                                        </li>
                                        <li class="item">
                                            <a href="content\huong-dan-thanh-toan.html">
                                                Hướng dẫn thanh to&#225;n
                                            </a>
                                        </li>
                                        <li class="item">
                                            <a href="content\tai-khoan-giao-dich.html">
                                                T&#224;i khoản giao dịch
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div id="contact-box" ng-controller="moduleController" ng-init="initController()">
                                <div class="introduce-title">Đăng ký nhận tin</div>
                                <form ng-submit="registerNewsletter()" class='contact-form'>
                                    <div class="input-group" id="mail-box">
                                        <input ng-model="newsletter.Email" type="email" placeholder="Đăng ký email" required="required">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default">Gửi</button>
                                        </span>
                                    </div><!-- /input-group -->
                                </form>
                                <div class="introduce-title">Liên kết</div>
                                <div class="social-link">
                                    <a><i class="fa fa-facebook"></i></a>
                                    <a><i class="fa fa-youtube"></i></a>
                                    <a><i class="fa fa-twitter"></i></a>
                                    <a><i class="fa fa-google-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div><!-- /#introduce-box -->
                    <!-- #trademark-box -->
                    <div id="trademark-box" class="row">
                        <div class="col-sm-12">
                            <ul id="trademark-list">
                                <li id="payment-methods">Phương thức thanh toán</li>
                                <li><a href="javascript:;"><img src="{{ asset('img/trademark_1.jpg') }}?v=42" alt="Phương thức thanh toán 1"></a></li>
                                <li><a href="javascript:;"><img src="{{ asset('img/trademark_2.jpg') }}?v=42" alt="Phương thức thanh toán 2"></a></li>
                                <li><a href="javascript:;"><img src="{{ asset('img/trademark_3.jpg') }}?v=42" alt="Phương thức thanh toán 3"></a></li>
                                <li><a href="javascript:;"><img src="{{ asset('img/trademark_4.jpg') }}?v=42" alt="Phương thức thanh toán 4"></a></li>
                                <li><a href="javascript:;"><img src="{{ asset('img/trademark_5.jpg') }}?v=42" alt="Phương thức thanh toán 5"></a></li>
                                <li><a href="javascript:;"><img src="{{ asset('img/trademark_6.jpg') }}?v=42" alt="Phương thức thanh toán 6"></a></li>
                                <li><a href="javascript:;"><img src="{{ asset('img/trademark_7.jpg') }}?v=42" alt="Phương thức thanh toán 7"></a></li>
                                <li><a href="javascript:;"><img src="{{ asset('img/trademark_8.jpg') }}?v=42" alt="Phương thức thanh toán 8"></a></li>
                                <li><a href="javascript:;"><img src="{{ asset('img/trademark_9.jpg') }}?v=42" alt="Phương thức thanh toán 9"></a></li>
                                <li><a href="javascript:;"><img src="{{ asset('img/trademark_10.jpg') }}?v=42" alt="Phương thức thanh toán 10"></a></li>
                            </ul>
                        </div>
                    </div> <!-- /#trademark-box -->
                    <p class="cpr text-center">
                        &copy; Bản quyền thuộc về <a href="http://runtime.vn/" style="color: #0f9ed8" target="_blank">RUNTIME STORE</a> | <a target="_blank" href="https://www.runtime.vn">Powered by RUNTIME.VN</a>.
                    </p>
                </div>
            </footer>
        </div>

    </div>


    <div style="display: none;" id="loading-mask">
        <div id="loading_mask_loader" class="loader">
            <img alt="Loading..." src="Images\ajax-loader-main.gif">
            <div>
                Please wait...
            </div>
        </div>
    </div>

    <a href="#" class="scroll_top" title="Scroll to Top" style="display: none;">Scroll</a>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="module" src="{{ asset('js/index.js') }}"></script>
    @stack('scripts')
    <script type="text/javascript">
        $(function() {
            $(".header-content").css({
                "background": ''
            });
            $("html").addClass('');
        });
        document.querySelector('.scroll_top').onclick = function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        };
    </script>
</body>

</html>