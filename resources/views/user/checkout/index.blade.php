@extends('user.layout')

@section('title', 'Thanh toán')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Thanh toán</h2>

            @if($cartItems->count() > 0)
            <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <!-- Thông tin giao hàng -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Thông tin giao hàng</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="fullname">Họ và tên *</label>
                                            <input type="text" class="form-control" id="fullname" name="fullname"
                                                value="{{ Auth::user()->fullname }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="phone">Số điện thoại *</label>
                                            <input type="tel" class="form-control" id="phone" name="phone"
                                                value="{{ Auth::user()->phone_number }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ Auth::user()->email }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address">Địa chỉ giao hàng *</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" required>{{ Auth::user()->address }}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="note">Ghi chú đơn hàng</label>
                                    <textarea class="form-control" id="note" name="note" rows="2"
                                        placeholder="Ghi chú về đơn hàng của bạn, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Phương thức thanh toán -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Phương thức thanh toán</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                    <label class="form-check-label" for="cod">
                                        <strong>Thanh toán khi nhận hàng (COD)</strong>
                                        <br><small class="text-muted">Bạn sẽ thanh toán khi nhận được hàng</small>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                    <!-- Radio chọn phương thức chuyển khoản -->
<div class="form-check">
 <label class="form-check-label" for="bank_transfer">
    <strong>Chuyển khoản ngân hàng</strong>
    <br><small class="text-muted">Chuyển khoản trực tiếp vào tài khoản ngân hàng của chúng tôi</small>
  </label>
</div>

<!-- Thông tin chuyển khoản ẩn -->
<div id="bank-transfer-info" class="border p-3 mt-2" style="display:none; max-width: 300px;">
 
  <div>
   <img src="https://img.vietqr.io/image/sacombank-070130092398-compact2.png?accountName=PHAM%20MY%20TIEN&amount={{ $total ?? 0 }}&addInfo=Thanh+toan+don+hang+{{ $order->id ?? 'unknown' }}"
     alt="QR chuyển khoản" style="max-width: 200px;">

  </div>
</div>
<script>
    document.getElementById('bank_transfer').addEventListener('change', function() {
  const info = document.getElementById('bank-transfer-info');
  if (this.checked) {
    info.style.display = 'block';
  } else {
    info.style.display = 'none';
  }
});
</script>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Đơn hàng của bạn -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Đơn hàng của bạn</h5>
                            </div>
                            <div class="card-body">
                                @foreach($cartItems as $item)
                                <div class="d-flex justify-content-between mb-2">
                                    <div>
                                        <h6 class="mb-0">{{ $item->jewelry->name }}</h6>
                                        <small class="text-muted">Số lượng: {{ $item->quantity }}</small>
                                    </div>
                                    <span>{{ number_format($item->total, 0, ',', '.') }} VNĐ</span>
                                </div>
                                <hr class="my-2">
                                @endforeach

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tạm tính:</span>
                                    <span>{{ number_format($total, 0, ',', '.') }} VNĐ</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Phí vận chuyển:</span>
                                    <span class="text-success">Miễn phí</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Tổng cộng:</strong>
                                    <strong class="text-primary">{{ number_format($total, 0, ',', '.') }} VNĐ</strong>
                                </div>

                                <button type="submit" class="btn btn-primary w-100" id="place-order-btn">
                                    <i class="fas fa-credit-card"></i> Đặt hàng
                                </button>

                                <div class="mt-3 text-center">
                                    <small class="text-muted">
                                        Thông tin cá nhân của bạn sẽ được sử dụng để xử lý đơn hàng, hỗ trợ trải nghiệm của bạn trên trang web này và cho các mục đích khác được mô tả trong chính sách riêng tư của chúng tôi.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h4>Giỏ hàng của bạn đang trống</h4>
                <p class="text-muted">Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán.</p>
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
        $('#checkout-form').submit(function(e) {
            e.preventDefault();

            const btn = $('#place-order-btn');
            const originalText = btn.html();

            // Disable button và hiển thị loading
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...');

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        alert('Đặt hàng thành công! Cảm ơn bạn đã mua sắm tại cửa hàng.');
                        window.location.href = response.redirect || '{{ route("user.orders.index") }}';
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
    });
</script>
@endsection
