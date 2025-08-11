@extends('user.layout')

@section('title', 'Giỏ hàng')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Giỏ hàng của bạn</h2>

            @if($cartItems->count() > 0)
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            @foreach($cartItems as $item)
                            <div class="cart-item border-bottom py-3" data-jewelry-id="{{ $item->jewelry_id }}">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        @if($item->main_image)
                                        <div class="d-flex align-items-center justify-content-center" style="height: 80px;">
                                            <img src="{{ asset($item->main_image) }}" class="img-fluid rounded border shadow-sm" alt="{{ $item->jewelry->name }}" style="max-height: 70px; max-width: 100%; object-fit: cover;">
                                        </div>
                                        @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center border" style="height: 80px;">
                                            <span class="text-muted">No Image</span>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="mb-1">{{ $item->jewelry->name }}</h6>
                                        <p class="text-muted small mb-0">Mã SP: {{ $item->jewelry->id }}</p>
                                        <p class="text-success mb-0">{{ number_format($item->price, 0, ',', '.') }} VNĐ</p>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group input-group-sm">
                                            <input type="number" class="form-control text-center quantity-input"
                                                value="{{ $item->quantity }}" min="1" max="99">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <strong class="item-total">{{ number_format($item->total, 0, ',', '.') }} VNĐ</strong>
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-sm btn-outline-danger btn-remove"
                                            data-jewelry-id="{{ $item->jewelry_id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-outline-secondary" onclick="history.back()">
                            <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
                        </button>
                        <button class="btn btn-outline-danger ms-2" id="clear-cart">
                            <i class="fas fa-trash"></i> Xóa tất cả
                        </button>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Tóm tắt đơn hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tạm tính:</span>
                                <span id="subtotal">{{ number_format($total, 0, ',', '.') }} VNĐ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Phí vận chuyển:</span>
                                <span class="text-success">Miễn phí</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Tổng cộng:</strong>
                                <strong id="total-amount">{{ number_format($total, 0, ',', '.') }} VNĐ</strong>
                            </div>
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100">
                                Tiến hành thanh toán
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h4>Giỏ hàng của bạn đang trống</h4>
                <p class="text-muted">Hãy thêm một số sản phẩm vào giỏ hàng để bắt đầu mua sắm!</p>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-bag"></i> Tiếp tục mua sắm
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Cập nhật số lượng
        $('.btn-increase').click(function() {
            const $input = $(this).parent().find('.quantity-input');
            let currentVal = parseInt($input.val());
            if (isNaN(currentVal)) currentVal = 1;
            $input.val(currentVal + 1).trigger('change');
        });

        $('.btn-decrease').click(function() {
            const $input = $(this).parent().find('.quantity-input');
            let currentVal = parseInt($input.val());
            if (isNaN(currentVal)) currentVal = 1;
            if (currentVal > 1) {
                $input.val(currentVal - 1).trigger('change');
            }
        });

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
            if (confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm trong giỏ hàng?')) {
                clearCart();
            }
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
                            const price = parseFloat($cartItem.find('.text-success').text().replace(/[^\d]/g, ''));
                            const itemTotal = price * quantity;
                            $cartItem.find('.item-total').text(new Intl.NumberFormat('vi-VN').format(itemTotal) + ' VNĐ');
                        }

                        // Cập nhật tổng tiền
                        $('#subtotal').text(response.cartTotal);
                        $('#total-amount').text(response.cartTotal);

                        // Cập nhật số lượng trong header
                        updateCartCount(response.cartCount);
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Có lỗi xảy ra khi cập nhật giỏ hàng');
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
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Có lỗi xảy ra khi xóa giỏ hàng');
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
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

            if ($('.alert').length > 0) {
                $('.alert').replaceWith(alertHtml);
            } else {
                $('.container').prepend(alertHtml);
            }

            setTimeout(function() {
                $('.alert').fadeOut();
            }, 3000);
        }
    });
</script>
@endsection