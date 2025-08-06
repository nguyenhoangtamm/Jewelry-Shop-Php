@extends('user.layout')
@section('title', 'Thanh toán đơn hàng')
@section('content')
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Spectral', serif;
        background-color: #f5f5f5;
        line-height: 1.6;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .checkout-header {
        background: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .checkout-title {
        font-size: 24px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #666;
        font-size: 14px;
    }

    .checkout-content {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 20px;
    }

    .checkout-form {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .form-section {
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 15px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #333;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #007bff;
    }

    .payment-methods {
        display: grid;
        gap: 10px;
    }

    .payment-method {
        display: flex;
        align-items: center;
        padding: 15px;
        border: 2px solid #f0f0f0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .payment-method:hover {
        border-color: #007bff;
        background-color: #f8f9ff;
    }

    .payment-method.selected {
        border-color: #007bff;
        background-color: #f8f9ff;
    }

    .payment-method input[type="radio"] {
        margin-right: 10px;
    }

    .payment-icon {
        width: 40px;
        height: 40px;
        margin-right: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0f0f0;
        border-radius: 5px;
        font-size: 18px;
    }

    .order-summary {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        height: fit-content;
        position: sticky;
        top: 20px;
    }

    .product-item {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f0f0f0;
    }

    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 5px;
    }

    .product-info h4 {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }

    .product-code {
        font-size: 12px;
        color: #666;
        margin-bottom: 5px;
    }

    .product-quantity {
        font-size: 14px;
        color: #666;
    }

    .product-price {
        font-size: 16px;
        font-weight: 600;
        color: #e74c3c;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding: 5px 0;
    }

    .summary-row.total {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        padding-top: 15px;
        border-top: 2px solid #f0f0f0;
        margin-top: 15px;
    }

    .btn {
        padding: 15px 30px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-outline {
        background-color: transparent;
        color: #007bff;
        border: 2px solid #007bff;
    }

    .btn-outline:hover {
        background-color: #007bff;
        color: white;
    }

    .checkout-actions {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }

    .checkout-actions .btn {
        flex: 1;
    }

    @media (max-width: 768px) {
        .checkout-content {
            grid-template-columns: 1fr;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .checkout-actions {
            flex-direction: column;
        }
    }
</style>
<div class="checkout-container">
    <!-- Header -->
    <div class="checkout-header">
        <h1 class="checkout-title">Thanh toán đơn hàng</h1>
        <div class="breadcrumb">
            <a href="/">Trang chủ</a>
            <span>></span>
            <a href="/jewelry/{{ $jewelry_id }}">Chi tiết sản phẩm</a>
            <span>></span>
            <span>Thanh toán</span>
        </div>
    </div>

    <div class="checkout-content">
        <!-- Form thông tin -->
        <div class="checkout-form">
            <form id="checkoutForm" method="POST">
                @csrf
                <input type="hidden" name="jewelry_id" value="{{ $jewelry_id }}">
                <input type="hidden" name="quantity" value="{{ $quantity }}">
                <input type="hidden" name="total_amount" value="{{ $total_amount }}">

                <!-- Thông tin nhận hàng -->
                <div class="form-section">
                    <h3 class="section-title">Thông tin nhận hàng</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="fullname">Họ và tên *</label>
                            <input type="text" id="fullname" name="fullname"
                                value="{{ old('fullname', $user->fullname ?? '') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại *</label>
                            <input type="tel" id="phone" name="phone_number"
                                value="{{ old('phone_number', $user->phone_number ?? '') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email"
                            value="{{ old('email', $user->email ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ nhận hàng *</label>
                        <textarea id="address" name="address" rows="3" required>{{ old('address', $user->address ?? '') }}</textarea>
                    </div>
                </div>

                <!-- Phương thức vận chuyển -->
                <div class="form-section">
                    <h3 class="section-title">Phương thức vận chuyển</h3>
                    <div class="payment-methods">
                        <label class="payment-method selected">
                            <input type="radio" name="shipping_method" value="standard" checked>
                            <div class="payment-icon">🚚</div>
                            <div>
                                <div style="font-weight: 600;">Giao hàng tiêu chuẩn</div>
                                <div style="font-size: 12px; color: #666;">Miễn phí - Giao trong 3-7 ngày</div>
                            </div>
                        </label>
                        <label class="payment-method">
                            <input type="radio" name="shipping_method" value="express">
                            <div class="payment-icon">⚡</div>
                            <div>
                                <div style="font-weight: 600;">Giao hàng nhanh</div>
                                <div style="font-size: 12px; color: #666;">50.000đ - Giao trong 1-2 ngày</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Phương thức thanh toán -->
                <div class="form-section">
                    <h3 class="section-title">Phương thức thanh toán</h3>
                    <div class="payment-methods">
                        <label class="payment-method selected">
                            <input type="radio" name="payment_method" value="cod" checked>
                            <div class="payment-icon">💵</div>
                            <div>
                                <div style="font-weight: 600;">Thanh toán khi nhận hàng (COD)</div>
                                <div style="font-size: 12px; color: #666;">Thanh toán bằng tiền mặt khi nhận hàng</div>
                            </div>
                        </label>
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="bank_transfer">
                            <div class="payment-icon">🏦</div>
                            <div>
                                <div style="font-weight: 600;">Chuyển khoản ngân hàng</div>
                                <div style="font-size: 12px; color: #666;">Chuyển khoản qua tài khoản ngân hàng</div>
                            </div>
                        </label>
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="vnpay">
                            <div class="payment-icon">💳</div>
                            <div>
                                <div style="font-weight: 600;">VNPAY</div>
                                <div style="font-size: 12px; color: #666;">Thanh toán qua VNPAY - Ưu đãi 300K</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Ghi chú -->
                <div class="form-section">
                    <h3 class="section-title">Ghi chú đơn hàng (không bắt buộc)</h3>
                    <div class="form-group">
                        <textarea name="note" rows="3" placeholder="Ghi chú thêm cho đơn hàng..."></textarea>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tóm tắt đơn hàng -->
        <div class="order-summary">
            <h3 class="section-title">Tóm tắt đơn hàng</h3>
            <!-- Sản phẩm -->
            <div class="product-item">
                <img src="{{ $image ? asset($image) : asset('images/default-product.jpg') }}"
                    alt="{{ $jewelry->name }}" class="product-image">
                <div class="product-info">
                    <h4>{{ $jewelry->name }}</h4>
                    <div class="product-code">Mã: {{ $jewelry->id }}</div>
                    <div class="product-quantity">Số lượng: {{ $quantity }}</div>
                    <div class="product-price">{{ number_format($jewelry->price, 0, ',', '.') }}₫</div>
                </div>
            </div>
            <!-- Tóm tắt giá -->
            <div class="summary-row">
                <span>Tạm tính:</span>
                <span>{{ number_format($total_amount, 0, ',', '.') }}₫</span>
            </div>
            <div class="summary-row">
                <span>Phí vận chuyển:</span>
                <span id="shipping-fee">Miễn phí</span>
            </div>
            <div class="summary-row total">
                <span>Tổng cộng:</span>
                <span id="total-amount">{{ number_format($total_amount, 0, ',', '.') }}₫</span>
            </div>
            <!-- Nút hành động -->
            <div class="checkout-actions">
                <button type="submit" form="checkoutForm" class="btn btn-primary">
                    ĐẶT HÀNG
                </button>
                <a href="/jewelry/{{ $jewelry_id }}" class="btn btn-outline">
                    Quay lại
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    // Xử lý chọn phương thức thanh toán và vận chuyển
    // ... giữ nguyên script như bản PHP ...
</script>
@endsection