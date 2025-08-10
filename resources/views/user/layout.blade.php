@if(Auth::check())
<script>
    function handleLogoutAjax() {
        fetch("{{ route('api.auth.logout') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                // Reload page or redirect to home/login
                window.location.reload();
            })
            .catch(() => {
                alert('Đăng xuất thất bại!');
            });
    }
    document.addEventListener('DOMContentLoaded', function() {
        var logoutBtn = document.getElementById('logout-desktop-btn');
        if (logoutBtn) logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            handleLogoutAjax();
        });
        var logoutMobileBtn = document.getElementById('logout-mobile-btn');
        if (logoutMobileBtn) logoutMobileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            handleLogoutAjax();
        });
    });
</script>
@endif
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
    <title>@yield('title', 'Trang Chủ') - Jewelry Shop</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    @stack('styles')
    <style>
        :root {
            --galaxy-blue: #1a237e;
            --galaxy-blue-light: #3f51b5;
            --galaxy-blue-dark: #0d1556;
            --galaxy-blue-accent: #2196f3;
            --gold-accent: #ffd700;
            --gold-hover: #ffb300;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --white: #ffffff;
            --light-gray: #f8f9fa;
            --border-light: #e9ecef;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--white);
            color: var(--text-dark);
            line-height: 1.6;
        }

        .playfair {
            font-family: 'Playfair Display', serif;
        }

        /* Header Styles */
        .header {
            background: var(--white);
            box-shadow: 0 2px 20px rgba(26, 35, 126, 0.1);
            position: relative;
        }

        .top-link {
            background: linear-gradient(135deg, var(--galaxy-blue) 0%, var(--galaxy-blue-light) 100%);
            border: none;
            padding: 12px 0;
        }

        .top-link .hotline {
            color: var(--white);
            font-size: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .top-link .hotline i {
            background: var(--gold-accent);
            color: var(--white);
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-size: 14px;
        }

        .top-link .navbar-nav>li>a {
            color: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
            padding: 8px 12px;
            border-radius: 6px;
        }

        .top-link .navbar-nav>li>a:hover {
            color: var(--white);
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
        }

        /* Main Header */
        .main-header {
            padding: 20px 0;
            background: var(--white);
        }

        .logo img {
            max-height: 80px;
            transition: transform 0.3s ease;
        }

        .logo:hover img {
            transform: scale(1.05);
        }

        /* Search Box */
        .search-box {
            position: relative;
            max-width: 500px;
            margin: 0 auto;
        }

        .search-box input {
            width: 100%;
            height: 50px;
            border: 2px solid var(--border-light);
            border-radius: 25px;
            padding: 0 60px 0 25px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: var(--light-gray);
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--galaxy-blue-accent);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
        }

        .search-box button {
            position: absolute;
            right: 2px;
            top: 2px;
            height: 46px;
            width: 46px;
            border: none;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--galaxy-blue) 0%, var(--galaxy-blue-light) 100%);
            color: var(--white);
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-box button:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(26, 35, 126, 0.3);
        }

        /* Cart & User Actions */
        .header-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 20px;
        }

        .cart-btn {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            border: 2px solid var(--galaxy-blue);
            border-radius: 50%;
            color: var(--galaxy-blue);
            font-size: 24px;
            background: var(--white);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .cart-btn:hover {
            background: var(--galaxy-blue);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(26, 35, 126, 0.3);
            text-decoration: none;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: linear-gradient(135deg, var(--gold-accent) 0%, var(--gold-hover) 100%);
            color: var(--white);
            border-radius: 50%;
            font-size: 14px;
            min-width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            border: 3px solid var(--white);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-name {
            font-weight: 600;
            color: var(--galaxy-blue);
            font-size: 15px;
        }

        .user-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border: 2px solid var(--galaxy-blue);
            border-radius: 50%;
            color: var(--galaxy-blue);
            font-size: 20px;
            background: var(--white);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .user-btn:hover {
            background: var(--galaxy-blue);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 35, 126, 0.3);
            text-decoration: none;
        }

        /* Avatar placeholder initial */
        .user-avatar-btn .avatar-initial {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: rgba(26, 35, 126, 0.08);
            color: var(--galaxy-blue);
            font-weight: 700;
        }

        .logout-btn {
            border-color: #dc3545;
            color: #dc3545;
        }

        .logout-btn:hover {
            background: #dc3545;
            color: var(--white);
        }

        /* Navigation Menu */
        .main-nav {
            background: linear-gradient(135deg, var(--galaxy-blue-dark) 0%, var(--galaxy-blue) 50%, var(--galaxy-blue-light) 100%);
            position: relative;
            overflow: visible;
            /* allow dropdowns to overflow */
            z-index: 100;
            /* ensure dropdown is above */
        }

        .main-nav::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="stars" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="2" cy="2" r="0.5" fill="rgba(255,255,255,0.3)"/><circle cx="12" cy="8" r="0.3" fill="rgba(255,255,255,0.2)"/><circle cx="18" cy="15" r="0.4" fill="rgba(255,255,255,0.25)"/></pattern></defs><rect width="100" height="100" fill="url(%23stars)"/></svg>');
            opacity: 0.1;
        }

        .nav-list {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            position: relative;
            z-index: 1;
        }

        .nav-category {
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            position: relative;
            /* anchor dropdown */
        }

        .nav-category>a {
            display: block;
            padding: 16px 30px;
            color: var(--white);
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 1.2px;
            font-size: 14px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        /* Dropdown menu styling under Categories */
        .nav-category .dropdown-menu {
            min-width: 220px;
            padding: 8px 0;
            border-radius: 10px;
            border: 1px solid rgba(26, 35, 126, 0.15);
            box-shadow: 0 10px 30px rgba(26, 35, 126, 0.2);
            margin-top: 0;
        }

        .nav-category .dropdown-menu>li>a {
            padding: 10px 16px;
            color: #1a237e;
            font-weight: 600;
        }

        .nav-category .dropdown-menu>li>a:hover {
            background: rgba(26, 35, 126, 0.08);
            color: #1a237e;
        }

        .nav-item a {
            display: block;
            padding: 16px 25px;
            color: rgba(255, 255, 255, 0.95);
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            text-decoration: none;
        }

        .nav-item a::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: var(--gold-accent);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-item a:hover {
            color: var(--white);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .nav-item a:hover::before {
            width: 80%;
        }

        /* Mobile Styles */
        .mobile-menu {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .dropdown-toggle {
            background: rgba(26, 35, 126, 0.1);
            border: 1px solid rgba(26, 35, 126, 0.2);
            color: var(--galaxy-blue);
            border-radius: 8px;
            padding: 8px 12px;
            transition: all 0.3s ease;
        }

        .dropdown-toggle:hover {
            background: var(--galaxy-blue);
            color: var(--white);
        }

        /* Footer Styles */
        .footer {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 50px 0 0 0;
            font-size: 15px;
            color: var(--text-dark);
            margin-top: 50px;
            position: relative;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--galaxy-blue) 0%, var(--galaxy-blue-light) 50%, var(--galaxy-blue-accent) 100%);
        }

        .footer .introduce-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-size: 18px;
            letter-spacing: 0.5px;
            color: var(--galaxy-blue);
            position: relative;
            padding-bottom: 10px;
        }

        .footer .introduce-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--gold-accent);
        }

        .footer .introduce-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer .introduce-list li {
            margin-bottom: 8px;
        }

        .footer .introduce-list a {
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 5px 0;
            display: inline-block;
        }

        .footer .introduce-list a:hover {
            color: var(--galaxy-blue);
            transform: translateX(5px);
        }

        .footer #address-box img {
            max-width: 200px;
            margin-bottom: 20px;
        }

        .footer #address-list .tit-name {
            font-weight: 700;
            display: inline-block;
            width: 90px;
            color: var(--galaxy-blue);
        }

        .footer #address-list .tit-contain {
            display: inline-block;
            margin-bottom: 8px;
            color: var(--text-light);
        }

        /* Newsletter Form */
        .newsletter-form {
            margin-bottom: 25px;
        }

        .newsletter-form input {
            flex: 1;
            padding: 12px 16px;
            border: 2px solid var(--border-light);
            border-radius: 8px 0 0 8px;
            outline: none;
            font-size: 15px;
            background: var(--white);
            transition: border-color 0.3s ease;
        }

        .newsletter-form input:focus {
            border-color: var(--galaxy-blue-accent);
        }

        .newsletter-form .btn {
            background: linear-gradient(135deg, var(--galaxy-blue) 0%, var(--galaxy-blue-light) 100%);
            color: var(--white);
            border: none;
            border-radius: 0 8px 8px 0;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        .newsletter-form .btn:hover {
            background: linear-gradient(135deg, var(--galaxy-blue-dark) 0%, var(--galaxy-blue) 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 35, 126, 0.3);
        }

        /* Social Links */
        .social-link {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .social-link a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: var(--white);
            color: var(--galaxy-blue);
            border-radius: 12px;
            font-size: 20px;
            border: 2px solid var(--border-light);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-link a:hover {
            background: var(--galaxy-blue);
            color: var(--white);
            border-color: var(--galaxy-blue);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(26, 35, 126, 0.3);
        }

        /* Trademark Section */
        .footer #trademark-box {
            border-top: 2px solid var(--border-light);
            margin-top: 40px;
            padding-top: 30px;
            padding-bottom: 20px;
        }

        .footer #trademark-list {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 15px;
        }

        .footer #payment-methods {
            font-weight: 700;
            text-transform: uppercase;
            color: var(--galaxy-blue);
            font-size: 16px;
            margin-right: 20px;
        }

        .footer #trademark-list img {
            height: 40px;
            width: auto;
            border-radius: 8px;
            background: var(--white);
            border: 2px solid var(--border-light);
            padding: 5px 10px;
            transition: all 0.3s ease;
        }

        .footer #trademark-list img:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-color: var(--galaxy-blue-accent);
        }

        /* Copyright */
        .footer .cpr {
            font-size: 14px;
            color: var(--text-light);
            margin: 0;
            padding: 20px 0;
            border-top: 2px solid var(--border-light);
            background: rgba(26, 35, 126, 0.02);
        }

        .footer .cpr a {
            color: var(--galaxy-blue);
            text-decoration: none;
            font-weight: 600;
        }

        .footer .cpr a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 991px) {
            .header-actions {
                justify-content: center;
                margin-top: 15px;
            }

            .search-box {
                margin: 15px 0;
            }

            .nav-list {
                flex-direction: column;
            }

            .footer #introduce-box>div {
                margin-bottom: 30px;
            }

            .footer #trademark-list {
                flex-direction: column;
                align-items: flex-start;
            }

            .main-nav {
                display: none;
            }
        }

        @media (max-width: 767px) {
            .main-header {
                padding: 15px 0;
            }

            .logo img {
                max-height: 60px;
            }

            .cart-btn,
            .user-btn {
                width: 45px;
                height: 45px;
                font-size: 18px;
            }

            .cart-count {
                min-width: 24px;
                height: 24px;
                font-size: 12px;
            }
        }

        /* Loading Animation */
        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .loading-shimmer {
            position: relative;
            overflow: hidden;
        }

        .loading-shimmer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: shimmer 1.5s infinite;
        }

        /* Scroll to top button */
        .scroll_top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--galaxy-blue) 0%, var(--galaxy-blue-light) 100%);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            text-decoration: none;
            box-shadow: 0 5px 15px rgba(26, 35, 126, 0.3);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .scroll_top:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(26, 35, 126, 0.4);
            color: var(--white);
            text-decoration: none;
        }
    </style>
    @stack('head')
</head>

<body ng-app="appMain" class="home option2">
    <div id="fb-root"></div>
    <div class="wrapper page-home">

        <div id="header" class="header">
            <section class="top-link clearfix">
                <div class="container">
                    <div class="row" style="display: flex; align-items: center;">
                        <div class="col-md-6 col-xs-12" style="display: flex; align-items: center;">
                            <span class="hotline">
                                <i class="fa fa-phone"></i>
                                Hotline: 0908 77 00 95
                            </span>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <ul class="nav navbar-nav navbar-right hidden-xs" style="font-size: 15px;">
                                <li style="position:relative;">
                                    <div style="position:relative;display:inline-block;">
                                        <button type="button" class="btn btn-link" id="desktop-notification-btn" style="font-size:18px;padding:0 8px;position:relative;color:#e9ecef">
                                            <i class="fa fa-bell"></i>
                                            <span id="desktop-notification-badge" style="position:absolute;top:-2px;right:-2px;min-width:16px;height:16px;background:#ffb300;color:#fff;border-radius:8px;font-size:11px;line-height:16px;display:none;padding:0 4px;">0</span>
                                        </button>
                                        <div id="notificationDropdownNew" class="hidden" style="position:absolute;left:-110px;transform:translateX(-50%);top:36px;min-width:340px;max-width:400px;background:linear-gradient(135deg,#1a237e 0%,#3f51b5 100%);color:#fff;border-radius:14px;box-shadow:0 8px 32px rgba(26,35,126,0.18);z-index:1001;padding:24px 24px 18px 24px;">
                                            <div style="position:absolute;top:-12px;left:87%;transform:translateX(-50%);width:0;height:0;border-left:10px solid transparent;border-right:10px solid transparent;border-bottom:12px solid #1a237e;filter:drop-shadow(0 2px 2px rgba(26,35,126,0.10));"></div>
                                            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;">
                                                <h2 style="font-weight:800;font-size:1.15rem;line-height:1.2;margin:0;max-width:80%;">Thông báo</h2>
                                                <button id="closeNotificationDropdownNew" aria-label="Đóng" style="background:none;border:none;color:#fff;font-size:20px;cursor:pointer;line-height:1;">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <ul style="padding-left:0;list-style:none;margin-bottom:16px;font-size:1rem;font-weight:500;line-height:1.6;">
                                                <!-- Danh sách thông báo động giả lập -->
                                                <li style="display:flex;align-items:flex-start;margin-bottom:14px;gap:10px;">
                                                    <i class="fas fa-bolt" style="color:#ffd700;font-size:18px;margin-top:2px;"></i>
                                                    <div>
                                                        <div style="font-weight:600;">Flash Sale cuối tuần!</div>
                                                        <div style="font-size:0.97em;opacity:0.85;">Giảm giá tới 30% cho bộ sưu tập mới.</div>
                                                        <div style="font-size:0.85em;color:#ffe082;">2 phút trước</div>
                                                    </div>
                                                </li>
                                                <li style="display:flex;align-items:flex-start;margin-bottom:14px;gap:10px;">
                                                    <i class="fas fa-gift" style="color:#ffd700;font-size:18px;margin-top:2px;"></i>
                                                    <div>
                                                        <div style="font-weight:600;">Nhận quà tặng miễn phí</div>
                                                        <div style="font-size:0.97em;opacity:0.85;">Tặng hộp đựng trang sức cho đơn hàng trên 2 triệu.</div>
                                                        <div style="font-size:0.85em;color:#ffe082;">10 phút trước</div>
                                                    </div>
                                                </li>
                                                <li style="display:flex;align-items:flex-start;margin-bottom:14px;gap:10px;">
                                                    <i class="fas fa-truck" style="color:#ffd700;font-size:18px;margin-top:2px;"></i>
                                                    <div>
                                                        <div style="font-weight:600;">Đơn hàng #12345 đã giao thành công</div>
                                                        <div style="font-size:0.97em;opacity:0.85;">Cảm ơn bạn đã mua sắm tại TVT Jewelry.</div>
                                                        <div style="font-size:0.85em;color:#ffe082;">1 giờ trước</div>
                                                    </div>
                                                </li>
                                                <li style="display:flex;align-items:flex-start;margin-bottom:14px;gap:10px;">
                                                    <i class="fas fa-star" style="color:#ffd700;font-size:18px;margin-top:2px;"></i>
                                                    <div>
                                                        <div style="font-weight:600;">Đánh giá sản phẩm</div>
                                                        <div style="font-size:0.97em;opacity:0.85;">Hãy để lại đánh giá cho sản phẩm bạn vừa nhận.</div>
                                                        <div style="font-size:0.85em;color:#ffe082;">2 giờ trước</div>
                                                    </div>
                                                </li>
                                                <li style="display:flex;align-items:flex-start;gap:10px;">
                                                    <i class="fas fa-bullhorn" style="color:#ffd700;font-size:18px;margin-top:2px;"></i>
                                                    <div>
                                                        <div style="font-weight:600;">Chính sách đổi trả mới</div>
                                                        <div style="font-size:0.97em;opacity:0.85;">Đổi trả dễ dàng trong 7 ngày cho mọi đơn hàng.</div>
                                                        <div style="font-size:0.85em;color:#ffe082;">Hôm qua</div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <p style="font-style:italic;font-size:0.95rem;line-height:1.5;max-width:95%;opacity:0.9;margin:0;">
                                                Hãy khám phá bộ sưu tập trang sức mới nhất của TVT – tôn vinh vẻ đẹp và đẳng cấp của bạn!
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                @guest
                                <li><a href="{{ route('login') }}"><i class="fa fa-sign-in"></i> Đăng nhập</a></li>
                                <li><a href="{{ route('auth.registerView') }}"><i class="fa fa-user-plus"></i> Đăng ký</a></li>
                                @endguest
                            </ul>
                            <!-- Mobile menu -->
                            <div class="visible-xs mobile-menu">
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="userMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-user"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="userMenu">
                                        @if(Auth::check())
                                        <li class="px-3 py-2 text-[#1a237e] font-semibold">Xin chào, {{ Auth::user()->username ?? Auth::user()->name ?? Auth::user()->email }}</li>
                                        <li><a href="{{ route('profile.show', Auth::id()) }}"><i class="fa fa-user-circle"></i> Trang cá nhân</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li>
                                            <a href="#" id="logout-mobile-btn" class="text-red-600"><i class="fa fa-sign-out"></i> Đăng xuất</a>
                                        </li>
                                        @else
                                        <li><a href="{{ route('auth.registerView') }}"><i class="fa fa-user-plus"></i> Đăng ký</a></li>
                                        <li><a href="{{ route('login') }}"><i class="fa fa-sign-in"></i> Đăng nhập</a></li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="quickMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="quickMenu">
                                        <li><a href="kiem-tra-don-hang.html"><i class="fa fa-search"></i> Kiểm tra đơn hàng</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main header -->
            <div class="container main-header">
                <div class="row" style="align-items: center; display: flex;">
                    <!-- Logo -->
                    <div class="col-xs-12 col-sm-3 text-center">
                        <a href="index.htm" class="logo" title="Jewelry Store">
                            <img src="http://localhost:8000/img/logo_2.png" alt="Jewelry Store">
                        </a>
                    </div>
                    <!-- Search box -->
                    <div class="col-xs-12 col-sm-6">
                        <div class="search-box">
                            <form class="search form-inline" method="GET" action="{{ route('products.all') }}" style="position: relative;">
                                <input type="text" name="search" placeholder="Tìm kiếm trang sức, nhẫn, dây chuyền..." value="{{ request('search') }}">
                                <button type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- Cart & User -->
                    <div class="col-xs-12 col-sm-3">
                        <div class="header-actions">
                            <!-- Cart -->
                            <a href="{{ route('cart.show') }}" class="cart-btn">
                                <i class="fa fa-shopping-bag"></i>
                                <span class="cart-count">0</span>
                            </a>

                            <!-- User -->
                            <div class="user-info">
                                @if(Auth::check())
                                <div class="dropdown user-dropdown">
                                    <a href="#" class="user-btn user-avatar-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Tài khoản">
                                        @php($avatar = Auth::user()->avatar)
                                        @if($avatar)
                                        <img src="{{ asset('storage/avatars/' . $avatar) }}" alt="avatar" style="width:100%;height:100%;object-fit:cover;border-radius:50%">
                                        @else
                                        <span class="avatar-initial">{{ strtoupper(substr(Auth::user()->username ?? Auth::user()->fullname ?? Auth::user()->email,0,1)) }}</span>
                                        @endif
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="{{ route('profile.show', Auth::id()) }}"><i class="fa fa-user-circle"></i> Trang cá nhân</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="#" id="logout-desktop-btn"><i class="fa fa-sign-out"></i> Đăng xuất</a></li>
                                    </ul>
                                </div>
                                @else
                                <a href="{{ route('login') }}" class="user-btn" title="Đăng nhập">
                                    <i class="fa fa-user"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="main-nav">
                <div class="container">
                    <ul class="nav-list">
                        <li class="nav-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li class="nav-item"><a href="{{ route('products.all') }}">Sản phẩm</a></li>
                        <li class="nav-category dropdown">
                            <a href="{{ route('products.all') }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-diamond"></i> Danh mục sản phẩm <span class="caret"></span>
                            </a>
                            @if(isset($navCategories) && $navCategories->count())
                            <ul class="dropdown-menu">
                                @foreach($navCategories as $category)
                                <li>
                                    <a href="{{ route('products.all', ['category' => $category->id]) }}">{{ $category->name }}</a>
                                </li>
                                @endforeach
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ route('products.all') }}">Tất cả sản phẩm</a></li>
                            </ul>
                            @endif
                        </li>
                        <li class="nav-item"><a href="{{ route('about') }}">Giới thiệu</a></li>

                        <li class="nav-item">
                            <a href="{{ route('news.index') }}">Tin tức</a>
                        </li>


                        <li class="nav-item"><a href="{{ route('contact.show') }}">Liên hệ</a></li>

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
                                <a href="index.htm"><img src="img/logo_2.png" alt="logo"></a>
                                <div id="address-list">
                                    <div class="tit-name">Địa chỉ:</div>
                                    <div class="tit-contain">1005 Quang Trung, P.14, Q.Gò Vấp, Tp.HCM</div>
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
                                    <div class="introduce-title">Về chúng tôi</div>
                                    <ul class="introduce-list">
                                        <li class="item">
                                            <a href="gioi-thieu.html">
                                                <i class="fa fa-angle-right" style="margin-right: 8px; color: var(--galaxy-blue-accent);"></i>
                                                Giới thiệu
                                            </a>
                                        </li>
                                        <li class="item">
                                            <a href="content\giao-hang-doi-tra.html">
                                                <i class="fa fa-angle-right" style="margin-right: 8px; color: var(--galaxy-blue-accent);"></i>
                                                Giao hàng - Đổi trả
                                            </a>
                                        </li>
                                        <li class="item">
                                            <a href="content\chinh-sach-bao-mat.html">
                                                <i class="fa fa-angle-right" style="margin-right: 8px; color: var(--galaxy-blue-accent);"></i>
                                                Chính sách bảo mật
                                            </a>
                                        </li>
                                        <li class="item">
                                            <a href="lien-he.html">
                                                <i class="fa fa-angle-right" style="margin-right: 8px; color: var(--galaxy-blue-accent);"></i>
                                                Liên hệ
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <div class="introduce-title">Trợ giúp</div>
                                    <ul class="introduce-list">
                                        <li class="item">
                                            <a href="content\huong-dan-mua-hang.html">
                                                <i class="fa fa-angle-right" style="margin-right: 8px; color: var(--galaxy-blue-accent);"></i>
                                                Hướng dẫn mua hàng
                                            </a>
                                        </li>
                                        <li class="item">
                                            <a href="content\huong-dan-thanh-toan.html">
                                                <i class="fa fa-angle-right" style="margin-right: 8px; color: var(--galaxy-blue-accent);"></i>
                                                Hướng dẫn thanh toán
                                            </a>
                                        </li>
                                        <li class="item">
                                            <a href="content\tai-khoan-giao-dich.html">
                                                <i class="fa fa-angle-right" style="margin-right: 8px; color: var(--galaxy-blue-accent);"></i>
                                                Tài khoản giao dịch
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <div class="introduce-title">Dịch vụ</div>
                                    <ul class="introduce-list">
                                        <li class="item">
                                            <a href="#">
                                                <i class="fa fa-angle-right" style="margin-right: 8px; color: var(--galaxy-blue-accent);"></i>
                                                Thiết kế theo yêu cầu
                                            </a>
                                        </li>
                                        <li class="item">
                                            <a href="#">
                                                <i class="fa fa-angle-right" style="margin-right: 8px; color: var(--galaxy-blue-accent);"></i>
                                                Bảo hành trang sức
                                            </a>
                                        </li>
                                        <li class="item">
                                            <a href="#">
                                                <i class="fa fa-angle-right" style="margin-right: 8px; color: var(--galaxy-blue-accent);"></i>
                                                Vệ sinh trang sức
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div id="contact-box" ng-controller="moduleController" ng-init="initController()">
                                <div class="introduce-title">Đăng ký nhận tin</div>
                                <p style="color: var(--text-light); margin-bottom: 15px; font-size: 14px;">
                                    Đăng ký để nhận thông tin về các sản phẩm mới và ưu đãi đặc biệt
                                </p>
                                <form ng-submit="registerNewsletter()" class='newsletter-form'>
                                    <div class="input-group" id="mail-box" style="display: flex;">
                                        <input ng-model="newsletter.Email" type="email" placeholder="Email của bạn" required="required">
                                        <button type="submit" class="btn">
                                            <i class="fa fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </form>
                                <div class="introduce-title">Kết nối với chúng tôi</div>
                                <div class="social-link">
                                    <a href="#" title="Facebook">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                    <a href="#" title="Instagram">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                    <a href="#" title="Youtube">
                                        <i class="fa-brands fa-youtube"></i>
                                    </a>
                                    <a href="#" title="Zalo">
                                        <i class="fa-solid fa-phone"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div><!-- /#introduce-box -->

                    <!-- #trademark-box -->
                    <div id="trademark-box" class="row">
                        <div class="col-sm-12">
                            <ul id="trademark-list">
                                <li id="payment-methods">Phương thức thanh toán</li>
                                <li><a href="javascript:;"><img src="{{ asset('img/trademark_1.jpg') }}?v=42" alt="Visa"></a></li>
                                <li><a href="javascript:;"><img src="{{ asset('img/trademark_2.jpg') }}?v=42" alt="Mastercard"></a></li>
                                <li><a href="javascript:;"><img src="{{ asset('img/trademark_3.jpg') }}?v=42" alt="JCB"></a></li>
                                <li><a href="javascript:;"><img src="{{ asset('img/trademark_4.jpg') }}?v=42" alt="ATM"></a></li>
                                <li><a href="javascript:;"><img src="{{ asset('img/trademark_5.jpg') }}?v=42" alt="Internet Banking"></a></li>
                                <li><a href="javascript:;"><img src="{{ asset('img/trademark_6.jpg') }}?v=42" alt="Momo"></a></li>
                                <li><a href="javascript:;"><img src="{{ asset('img/trademark_7.jpg') }}?v=42" alt="ZaloPay"></a></li>
                                <li><a href="javascript:;"><img src="{{ asset('img/trademark_8.jpg') }}?v=42" alt="VNPay"></a></li>
                                <li><a href="javascript:;"><img src="{{ asset('img/trademark_9.jpg') }}?v=42" alt="ShopeePay"></a></li>
                                <li><a href="javascript:;"><img src="{{ asset('img/trademark_10.jpg') }}?v=42" alt="COD"></a></li>
                            </ul>
                        </div>
                    </div> <!-- /#trademark-box -->

                    <p class="cpr text-center">
                        &copy; 2024 Bản quyền thuộc về <strong>JEWELRY STORE</strong> |
                        <a href="http://runtime.vn/" target="_blank">Powered by RUNTIME.VN</a> |
                        Thiết kế website bán trang sức chuyên nghiệp
                    </p>
                </div>
            </footer>
        </div>

    </div>

    <!-- Loading Mask -->
    <div style="display: none;" id="loading-mask">
        <div id="loading_mask_loader" class="loader" style="
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(26, 35, 126, 0.95);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            backdrop-filter: blur(10px);
        ">
            <div style="
                width: 60px;
                height: 60px;
                border: 4px solid rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                border-top-color: #ffd700;
                animation: spin 1s ease-in-out infinite;
                margin-bottom: 20px;
            "></div>
            <div style="
                color: white;
                font-size: 16px;
                font-weight: 500;
                letter-spacing: 1px;
            ">
                Đang tải...
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <a href="#" class="scroll_top" title="Lên đầu trang" style="display: none;">
        <i class="fa fa-chevron-up"></i>
    </a>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="module" src="{{ asset('js/index.js') }}"></script>
    @stack('scripts')

    <script type="text/javascript">
        $(function() {
            $(".header-content").css({
                "background": ''
            });
            $("html").addClass('');

            // Scroll to top functionality
            $(window).scroll(function() {
                if ($(this).scrollTop() > 100) {
                    $('.scroll_top').fadeIn();
                } else {
                    $('.scroll_top').fadeOut();
                }
            });
        });

        // Smooth scroll to top
        document.querySelector('.scroll_top').onclick = function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        };

        // Add loading animation keyframes
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
            
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .footer .col-md-3, .footer .col-md-6 {
                animation: fadeInUp 0.6s ease-out;
            }
            
            .footer .col-md-3:nth-child(1) { animation-delay: 0.1s; }
            .footer .col-md-6:nth-child(2) { animation-delay: 0.2s; }
            .footer .col-md-3:nth-child(3) { animation-delay: 0.3s; }
            
            .nav-item a:hover {
                text-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
            }
            
            .cart-btn:hover i, .user-btn:hover i {
                animation: pulse 0.6s ease-in-out;
            }
            
            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.1); }
            }
            
            /* Mobile responsive improvements */
            @media (max-width: 480px) {
                .search-box input {
                    font-size: 14px;
                    padding: 0 50px 0 20px;
                }
                
                .top-link .hotline {
                    font-size: 14px;
                }
                
                .top-link .hotline i {
                    width: 28px;
                    height: 28px;
                    font-size: 12px;
                }
                
                .footer .introduce-title {
                    font-size: 16px;
                }
                
                .footer #address-box img {
                    max-width: 150px;
                }
            }
        `;
        document.head.appendChild(style);

        // ================== CART: localStorage sync & header badge ==================
        (function() {
            const CART_KEY = 'jewelry_cart';
            const EXPIRE_DAYS = 30;

            function now() {
                return Date.now();
            }

            function getExpireTime() {
                return now() + EXPIRE_DAYS * 24 * 60 * 60 * 1000;
            }

            function getCartObj() {
                try {
                    const obj = JSON.parse(localStorage.getItem(CART_KEY));
                    if (!obj || !obj.data) return {
                        data: [],
                        expires: 0
                    };
                    // Check expiration
                    if (obj.expires && obj.expires < now()) {
                        localStorage.removeItem(CART_KEY);
                        return {
                            data: [],
                            expires: 0
                        };
                    }
                    return obj;
                } catch (e) {
                    return {
                        data: [],
                        expires: 0
                    };
                }
            }

            function getCart() {
                return getCartObj().data;
            }

            function saveCart(cart) {
                localStorage.setItem(CART_KEY, JSON.stringify({
                    data: cart,
                    expires: getExpireTime()
                }));
                window.dispatchEvent(new CustomEvent('cart:changed', {
                    detail: {
                        count: getCartCount()
                    }
                }));
            }

            function getCartCount() {
                return getCart().reduce(function(sum, item) {
                    var q = parseInt(item.quantity) || 0;
                    return sum + q;
                }, 0);
            }

            function updateHeaderCartCount() {
                var el = document.querySelector('.cart-count');
                if (el) el.textContent = getCartCount();
            }

            // Initial update on load
            document.addEventListener('DOMContentLoaded', updateHeaderCartCount);
            // React to external updates if any
            window.addEventListener('cart:changed', updateHeaderCartCount);

            // Intercept generic add-to-cart clicks to mirror into localStorage
            document.addEventListener('click', function(e) {
                var btn = e.target.closest('.add-to-cart');
                if (!btn) return;

                var id = btn.getAttribute('data-id') || btn.dataset.id;
                if (!id) return;

                // Try to find a nearby quantity input, fallback to 1
                var qty = 1;
                var wrap = btn.closest('.product-item') || document;
                var input = wrap.querySelector('.quantity');
                if (input) {
                    var parsed = parseInt(input.value);
                    if (!isNaN(parsed) && parsed > 0) qty = parsed;
                }

                var cart = getCart();
                var found = cart.find(function(i) {
                    return String(i.id) === String(id);
                });
                if (found) {
                    found.quantity = (parseInt(found.quantity) || 0) + qty;
                } else {
                    cart.push({
                        id: id,
                        quantity: qty
                    });
                }
                saveCart(cart);
                updateHeaderCartCount();
            }, true);

            // Expose minimal API if needed elsewhere
            window.CartLS = {
                get: getCart,
                set: saveCart,
                count: getCartCount,
                updateBadge: updateHeaderCartCount
            };
        })();
        // ================== NOTIFICATION DROPDOWN (dưới chuông, đơn giản, không xung đột) ==================
        document.addEventListener('DOMContentLoaded', function() {
            var dropdown = document.getElementById('notificationDropdownNew');
            var openBtn = document.getElementById('desktop-notification-btn');
            var closeBtn = document.getElementById('closeNotificationDropdownNew');
            if (openBtn && dropdown) {
                openBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                });
            }
            if (closeBtn && dropdown) {
                closeBtn.addEventListener('click', function() {
                    dropdown.classList.add('hidden');
                });
            }
            // Ẩn dropdown khi click ra ngoài
            document.addEventListener('click', function(e) {
                if (dropdown && !dropdown.classList.contains('hidden')) {
                    if (!dropdown.contains(e.target) && e.target.id !== 'desktop-notification-btn') {
                        dropdown.classList.add('hidden');
                    }
                }
            });
        });
    </script>

    <!-- Enhanced Popup container -->
    <div id="notificationPopup"
        class="fixed bottom-24 left-4 w-[380px] md:w-[420px] notification-popup p-8 text-white font-sans shadow-2xl z-30 hidden"
        role="dialog" aria-modal="true" aria-labelledby="popup-title"
        style="background:linear-gradient(135deg,#1a237e 0%,#3f51b5 100%);border-radius:18px;">
        <div class="flex justify-between items-start mb-6">
            <h2 id="popup-title" class="font-extrabold text-xl leading-tight max-w-[80%]">
                Ưu điểm nổi bật của TVT Jewelry
            </h2>
            <button id="closePopup" aria-label="Close popup"
                class="text-white text-2xl leading-none hover:opacity-80 transition"
                style="background:none;border:none;cursor:pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="space-y-4 mb-6 text-base font-medium leading-relaxed">
            <li class="flex items-center"><i class="fas fa-gem mr-4" style="color:#ffd700"></i> Thiết kế tinh xảo, độc quyền</li>
            <li class="flex items-center"><i class="fas fa-star mr-4" style="color:#ffd700"></i> Chất lượng vàng bạc đạt chuẩn</li>
            <li class="flex items-center"><i class="fas fa-shipping-fast mr-4" style="color:#ffd700"></i> Giao hàng toàn quốc</li>
            <li class="flex items-center"><i class="fas fa-sync-alt mr-4" style="color:#ffd700"></i> Đổi trả dễ dàng trong 48h</li>
            <li class="flex items-center"><i class="fas fa-hand-holding-heart mr-4" style="color:#ffd700"></i> Bảo hành trọn đời sản phẩm</li>
        </ul>
        <p class="italic text-sm leading-relaxed max-w-[95%] opacity-90">
            Hãy khám phá bộ sưu tập trang sức mới nhất của TVT – tôn vinh vẻ đẹp và đẳng cấp của bạn!
        </p>
    </div>
</body>

</html>