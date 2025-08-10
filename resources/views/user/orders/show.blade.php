@extends('user.layout')
@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container mt-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('user.orders.index') }}" class="btn btn-outline-secondary me-3">
            <i class="fas fa-arrow-left me-1"></i>
            Quay lại
        </a>
        <h2 class="mb-0 fw-bold text-dark">
            <i class="fas fa-receipt me-2 text-primary"></i>
            Chi tiết đơn hàng #{{ $order->id }}
        </h2>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Order Information -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Thông tin đơn hàng
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Mã đơn hàng:</strong> #{{ $order->id }}</p>
                            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Trạng thái:</strong>
                                <span class="status-badge status-{{ strtolower($order->status) }}">
                                    @switch($order->status)
                                    @case('pending')
                                    <i class="fas fa-clock me-1"></i>
                                    Chờ xử lý
                                    @break
                                    @case('hoàn thành')
                                    <i class="fas fa-check-circle me-1"></i>
                                    Hoàn thành
                                    @break
                                    @case('cancelled')
                                    <i class="fas fa-times-circle me-1"></i>
                                    Đã hủy
                                    @break
                                    @default
                                    {{ ucfirst($order->status) }}
                                    @endswitch
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tổng tiền:</strong>
                                <span class="text-danger fw-bold fs-5">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
                            </p>
                        </div>
                    </div>

                    @if($order->notes)
                    <div class="mt-3">
                        <h6><strong>Ghi chú đơn hàng:</strong></h6>
                        <div class="notes-content">
                            {!! nl2br(e($order->notes)) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-box me-2"></i>
                        Sản phẩm đã đặt
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $detail)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="product-image me-3">
                                                @if($detail->jewelry)
                                                <img src="{{ \App\Helpers\ImageHelper::getMainImage($detail->jewelry) }}"
                                                    alt="{{ $detail->jewelry->name }}"
                                                    class="img-thumbnail">
                                                @else
                                                <img src="{{ asset('images/no-image.jpg') }}"
                                                    alt="Không có hình"
                                                    class="img-thumbnail">
                                                @endif
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ $detail->jewelry->name ?? 'Sản phẩm không tồn tại' }}</h6>
                                                @if($detail->jewelry)
                                                <small class="text-muted">Mã: {{ $detail->jewelry->id }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge bg-primary rounded-pill">{{ $detail->quantity }}</span>
                                    </td>
                                    <td class="align-middle">
                                        {{ number_format($detail->unit_price, 0, ',', '.') }}₫
                                    </td>
                                    <td class="align-middle">
                                        <strong class="text-danger">
                                            {{ number_format($detail->unit_price * $detail->quantity, 0, ',', '.') }}₫
                                        </strong>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="3" class="text-end">Tổng cộng:</th>
                                    <th class="text-danger">
                                        {{ number_format($order->total_amount, 0, ',', '.') }}₫
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Order Status Timeline -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>
                        Trạng thái đơn hàng
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item {{ $order->status === 'pending' ? 'active' : 'completed' }}">
                            <div class="timeline-marker">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Đơn hàng đã được đặt</h6>
                                <small>{{ $order->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>

                        @if($order->status === 'hoàn thành')
                        <div class="timeline-item completed">
                            <div class="timeline-marker">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Đơn hàng đã hoàn thành</h6>
                                <small>{{ $order->updated_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                        @endif

                        @if($order->status === 'cancelled')
                        <div class="timeline-item cancelled">
                            <div class="timeline-marker">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Đơn hàng đã bị hủy</h6>
                                <small>{{ $order->updated_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-cogs me-2"></i>
                        Hành động
                    </h5>
                </div>
                <div class="card-body">
                    @if($order->status === 'pending')
                    <button type="button" class="btn btn-danger w-100 mb-2" onclick="cancelOrder()">
                        <i class="fas fa-times me-2"></i>
                        Hủy đơn hàng
                    </button>
                    @endif

                    <a href="{{ route('user.orders.index') }}" class="btn btn-secondary w-100 mb-2">
                        <i class="fas fa-list me-2"></i>
                        Xem tất cả đơn hàng
                    </a>

                    <a href="{{ route('home') }}" class="btn btn-primary w-100">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Tiếp tục mua sắm
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .status-hoàn.thành {
        background: #d1edff;
        color: #0c5460;
        border: 1px solid #b8daff;
    }

    .status-cancelled {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .product-image img {
        width: 60px;
        height: 60px;
        object-fit: cover;
    }

    .notes-content {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        border-left: 4px solid #007bff;
    }

    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 0.9rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #dee2e6;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
    }

    .timeline-marker {
        position: absolute;
        left: -2.2rem;
        width: 2.5rem;
        height: 2.5rem;
        background: #6c757d;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
    }

    .timeline-item.active .timeline-marker {
        background: #ffc107;
        color: #000;
    }

    .timeline-item.completed .timeline-marker {
        background: #28a745;
    }

    .timeline-item.cancelled .timeline-marker {
        background: #dc3545;
    }

    .timeline-content h6 {
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .timeline-content small {
        color: #6c757d;
    }
</style>

<script>
    function cancelOrder() {
        if (confirm('Bạn có chắc chắn muốn hủy đơn hàng này? Hành động này không thể hoàn tác.')) {
            // Implement cancel order logic here
            alert('Tính năng hủy đơn hàng đang được phát triển');
        }
    }
</script>
@endsection