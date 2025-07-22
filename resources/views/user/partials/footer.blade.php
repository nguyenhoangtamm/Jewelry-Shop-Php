<footer id="footer">
    <div class="container">
        <div id="introduce-box" class="row">
            <div class="col-md-3">
                <div id="address-box">
                    <a href="{{ url('/') }}"><img src="{{ asset('Uploads/shop2198/images/logo2.png') }}" alt="logo"></a>
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
                        <div class="introduce-title">Về chúng tôi</div>
                        <ul class="introduce-list">
                            <li class="item"><a href="{{ url('gioi-thieu') }}">Giới thiệu</a></li>
                            <li class="item"><a href="{{ url('content/giao-hang-doi-tra') }}">Giao hàng - Đổi trả</a></li>
                            <li class="item"><a href="{{ url('content/chinh-sach-bao-mat') }}">Chính sách bảo mật</a></li>
                            <li class="item"><a href="{{ url('lien-he') }}">Liên hệ</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <div class="introduce-title">Trợ giúp</div>
                        <ul class="introduce-list">
                            <li class="item"><a href="{{ url('content/huong-dan-mua-hang') }}">Hướng dẫn mua hàng</a></li>
                            <li class="item"><a href="{{ url('content/huong-dan-thanh-toan') }}">Hướng dẫn thanh toán</a></li>
                            <li class="item"><a href="{{ url('content/tai-khoan-giao-dich') }}">Tài khoản giao dịch</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div id="contact-box">
                    <div class="introduce-title">Đăng ký nhận tin</div>
                    <form class='contact-form'>
                        <div class="input-group" id="mail-box">
                            <input type="email" placeholder="Đăng ký email" required="required">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default">Gửi</button>
                            </span>
                        </div>
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
        </div>
        <div id="trademark-box" class="row">
            <div class="col-sm-12">
                <ul id="trademark-list">
                    <li id="payment-methods">Phương thức thanh toán</li>
                    @for ($i = 1; $i <= 10; $i++)
                        <li><a href="javascript:;"><img src="{{ asset('img/trademark_' . $i . '.jpg?v=42') }}" alt="Phương thức thanh toán {{ $i }}"></a></li>
                        @endfor
                </ul>
            </div>
        </div>
        <p class="cpr text-center">
            &copy; Bản quyền thuộc về <a href="http://runtime.vn/" style="color: #0f9ed8" target="_blank">RUNTIME STORE</a> | <a target="_blank" href="https://www.runtime.vn">Powered by RUNTIME.VN</a>.
        </p>
    </div>
</footer>