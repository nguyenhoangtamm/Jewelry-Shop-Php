@extends('user.layout')

@section('title', 'Giỏ hàng')

@section('content')
<div class="container mt-4">
    <div class="d-flex align-items-center mb-4">
        <h2 class="mb-0 fw-bold text-dark">
            <i class="fas fa-shopping-cart me-2 text-primary"></i>
            Giỏ hàng của bạn
        </h2>
    </div>

    @if(empty($cart))
    <div class="empty-cart-container">
        <div class="text-center py-5">
            <div class="empty-cart-icon mb-4">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h3 class="mb-3 text-dark fw-bold">Giỏ hàng trống</h3>
            <p class="text-muted mb-4 fs-5">Hãy khám phá các sản phẩm tuyệt vời của chúng tôi</p>
            <a href="{{ route('home') }}" class="btn btn-primary btn-lg px-4 py-2 rounded-pill">
                <i class="fas fa-arrow-left me-2"></i>
                Bắt đầu mua sắm
            </a>
        </div>
    </div>
    @else
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="cart-card">
                <div class="cart-header">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-list-ul me-2"></i>
                        Sản phẩm trong giỏ hàng ({{ count($cart) }} mặt hàng)
                    </h5>
                </div>
                <div class="cart-body">
                    @foreach($cart as $item)
                    <div class="cart-item" data-id="{{ $item['id'] }}">
                        <div class="item-image">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="img-fluid rounded-3">
                        </div>
                        <div class="item-details">
                            <h6 class="item-name mb-2">{{ $item['name'] }}</h6>
                            <div class="item-price mb-2">
                                <span class="price-label">Đơn giá:</span>
                                <span class="price-value">{{ number_format($item['price'], 0, ',', '.') }} VNĐ</span>
                            </div>
                            <div class="quantity-controls">
                                <label class="quantity-label">Số lượng:</label>
                                <div class="quantity-wrapper">
                                    <button class="quantity-btn decrease" data-action="decrease"
                                        data-id="{{ $item['id'] }}">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" class="quantity-input" value="{{ $item['quantity'] }}"
                                        data-id="{{ $item['id'] }}" min="1">
                                    <button class="quantity-btn increase" data-action="increase"
                                        data-id="{{ $item['id'] }}">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="item-total-section">
                            <div class="item-total-price">
                                <span class="total-label">Thành tiền:</span>
                                <span
                                    class="item-total">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                    VNĐ</span>
                            </div>
                            <button class="remove-btn remove-item" data-id="{{ $item['id'] }}">
                                <i class="fas fa-trash-alt"></i>
                                <span>Xóa</span>
                            </button>
                        </div>
                    </div>
                    @endforeach

                    <div class="cart-actions">
                        <button class="btn-clear-all" id="clear-cart">
                            <i class="fas fa-trash-alt me-2"></i>
                            Xóa tất cả
                        </button>
                        <a href="{{ route('products.all') }}" class="btn-continue-shopping">
                            <i class="fas fa-arrow-left me-2"></i>
                            Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="summary-card">
                <div class="summary-header">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-calculator me-2"></i>
                        Tóm tắt đơn hàng
                    </h5>
                </div>
                <div class="summary-body">
                    <div class="summary-row">
                        <span class="summary-label">Số lượng sản phẩm:</span>
                        <span class="summary-value" id="cart-count">{{ $total_items }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Tạm tính:</span>
                        <span class="summary-value" id="cart-subtotal">{{ number_format($total_amount, 0, ',', '.') }}
                            VNĐ</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Phí vận chuyển:</span>
                        <span class="summary-value text-success">Miễn phí</span>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-total">
                        <span class="total-label">Tổng cộng:</span>
                        <span class="total-value" id="cart-total">{{ number_format($total_amount, 0, ',', '.') }}
                            VNĐ</span>
                    </div>
                    <button type="button" class="btn-checkout"
                        onclick="window.location='{{ route('checkout.index') }}'">
                        <i class="fas fa-credit-card me-2"></i>
                        Tiến hành thanh toán
                    </button>
                    <div class="security-info">
                        <div class="security-item">
                            <i class="fas fa-shield-alt text-success"></i>
                            <span>Thanh toán an toàn 100%</span>
                        </div>
                        <div class="security-item">
                            <i class="fas fa-truck text-primary"></i>
                            <span>Giao hàng miễn phí toàn quốc</span>
                        </div>
                        <div class="security-item">
                            <i class="fas fa-undo text-warning"></i>
                            <span>Đổi trả trong 7 ngày</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    /* Empty Cart Styles */
    .empty-cart-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 60px 20px;
        color: white;
        margin: 20px 0;
    }

    .empty-cart-icon {
        font-size: 5rem;
        opacity: 0.8;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-10px);
        }

        60% {
            transform: translateY(-5px);
        }
    }

    /* Cart Card Styles */
    .cart-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 1px solid #e9ecef;
    }

    .cart-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        border-bottom: none;
    }

    .cart-body {
        padding: 0;
    }

    /* Cart Item Styles */
    .cart-item {
        display: flex;
        align-items: center;
        padding: 25px;
        border-bottom: 1px solid #f1f3f4;
        transition: all 0.3s ease;
        position: relative;
    }

    .cart-item:hover {
        background: #f8f9ff;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .item-image {
        width: 100px;
        height: 100px;
        margin-right: 20px;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .cart-item:hover .item-image img {
        transform: scale(1.05);
    }

    .item-details {
        flex: 1;
        margin-right: 20px;
    }

    .item-name {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        font-size: 1.1rem;
    }

    .item-price {
        margin-bottom: 15px;
    }

    .price-label {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .price-value {
        color: #e74c3c;
        font-weight: 600;
        margin-left: 8px;
    }

    /* Quantity Controls */
    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quantity-label {
        color: #6c757d;
        font-size: 0.9rem;
        margin: 0;
    }

    .quantity-wrapper {
        display: flex;
        align-items: center;
        border: 2px solid #e9ecef;
        border-radius: 25px;
        overflow: hidden;
        background: white;
    }

    .quantity-btn {
        background: #667eea;
        border: none;
        color: white;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .quantity-btn:hover {
        background: #5a6fd8;
        transform: scale(1.1);
    }

    .quantity-input {
        border: none;
        text-align: center;
        width: 50px;
        height: 35px;
        font-weight: 600;
        color: #2c3e50;
        background: transparent;
    }

    .quantity-input:focus {
        outline: none;
        background: #f8f9ff;
    }

    /* Item Total Section */
    .item-total-section {
        display: flex;
        flex-direction: column;
        align-items: end;
        gap: 15px;
    }

    .item-total-price {
        text-align: right;
    }

    .total-label {
        color: #6c757d;
        font-size: 0.9rem;
        display: block;
    }

    .item-total {
        color: #27ae60;
        font-weight: bold;
        font-size: 1.1rem;
    }

    .remove-btn {
        background: #dc3545;
        border: none;
        color: white;
        padding: 8px 15px;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.9rem;
    }

    .remove-btn:hover {
        background: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }

    /* Cart Actions */
    .cart-actions {
        padding: 25px;
        background: #f8f9fa;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .btn-clear-all {
        background: #ffc107;
        border: none;
        color: #212529;
        padding: 12px 25px;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-clear-all:hover {
        background: #e0a800;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(255, 193, 7, 0.3);
    }

    .btn-continue-shopping {
        background: #6c757d;
        color: white;
        text-decoration: none;
        padding: 12px 25px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-continue-shopping:hover {
        background: #5a6268;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);
    }

    /* Summary Card */
    .summary-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 1px solid #e9ecef;
        position: sticky;
        top: 20px;
    }

    .summary-header {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 20px 25px;
    }

    .summary-body {
        padding: 25px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .summary-label {
        color: #6c757d;
        font-weight: 500;
    }

    .summary-value {
        color: #2c3e50;
        font-weight: 600;
    }

    .summary-divider {
        height: 2px;
        background: linear-gradient(to right, #667eea, #764ba2);
        margin: 20px 0;
        border-radius: 1px;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding: 15px;
        background: #f8f9ff;
        border-radius: 10px;
        border: 2px solid #667eea;
    }

    .total-label {
        font-size: 1.1rem;
        font-weight: bold;
        color: #2c3e50;
    }

    .total-value {
        font-size: 1.3rem;
        font-weight: bold;
        color: #e74c3c;
    }

    .btn-checkout {
        width: 100%;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        color: white;
        padding: 15px;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }

    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
    }

    /* Security Info */
    .security-info {
        margin-top: 20px;
    }

    .security-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .security-item i {
        width: 20px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .cart-item {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }

        .item-image {
            margin-right: 0;
        }

        .item-details {
            margin-right: 0;
        }

        .cart-actions {
            flex-direction: column;
            gap: 10px;
        }

        .btn-clear-all,
        .btn-continue-shopping {
            width: 100%;
            text-align: center;
        }
    }

    /* Custom Notifications */
    .custom-notification {
        animation: slideInRight 0.3s ease-out;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>

@endsection
@section('scripts')

<script>
    $(function() {
        // Kiểm tra jQuery
        if (typeof $ === 'undefined') {
            alert('jQuery chưa được load!');
            return;
        }
        // Tăng/giảm số lượng
        $(document).on('click', '.quantity-btn', function() {
            const action = $(this).data('action');
            const id = $(this).data('id');
            const input = $(`.quantity-input[data-id="${id}"]`);
            let quantity = parseInt(input.val());
            if (action === 'increase') quantity++;
            else if (action === 'decrease' && quantity > 1) quantity--;
            input.val(quantity);
            updateCartItem(id, quantity);
        });
        // Thay đổi số lượng trực tiếp
        $(document).on('change', '.quantity-input', function() {
            const id = $(this).data('id');
            const quantity = parseInt($(this).val());
            if (quantity < 1) {
                $(this).val(1);
                return;
            }
            updateCartItem(id, quantity);
        });
        // Xóa sản phẩm (event delegation)
        $(document).on('click', '.remove-item', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                removeCartItem(id);
            }
        });
        // Xóa tất cả (event delegation)
        $(document).on('click', '#clear-cart', function(e) {
            e.preventDefault();
            if (confirm('Bạn có chắc muốn xóa tất cả sản phẩm trong giỏ hàng?')) {
                clearCart();
            }
        });
        // ...giữ nguyên các function updateCartItem, removeCartItem, clearCart, showNotification...
        function updateCartItem(id, quantity) {
            $.ajax({
                url: '/cart/update',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    jewelry_id: id,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        $(`.cart-item[data-id="${id}"] .item-total`).text(response.item_total);
                        $('#cart-count').text(response.cart_count);
                        $('#cart-subtotal').text(response.cart_total);
                        $('#cart-total').text(response.cart_total);
                        $('.cart-badge').text(response.cart_count);
                        showNotification('Cập nhật giỏ hàng thành công!', 'success');
                    } else {
                        showNotification(response.message, 'error');
                        location.reload();
                    }
                },
                error: function() {
                    showNotification('Có lỗi xảy ra, vui lòng thử lại!', 'error');
                    location.reload();
                }
            });
        }

        function removeCartItem(id) {
            $.ajax({
                url: '/cart/remove',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    jewelry_id: id
                },
                success: function(response) {
                    if (response.success) {
                        $(`.cart-item[data-id="${id}"]`).addClass('removing');
                        setTimeout(function() {
                            $(`.cart-item[data-id="${id}"]`).slideUp(300, function() {
                                $(this).remove();
                                if ($('.cart-item').length === 0) location.reload();
                            });
                        }, 200);
                        $('#cart-count').text(response.cart_count);
                        $('#cart-subtotal').text(response.cart_total);
                        $('#cart-total').text(response.cart_total);
                        $('.cart-badge').text(response.cart_count);
                        showNotification(response.message, 'success');
                    } else {
                        showNotification(response.message, 'error');
                    }
                },
                error: function() {
                    showNotification('Có lỗi xảy ra khi xóa sản phẩm!', 'error');
                }
            });
        }

        function clearCart() {
            $.ajax({
                url: '/cart/clear',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        showNotification(response.message, 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        showNotification('Có lỗi xảy ra!', 'error');
                    }
                },
                error: function() {
                    showNotification('Có lỗi xảy ra khi xóa giỏ hàng!', 'error');
                }
            });
        }

        function showNotification(message, type = 'info') {
            $('.custom-notification').remove();
            let bgColor, textColor, icon;
            switch (type) {
                case 'success':
                    bgColor = '#28a745';
                    textColor = '#fff';
                    icon = '✓';
                    break;
                case 'error':
                    bgColor = '#dc3545';
                    textColor = '#fff';
                    icon = '✗';
                    break;
                case 'warning':
                    bgColor = '#ffc107';
                    textColor = '#000';
                    icon = '⚠';
                    break;
                default:
                    bgColor = '#17a2b8';
                    textColor = '#fff';
                    icon = 'ℹ';
            }
            const notificationHtml = `
            <div class="custom-notification" style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${bgColor};
                color: ${textColor};
                padding: 15px 20px;
                border-radius: 10px;
                box-shadow: 0 8px 25px rgba(0,0,0,0.15);
                z-index: 9999;
                max-width: 350px;
                animation: slideInRight 0.3s ease-out;
            ">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 18px; font-weight: bold;">${icon}</span>
                    <span style="flex: 1;">${message}</span>
                    <button onclick="$(this).parent().parent().fadeOut()" style="
                        background: none;
                        border: none;
                        color: ${textColor};
                        font-size: 20px;
                        cursor: pointer;
                        padding: 0;
                        margin-left: 10px;
                    ">×</button>
                </div>
            </div>
        `;
            $('body').append(notificationHtml);
            setTimeout(function() {
                $('.custom-notification').fadeOut(300, function() {
                    $(this).remove();
                });
            }, 4000);
        }
    });
</script>
@endsection