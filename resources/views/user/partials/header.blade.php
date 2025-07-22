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
                    <li><a href="{{ url('kiem-tra-don-hang') }}" style="color: #888;"><i class="fa fa-pencil-square-o"></i> Kiểm tra đơn hàng</a></li>
                    <li><a href="{{ url('gio-hang') }}" style="color: #888;"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
                    <li><a href="{{ url('dang-nhap') }}" style="color: #888;"><i class="fa fa-sign-in"></i> Đăng nhập</a></li>
                    <li><a href="{{ url('dang-ky') }}" style="color: #888;"><i class="fa fa-key"></i> Đăng ký</a></li>
                </ul>
                <!-- Mobile menu -->
                <div class="visible-xs" style="display: flex; justify-content: flex-end; gap: 8px;">
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" id="userMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 6px 12px;">
                            <i class="fa fa-user"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="userMenu">
                            <li><a href="{{ url('dang-ky') }}"><i class="fa fa-sign-in"></i> Đăng ký</a></li>
                            <li><a href="{{ url('dang-nhap') }}"><i class="fa fa-key"></i> Đăng nhập</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" id="quickMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 6px 12px;">
                            <i class="fa fa-list"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="quickMenu">
                            <li><a href="{{ url('kiem-tra-don-hang') }}"><i class="fa fa-pencil-square-o"></i> Kiểm tra đơn hàng</a></li>
                            <li><a href="{{ url('gio-hang') }}"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container" style="padding: 18px 0 12px 0;">
    <div class="row" style="align-items: center; display: flex;">
        <!-- Logo -->
        <div class="col-xs-12 col-sm-3 text-center" style="display: flex; align-items: center; justify-content: center;">
            <a href="{{ url('/') }}" class="logo" title="Fashion Store">
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
            <div style="position: relative;">
                <a href="{{ url('gio-hang') }}" style="display: flex; align-items: center; justify-content: center; border: 2px solid #bfa46b; border-radius: 50%; width: 54px; height: 54px; color: #bfa46b; font-size: 28px; position: relative; background: #fff;">
                    <i class="fa fa-shopping-cart" style="margin:0; color: #bfa46b;"></i>
                    <span style="position: absolute; top: -8px; right: -8px; background: #009688; color: #fff; border-radius: 50px; font-size: 18px; min-width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 3px solid #fff; box-shadow: 0 2px 6px rgba(0,0,0,0.07);">
                        0
                    </span>
                </a>
            </div>
            <div>
                <a href="{{ url('dang-nhap') }}" style="display: inline-block; border: 2px solid #bfa46b; border-radius: 50%; width: 44px; height: 44px; text-align: center; line-height: 40px; color: #9c8656; font-size: 22px;">
                    <i class="fa fa-user"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<div style="background: #9c8656;">
    <div class="container">
        <ul class="nav" style="margin: 0; padding: 0; display: flex; list-style: none;">
            <li style="background: #5a4321; color: #fff; font-weight: bold;">
                <a href="#" style="display: block; padding: 14px 28px; color: #fff; text-transform: uppercase; font-weight: bold; letter-spacing: 1px;">
                    <i class="fa fa-bars"></i> DANH MỤC SẢN PHẨM
                </a>
            </li>
            <li><a href="{{ url('trang-chu') }}" style="display: block; padding: 14px 28px; color: #fff;">Trang chủ</a></li>
            <li><a href="{{ url('gioi-thieu') }}" style="display: block; padding: 14px 28px; color: #fff;">Giới thiệu</a></li>
            <li><a href="{{ url('san-pham') }}" style="display: block; padding: 14px 28px; color: #fff;">Sản phẩm</a></li>
            <li><a href="{{ url('tin-tuc') }}" style="display: block; padding: 14px 28px; color: #fff;">Tin tức</a></li>
            <li><a href="{{ url('lien-he') }}" style="display: block; padding: 14px 28px; color: #fff;">Liên hệ</a></li>
        </ul>
    </div>
</div>