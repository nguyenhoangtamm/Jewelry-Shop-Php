@extends('user.layout')

@section('title', 'Giỏ hàng')

@section('content')
<style>
:root {
    --galaxy-blue: #1e3a8a;
    --galaxy-blue-light: #3b82f6;
    --galaxy-blue-dark: #1e40af;
    --galaxy-gradient: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    --shadow-soft: 0 8px 25px rgba(30, 58, 138, 0.15);
    --shadow-hover: 0 12px 35px rgba(30, 58, 138, 0.25);
    --border-radius: 16px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
}

.modern-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-soft);
    padding: 2rem;
    margin: 2rem auto;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 800;
    background: var(--galaxy-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 2rem;
    text-align: center;
}

.cart-card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-soft);
    border: none;
    overflow: hidden;
    transition: var(--transition);
}

.cart-card:hover {
    box-shadow: var(--shadow-hover);
    transform: translateY(-2px);
}

.cart-item {
    padding: 1.5rem;
    transition: var(--transition);
    border-bottom: 1px solid rgba(30, 58, 138, 0.1);
}

.cart-item:hover {
    background: rgba(30, 58, 138, 0.02);
}

.product-image {
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: var(--transition);
    overflow: hidden;
    cursor: pointer;
    position: relative;
}

.product-image:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

.product-checkbox {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: var(--galaxy-blue);
}

.product-checkbox:checked {
    transform: scale(1.1);
}

.cart-item.selected {
    background: rgba(30, 58, 138, 0.05);
    border-left: 4px solid var(--galaxy-blue);
}

.select-all-container {
    background: white;
    padding: 1rem 1.5rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-soft);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.select-all-checkbox {
    width: 18px;
    height: 18px;
    accent-color: var(--galaxy-blue);
    cursor: pointer;
}

.select-all-label {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2d3748;
    cursor: pointer;
    margin: 0;
}

.selected-count {
    margin-left: auto;
    padding: 0.25rem 0.75rem;
    background: var(--galaxy-gradient);
    color: white;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
}

/* Image Modal Styles */
.image-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.9);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(5px);
}

.image-modal img {
    max-width: 90%;
    max-height: 90%;
    border-radius: 12px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
}

.image-modal .close-modal {
    position: absolute;
    top: 20px;
    right: 20px;
    color: white;
    font-size: 2rem;
    cursor: pointer;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
}

.image-modal .close-modal:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}

.product-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.product-code {
    font-size: 0.95rem;
    color: #718096;
    margin-bottom: 0.5rem;
}

.product-price {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--galaxy-blue);
    margin-bottom: 0;
}

.quantity-controls {
    background: white;
    border: 2px solid rgba(30, 58, 138, 0.2);
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    align-items: center;
}

.quantity-input {
    border: none;
    text-align: center;
    font-size: 1.1rem;
    font-weight: 600;
    padding: 0.75rem;
    background: transparent;
    color: #2d3748;
}

.quantity-input:focus {
    outline: none;
    box-shadow: none;
}

.item-total {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2d3748;
}

.btn-modern {
    border-radius: 12px;
    font-weight: 600;
    font-size: 1.05rem;
    padding: 0.75rem 1.5rem;
    transition: var(--transition);
    border: none;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary-modern {
    background: var(--galaxy-gradient);
    color: white;
    box-shadow: var(--shadow-soft);
}

.btn-primary-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
    color: white;
}

.btn-outline-modern {
    background: white;
    color: var(--galaxy-blue);
    border: 2px solid var(--galaxy-blue);
}

.btn-outline-modern:hover {
    background: var(--galaxy-blue);
    color: white;
    transform: translateY(-1px);
}

.btn-danger-modern {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
    color: white;
    border-radius: 50%;
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
}

.btn-danger-modern:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(238, 90, 82, 0.4);
    color: white;
}

.summary-card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-soft);
    border: none;
    position: sticky;
    top: 2rem;
}

.summary-header {
    background: var(--galaxy-gradient);
    color: white;
    padding: 1.5rem;
    font-size: 1.3rem;
    font-weight: 700;
    border-radius: var(--border-radius) var(--border-radius) 0 0;
    margin: -1px -1px 0 -1px;
}

.summary-body {
    padding: 2rem;
}

.summary-row {
    display: flex;
    justify-content: between;
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.summary-row span:first-child {
    color: #718096;
}

.summary-row span:last-child {
    font-weight: 600;
    color: #2d3748;
}

.summary-total {
    border-top: 2px solid rgba(30, 58, 138, 0.1);
    padding-top: 1rem;
    margin-top: 1rem;
}

.summary-total span {
    font-size: 1.4rem;
    font-weight: 800;
    color: #2d3748;
}

.empty-cart {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-soft);
}

.empty-cart-icon {
    font-size: 4rem;
    color: var(--galaxy-blue);
    margin-bottom: 1.5rem;
    opacity: 0.7;
}

.empty-cart h4 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 1rem;
}

.empty-cart p {
    font-size: 1.1rem;
    color: #718096;
    margin-bottom: 2rem;
}

.action-buttons {
    margin-top: 2rem;
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.icon-large {
    font-size: 1.2rem;
}

@media (max-width: 768px) {
    .modern-container {
        margin: 1rem;
        padding: 1rem;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-modern {
        justify-content: center;
    }
}
</style>

<div class="container-fluid">
    <div class="modern-container">
        <h1 class="page-title">
            <i class="fas fa-shopping-cart me-3"></i>
            Giỏ hàng của bạn
        </h1>

        @if($cartItems->count() > 0)
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="select-all-container">
                    <input type="checkbox" id="select-all" class="select-all-checkbox">
                    <label for="select-all" class="select-all-label">
                        <i class="fas fa-check-circle me-2"></i>
                        Chọn tất cả sản phẩm
                    </label>
                    <span class="selected-count">
                        <span id="selected-count">0</span> được chọn
                    </span>
                </div>

                <div class="cart-card">
                    <div class="card-body p-0">
                        @foreach($cartItems as $item)
                        <div class="cart-item" data-jewelry-id="{{ $item->jewelry_id }}" data-price="{{ $item->price }}" data-quantity="{{ $item->quantity }}">
                            <div class="row align-items-center g-3">
                                <div class="col-md-1 col-2">
                                    <input type="checkbox" class="product-checkbox" 
                                           data-jewelry-id="{{ $item->jewelry_id }}"
                                           data-price="{{ $item->total }}">
                                </div>
                                <div class="col-md-2 col-4">
                                    @if($item->main_image)
                                    <div class="product-image" style="height: 90px; overflow: hidden;"
                                         onclick="showImageModal('{{ asset($item->main_image) }}', '{{ $item->jewelry->name }}')">
                                        <img src="{{ asset($item->main_image) }}"
                                            class="img-fluid w-100 h-100"
                                            alt="{{ $item->jewelry->name }}"
                                            style="object-fit: cover;">
                                    </div>
                                    @else
                                    <div class="product-image bg-light d-flex align-items-center justify-content-center"
                                        style="height: 90px;">
                                        <i class="fas fa-image text-muted fa-2x"></i>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-3 col-8">
                                    <h6 class="product-title">{{ $item->jewelry->name }}</h6>
                                    <p class="product-code">
                                        <i class="fas fa-tag me-1"></i>
                                        Mã SP: {{ $item->jewelry->id }}
                                    </p>
                                    <p class="product-price">
                                        <i class="fas fa-coins me-1"></i>
                                        {{ number_format($item->price, 0, ',', '.') }} VNĐ
                                    </p>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="quantity-controls">
                                        <input type="number" class="form-control quantity-input"
                                            value="{{ $item->quantity }}" min="1" max="99">
                                    </div>
                                </div>
                                <div class="col-md-2 col-4">
                                    <div class="item-total">{{ number_format($item->total, 0, ',', '.') }} VNĐ</div>
                                </div>
                                <div class="col-md-1 col-2">
                                    <button class="btn btn-danger-modern btn-remove"
                                        data-jewelry-id="{{ $item->jewelry_id }}"
                                        title="Xóa sản phẩm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="action-buttons">
                    <button class="btn btn-outline-modern" onclick="history.back()">
                        <i class="fas fa-arrow-left icon-large"></i>
                        Tiếp tục mua sắm
                    </button>
                    <button class="btn btn-outline-modern" id="clear-cart" style="border-color: #ff6b6b; color: #ff6b6b;">
                        <i class="fas fa-trash-alt icon-large"></i>
                        Xóa tất cả
                    </button>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="summary-card">
                    <div class="summary-header">
                        <i class="fas fa-calculator me-2"></i>
                        Tóm tắt đơn hàng
                    </div>
                    <div class="summary-body">
                        <div class="summary-row">
                            <span>Sản phẩm đã chọn:</span>
                            <span id="selected-items-count">0 sản phẩm</span>
                        </div>
                        <div class="summary-row">
                            <span>Tạm tính:</span>
                            <span id="subtotal">0 VNĐ</span>
                        </div>
                        <div class="summary-row">
                            <span>Phí vận chuyển:</span>
                            <span style="color: #48bb78;">
                                <i class="fas fa-gift me-1"></i>
                                Miễn phí
                            </span>
                        </div>
                        <div class="summary-row summary-total">
                            <span>Tổng cộng:</span>
                            <span id="total-amount">0 VNĐ</span>
                        </div>
                      <form id="checkout-form" action="{{ route('checkout.index') }}" method="GET">
    <input type="hidden" name="selected_items" id="selected-items-input">
    <button type="submit" class="btn btn-primary-modern w-100 mt-3" id="checkout-btn" disabled>
        <i class="fas fa-credit-card icon-large"></i>
        Thanh toán (<span id="checkout-count">0</span> sản phẩm)
    </button>
</form>

                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="empty-cart">
            <div class="empty-cart-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h4>Giỏ hàng của bạn đang trống</h4>
            <p>Hãy thêm một số sản phẩm vào giỏ hàng để bắt đầu mua sắm!</p>
            <a href="{{ route('home') }}" class="btn btn-primary-modern">
                <i class="fas fa-shopping-bag icon-large"></i>
                Khám phá sản phẩm
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Image Modal -->
<div class="image-modal" id="imageModal">
    <div class="close-modal" onclick="closeImageModal()">
        <i class="fas fa-times"></i>
    </div>
    <img id="modalImage" src="" alt="">
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
    // Chọn tất cả
    $('#select-all').on('change', function () {
        const isChecked = $(this).prop('checked');
        $('.product-checkbox').prop('checked', isChecked).trigger('change');
    });

    // Khi tick / bỏ tick từng sản phẩm
    $('.product-checkbox').on('change', function () {
        updateSummary();
    });

    function updateSummary() {
        let selectedCount = 0;
        let totalAmount = 0;

        $('.product-checkbox:checked').each(function () {
            selectedCount++;
            totalAmount += parseFloat($(this).data('price'));
        });

        // Cập nhật số đã chọn
        $('#selected-count').text(selectedCount);
        $('#selected-items-count').text(selectedCount + ' sản phẩm');

        // Cập nhật tạm tính & tổng cộng
        $('#subtotal').text(new Intl.NumberFormat('vi-VN').format(totalAmount) + ' VNĐ');
        $('#total-amount').text(new Intl.NumberFormat('vi-VN').format(totalAmount) + ' VNĐ');

        // Cập nhật nút thanh toán
        $('#checkout-count').text(selectedCount);
        $('#checkout-btn').prop('disabled', selectedCount === 0);
    }
});


$(document).ready(function() {
    // Cập nhật số lượng
    $('.quantity-input').change(function() {
        const value = parseInt($(this).val());
        if (value < 1) {
            $(this).val(1);
        }
        updateQuantity($(this).closest('.cart-item'));
    });

    // Xóa sản phẩm
    $('.btn-remove').click(function() {
        const jewelryId = $(this).data('jewelry-id');
        removeFromCart(jewelryId);
    });

    // Xóa tất cả
    $('#clear-cart').click(function() {
        Swal.fire({
            title: 'Xác nhận xóa',
            text: 'Bạn có chắc chắn muốn xóa tất cả sản phẩm trong giỏ hàng?',
            icon: 'warning',
            showCancelButton: true,
                            confirmButtonColor: '#1e3a8a',
            cancelButtonColor: '#ff6b6b',
            confirmButtonText: 'Xóa tất cả',
            cancelButtonText: 'Hủy bỏ'
        }).then((result) => {
            if (result.isConfirmed) {
                clearCart();
            }
        });
    });

    function updateQuantity($cartItem) {
        const jewelryId = $cartItem.data('jewelry-id');
        const quantity = $cartItem.find('.quantity-input').val();

        $.ajax({
            url: '{{ route("cart.update") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                jewelry_id: jewelryId,
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    if (quantity == 0) {
                        $cartItem.fadeOut(function() {
                            $(this).remove();
                            checkEmptyCart();
                        });
                    } else {
                        // Cập nhật tổng tiền cho item
                        const price = parseFloat($cartItem.find('.product-price').text().replace(/[^\d]/g, ''));
                        const itemTotal = price * quantity;
                        $cartItem.find('.item-total').text(new Intl.NumberFormat('vi-VN').format(itemTotal) + ' VNĐ');
                    }

                    // Cập nhật tổng tiền
                    $('#subtotal').text(response.cartTotal);
                    $('#total-amount').text(response.cartTotal);

                    // Cập nhật số lượng trong header
                    updateCartCount(response.cartCount);
                } else {
                    showAlert(response.message, 'error');
                }
            },
            error: function() {
                showAlert('Có lỗi xảy ra khi cập nhật giỏ hàng', 'error');
            }
        });
    }

    function removeFromCart(jewelryId) {
        $.ajax({
            url: '{{ route("cart.remove") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                jewelry_id: jewelryId
            },
            success: function(response) {
                if (response.success) {
                    $('[data-jewelry-id="' + jewelryId + '"]').fadeOut(function() {
                        $(this).remove();
                        checkEmptyCart();
                    });

                    // Cập nhật tổng tiền
                    $('#subtotal').text(response.cartTotal);
                    $('#total-amount').text(response.cartTotal);

                    // Cập nhật số lượng trong header
                    updateCartCount(response.cartCount);

                    showAlert(response.message, 'success');
                } else {
                    showAlert(response.message, 'error');
                }
            },
            error: function() {
                showAlert('Có lỗi xảy ra khi xóa sản phẩm', 'error');
            }
        });
    }

    function clearCart() {
        $.ajax({
            url: '{{ route("cart.clear") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    showAlert(response.message, 'error');
                }
            },
            error: function() {
                showAlert('Có lỗi xảy ra khi xóa giỏ hàng', 'error');
            }
        });
    }

    function checkEmptyCart() {
        if ($('.cart-item').length === 0) {
            location.reload();
        }
    }

    function updateCartCount(count) {
        $('.cart-count').text(count);
    }

    function showAlert(message, type) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: type === 'success' ? 'Thành công!' : 'Lỗi!',
                text: message,
                icon: type,
                confirmButtonColor: '#1e3a8a',
                timer: 3000
            });
        } else {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert" style="border-radius: 12px;">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;

            if ($('.alert').length > 0) {
                $('.alert').replaceWith(alertHtml);
            } else {
                $('.modern-container').prepend(alertHtml);
            }

            setTimeout(function() {
                $('.alert').fadeOut();
            }, 3000);
        }
    }
});
</script>
@endsection
