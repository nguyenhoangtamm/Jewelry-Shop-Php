@extends('user.layout')

@section('title', 'Thanh toán')

@section('content')
<style>
    :root {
        --galaxy-blue: #4A6FA5;
        --galaxy-blue-light: #6B8AC7;
        --galaxy-blue-dark: #2D4A73;
        --galaxy-blue-gradient: linear-gradient(135deg, #4A6FA5 0%, #6B8AC7 100%);
        --shadow-light: 0 4px 20px rgba(74, 111, 165, 0.15);
        --shadow-medium: 0 8px 30px rgba(74, 111, 165, 0.25);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background: linear-gradient(135deg, #f8faff 0%, #e8f0ff 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .checkout-container {
        padding: 2rem 0;
        min-height: 100vh;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--galaxy-blue-dark);
        text-align: center;
        margin-bottom: 3rem;
        position: relative;
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: var(--galaxy-blue-gradient);
        border-radius: 2px;
    }

    .modern-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        border: 1px solid rgba(74, 111, 165, 0.1);
        transition: var(--transition);
        overflow: hidden;
    }

    .modern-card:hover {
        box-shadow: var(--shadow-medium);
        transform: translateY(-2px);
    }

    .card-header-modern {
        background: var(--galaxy-blue-gradient);
        color: white;
        padding: 1.5rem 2rem;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .card-header-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='3' cy='3' r='3'/%3E%3Ccircle cx='13' cy='13' r='3'/%3E%3C/g%3E%3C/svg%3E") repeat;
    }

    .card-header-modern h5 {
        font-size: 1.4rem;
        font-weight: 600;
        margin: 0;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-body-modern {
        padding: 2rem;
    }

    .form-label-modern {
        font-size: 1rem;
        font-weight: 600;
        color: var(--galaxy-blue-dark);
        margin-bottom: 0.75rem;
        display: block;
    }

    .form-control-modern {
        border: 2px solid #e1e8f0;
        border-radius: 12px;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        transition: var(--transition);
        background: #fafbfd;
    }

    .form-control-modern:focus {
        border-color: var(--galaxy-blue);
        box-shadow: 0 0 0 4px rgba(74, 111, 165, 0.1);
        background: white;
        outline: none;
    }

    .form-check-modern {
        background: #f8faff;
        border: 2px solid #e1e8f0;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        transition: var(--transition);
        cursor: pointer;
    }

    .form-check-modern:hover {
        border-color: var(--galaxy-blue-light);
        background: #f0f6ff;
    }

    .form-check-modern.active {
        border-color: var(--galaxy-blue);
        background: rgba(74, 111, 165, 0.05);
    }

    .form-check-input-modern {
        width: 20px;
        height: 20px;
        margin-right: 1rem;
        accent-color: var(--galaxy-blue);
    }

    .payment-label {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--galaxy-blue-dark);
        margin-bottom: 0.25rem;
    }

    .payment-description {
        font-size: 0.9rem;
        color: #6b7280;
    }

    .order-summary-item {
        display: flex;
        justify-content: between;
        align-items: start;
        padding: 1rem 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .order-summary-item:last-child {
        border-bottom: none;
    }

    .item-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--galaxy-blue-dark);
        margin-bottom: 0.25rem;
    }

    .item-quantity {
        font-size: 0.9rem;
        color: #6b7280;
    }

    .item-price {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--galaxy-blue);
    }

    .total-row {
        background: rgba(74, 111, 165, 0.05);
        padding: 1.5rem;
        margin: -1rem -2rem 2rem -2rem;
        border-radius: 12px;
    }

    .total-amount {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--galaxy-blue-dark);
    }

    .btn-order-modern {
        background: var(--galaxy-blue-gradient);
        border: none;
        border-radius: 12px;
        padding: 1rem 2rem;
        font-size: 1.2rem;
        font-weight: 600;
        color: white;
        width: 100%;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .btn-order-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-order-modern:hover::before {
        left: 100%;
    }

    .btn-order-modern:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .btn-order-modern:disabled {
        opacity: 0.7;
        transform: none;
    }

    .bank-transfer-info {
        background: linear-gradient(135deg, #f8faff 0%, #e8f0ff 100%);
        border: 2px solid var(--galaxy-blue-light);
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1rem;
        text-align: center;
    }

    .qr-code {
        border-radius: 12px;
        box-shadow: var(--shadow-light);
        max-width: 200px;
        width: 100%;
    }

    .privacy-notice {
        background: rgba(74, 111, 165, 0.05);
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1.5rem;
        font-size: 0.85rem;
        color: #6b7280;
        text-align: center;
        line-height: 1.5;
    }

    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
    }

    .empty-cart-icon {
        font-size: 4rem;
        color: var(--galaxy-blue-light);
        margin-bottom: 1.5rem;
    }

    .empty-cart h4 {
        font-size: 1.8rem;
        color: var(--galaxy-blue-dark);
        margin-bottom: 1rem;
    }

    /* Success Notification */
    .success-notification {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        z-index: 10000;
        text-align: center;
        min-width: 400px;
        display: none;
        border: 3px solid var(--galaxy-blue);
    }

    .success-notification.show {
        display: block;
        animation: successSlideIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .notification-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        display: none;
        backdrop-filter: blur(5px);
    }

    .notification-overlay.show {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    .success-icon {
        width: 80px;
        height: 80px;
        background: var(--galaxy-blue-gradient);
        border-radius: 50%;
        margin: 0 auto 1.5rem auto;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        animation: successIconPulse 1s ease-in-out;
    }

    .success-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--galaxy-blue-dark);
        margin-bottom: 1rem;
    }

    .success-message {
        font-size: 1.1rem;
        color: #6b7280;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .notification-close-btn {
        background: var(--galaxy-blue-gradient);
        border: none;
        border-radius: 12px;
        padding: 0.75rem 2rem;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .notification-close-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    @keyframes successSlideIn {
        0% {
            opacity: 0;
            transform: translate(-50%, -50%) scale(0.8) rotateX(90deg);
        }

        100% {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1) rotateX(0deg);
        }
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @keyframes successIconPulse {
        0% {
            transform: scale(0);
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }

        .card-body-modern {
            padding: 1.5rem;
        }

        .success-notification {
            min-width: 320px;
            margin: 1rem;
            padding: 2rem;
        }

        .success-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="checkout-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title">
                    <i class="fas fa-credit-card"></i>
                    Thanh toán
                </h1>

                @if($cartItems->count() > 0)
                <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Thông tin giao hàng -->
                            <div class="modern-card mb-4">
                                <div class="card-header-modern">
                                    <h5>
                                        <i class="fas fa-shipping-fast"></i>
                                        Thông tin giao hàng
                                    </h5>
                                </div>
                                <div class="card-body-modern">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label for="fullname" class="form-label-modern">Họ và tên *</label>
                                                <input type="text" class="form-control form-control-modern"
                                                    id="fullname" name="fullname"
                                                    value="{{ Auth::user()->fullname }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label for="phone" class="form-label-modern">Số điện thoại *</label>
                                                <input type="tel" class="form-control form-control-modern"
                                                    id="phone" name="phone"
                                                    value="{{ Auth::user()->phone_number }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="email" class="form-label-modern">Email</label>
                                        <input type="email" class="form-control form-control-modern"
                                            id="email" name="email"
                                            value="{{ Auth::user()->email }}">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="address" class="form-label-modern">Địa chỉ giao hàng *</label>
                                        <textarea class="form-control form-control-modern"
                                            id="address" name="address" rows="3" required>{{ Auth::user()->address }}</textarea>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="note" class="form-label-modern">Ghi chú đơn hàng</label>
                                        <textarea class="form-control form-control-modern"
                                            id="note" name="note" rows="3"
                                            placeholder="Ghi chú về đơn hàng của bạn, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Phương thức thanh toán -->
                            <div class="modern-card">
                                <div class="card-header-modern">
                                    <h5>
                                        <i class="fas fa-credit-card"></i>
                                        Phương thức thanh toán
                                    </h5>
                                </div>
                                <div class="card-body-modern">
                                    <div class="form-check-modern" onclick="selectPayment('cod')">
                                        <input class="form-check-input form-check-input-modern"
                                            type="radio" name="payment_method" id="cod" value="cod" checked>
                                        <div>
                                            <div class="payment-label">
                                                <i class="fas fa-money-bill-wave"></i>
                                                Thanh toán khi nhận hàng (COD)
                                            </div>
                                            <div class="payment-description">
                                                Bạn sẽ thanh toán bằng tiền mặt khi nhận được hàng
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-check-modern" onclick="selectPayment('bank_transfer')">
                                        <input class="form-check-input form-check-input-modern"
                                            type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                        <div>
                                            <div class="payment-label">
                                                <i class="fas fa-university"></i>
                                                Chuyển khoản ngân hàng
                                            </div>
                                            <div class="payment-description">
                                                Chuyển khoản trực tiếp vào tài khoản ngân hàng của chúng tôi
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Thông tin chuyển khoản -->
                                    <div id="bank-transfer-info" class="bank-transfer-info" style="display:none;">
                                        <h6 class="mb-3" style="color: var(--galaxy-blue-dark); font-weight: 600;">
                                            <i class="fas fa-qrcode"></i>
                                            Quét mã QR để thanh toán
                                        </h6>
                                        <img src="https://img.vietqr.io/image/sacombank-070130092398-compact2.png?accountName=PHAM%20MY%20TIEN&amount={{ $total ?? 0 }}&addInfo=Thanh+toan+don+hang+{{ $order->id ?? 'unknown' }}"
                                            alt="QR chuyển khoản" class="qr-code">
                                        <p class="mt-3 mb-0" style="font-size: 0.9rem; color: #6b7280;">
                                            Vui lòng chuyển khoản chính xác số tiền và nội dung chuyển khoản
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <!-- Đơn hàng của bạn -->
                            <div class="modern-card sticky-top" style="top: 2rem;">
                                <div class="card-header-modern">
                                    <h5>
                                        <i class="fas fa-shopping-bag"></i>
                                        Đơn hàng của bạn
                                    </h5>
                                </div>
                                <div class="card-body-modern">
                                    @foreach($cartItems as $item)
                                    <div class="order-summary-item">
                                        <div class="flex-grow-1">
                                            <div class="item-name">{{ $item->jewelry->name }}</div>
                                            <div class="item-quantity">
                                                <i class="fas fa-times"></i> {{ $item->quantity }}
                                            </div>
                                        </div>
                                        <div class="item-price">
                                            {{ number_format($item->total, 0, ',', '.') }} VNĐ
                                        </div>

                                        {{-- Hidden inputs to send each item's id, quantity and item total with the form --}}
                                        <input type="hidden" name="items[{{ $loop->index }}][jewelry_id]" value="{{ $item->jewelry->id }}">
                                        <input type="hidden" name="items[{{ $loop->index }}][quantity]" value="{{ $item->quantity }}">
                                        <input type="hidden" name="items[{{ $loop->index }}][item_total]" value="{{ $item->total }}">
                                    </div>
                                    @endforeach

                                    <div class="total-row">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span style="font-size: 1.1rem; color: #6b7280;">Tạm tính:</span>
                                            <span style="font-size: 1.1rem; font-weight: 600;">
                                                {{ number_format($total, 0, ',', '.') }} VNĐ
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <span style="font-size: 1.1rem; color: #6b7280;">Phí vận chuyển:</span>
                                            <span class="text-success" style="font-size: 1.1rem; font-weight: 600;">
                                                <i class="fas fa-gift"></i> Miễn phí
                                            </span>
                                        </div>
                                        <hr style="margin: 1rem 0; border-color: var(--galaxy-blue-light);">
                                        <div class="d-flex justify-content-between">
                                            <span style="font-size: 1.2rem; font-weight: 700; color: var(--galaxy-blue-dark);">
                                                Tổng cộng:
                                            </span>
                                            <span class="total-amount">
                                                {{ number_format($total, 0, ',', '.') }} VNĐ
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Hidden input to send order total amount --}}
                                    <input type="hidden" name="total_amount" value="{{ $total }}">

                                    <button type="submit" class="btn-order-modern" id="place-order-btn">
                                        <i class="fas fa-lock"></i>
                                        Đặt hàng ngay
                                    </button>

                                    <!-- Success Notification Container -->
                                    <div id="success-notification-container"></div>

                                    <div class="privacy-notice">
                                        <i class="fas fa-shield-alt" style="color: var(--galaxy-blue);"></i>
                                        Thông tin cá nhân của bạn sẽ được bảo mật và chỉ sử dụng để xử lý đơn hàng,
                                        hỗ trợ trải nghiệm mua sắm tại cửa hàng của chúng tôi.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @else
                <div class="empty-cart">
                    <div class="empty-cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h4>Giỏ hàng của bạn đang trống</h4>
                    <p style="color: #6b7280; font-size: 1.1rem; margin-bottom: 2rem;">
                        Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán.
                    </p>
                    <a href="{{ route('home') }}" class="btn-order-modern" style="max-width: 300px; margin: 0 auto;">
                        <i class="fas fa-shopping-bag"></i> Tiếp tục mua sắm
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Notification Overlay and Modal -->
<div class="notification-overlay" id="notification-overlay"></div>
<div class="success-notification" id="success-notification">
    <div class="success-icon">
        <i class="fas fa-check"></i>
    </div>
    <div class="success-title">Đặt hàng thành công!</div>
    <div class="success-message">
        Cảm ơn bạn đã tin tưởng và mua sắm tại cửa hàng của chúng tôi.
        Đơn hàng của bạn đang được xử lý và sẽ được giao sớm nhất có thể.
    </div>
    <button class="notification-close-btn" onclick="closeSuccessNotification()">
        <i class="fas fa-arrow-right"></i>
        Xem đơn hàng
    </button>
</div>

<script>
    function selectPayment(method) {
        // Remove active class from all payment methods
        document.querySelectorAll('.form-check-modern').forEach(el => {
            el.classList.remove('active');
        });

        // Add active class to selected method
        event.currentTarget.classList.add('active');

        // Handle radio selection
        document.getElementById(method).checked = true;

        // Show/hide bank transfer info
        const bankInfo = document.getElementById('bank-transfer-info');
        if (method === 'bank_transfer') {
            bankInfo.style.display = 'block';
        } else {
            bankInfo.style.display = 'none';
        }
    }

    function showSuccessNotification() {
        document.getElementById('notification-overlay').classList.add('show');
        document.getElementById('success-notification').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeSuccessNotification() {
        document.getElementById('notification-overlay').classList.remove('show');
        document.getElementById('success-notification').classList.remove('show');
        document.body.style.overflow = 'auto';

        // Redirect after closing
        setTimeout(() => {
            window.location.href = '{{ route("user.orders.index") }}';
        }, 300);
    }

    // Initialize form interactions
    $(document).ready(function() {
        // Set initial active state
        document.querySelector('.form-check-modern').classList.add('active');

        $('#checkout-form').submit(function(e) {
            e.preventDefault();

            const btn = $('#place-order-btn');
            const originalText = btn.html();

            // Disable button and show loading
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...');

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        // Show modern success notification instead of alert
                        showSuccessNotification();
                    } else {
                        alert(response.message || 'Có lỗi xảy ra khi đặt hàng');
                        btn.prop('disabled', false).html(originalText);
                    }
                },
                error: function(xhr) {
                    let message = 'Có lỗi xảy ra khi đặt hàng';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = Object.values(xhr.responseJSON.errors).flat();
                        message = errors.join('\n');
                    }
                    alert(message);
                    btn.prop('disabled', false).html(originalText);
                }
            });
        });

        // Close notification when clicking overlay
        $('#notification-overlay').click(function() {
            closeSuccessNotification();
        });
    });
</script>
@endsection