@extends('user.layout')
@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="container mt-4">
    <div class="d-flex align-items-center mb-4">
        <h2 class="mb-0 fw-bold text-dark">
            <i class="fas fa-shopping-bag me-2 text-primary"></i>
            Đơn hàng của tôi
        </h2>
    </div>

    @if($orders->isEmpty())
    <div class="empty-orders-container">
        <div class="text-center py-5">
            <div class="empty-orders-icon mb-4">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <h3 class="mb-3 text-dark fw-bold">Chưa có đơn hàng nào</h3>
            <p class="text-muted mb-4 fs-5">Hãy khám phá và đặt mua các sản phẩm tuyệt vời của chúng tôi</p>
            <a href="{{ route('home') }}" class="btn btn-primary btn-lg px-4 py-2 rounded-pill">
                <i class="fas fa-shopping-cart me-2"></i>
                Mua sắm ngay
            </a>
        </div>
    </div>
    @else
    <div class="orders-container">
        @foreach($orders as $order)
        <div class="order-card mb-4">
            <div class="order-header">
                <div class="order-info">
                    <h5 class="order-id mb-1">
                        <i class="fas fa-receipt me-2"></i>
                        Đơn hàng #{{ $order->id }}
                    </h5>
                    <p class="order-date mb-0 text-muted">
                        <i class="far fa-calendar me-1"></i>
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
                <div class="order-status">
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
                </div>
            </div>

            <div class="order-body">
                <div class="order-items">
                    @foreach($order->orderDetails as $detail)
                    <div class="order-item">
                        <div class="item-image">
                            @if($detail->jewelry)
                            <img src="{{ \App\Helpers\ImageHelper::getMainImage($detail->jewelry) }}"
                                alt="{{ $detail->jewelry->name }}"
                                class="product-image">
                            @else
                            <img src="{{ asset('images/no-image.jpg') }}"
                                alt="Không có hình"
                                class="product-image">
                            @endif
                        </div>
                        <div class="item-info">
                            <h6 class="item-name">{{ $detail->jewelry->name ?? 'Sản phẩm không tồn tại' }}</h6>
                            <p class="item-details mb-1">
                                <span class="text-muted">Số lượng:</span> {{ $detail->quantity }}
                            </p>
                            <p class="item-price mb-0">
                                <span class="text-muted">Đơn giá:</span>
                                <strong>{{ number_format($detail->unit_price, 0, ',', '.') }}₫</strong>
                            </p>
                        </div>
                        <div class="item-total">
                            <strong>{{ number_format($detail->unit_price * $detail->quantity, 0, ',', '.') }}₫</strong>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="order-footer">
                <div class="order-total">
                    <strong class="total-label">Tổng tiền: </strong>
                    <strong class="total-amount">{{ number_format($order->total_amount, 0, ',', '.') }}₫</strong>
                </div>
                <div class="order-actions">
                    <a href="{{ route('user.orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye me-1"></i>
                        Xem chi tiết
                    </a>
                    @if($order->status === 'pending')
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="cancelOrder({{ $order->id }})">
                        <i class="fas fa-times me-1"></i>
                        Hủy đơn
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    </div>
    @endif
</div>

<style>
    .empty-orders-container {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%);
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .empty-orders-icon {
        font-size: 5rem;
        color: #6c757d;
        opacity: 0.7;
    }

    .order-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .order-card:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #dee2e6;
    }

    .order-id {
        color: #495057;
        font-weight: 600;
    }

    .order-date {
        font-size: 0.9rem;
    }

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

    .order-body {
        padding: 1.5rem;
    }

    .order-item {
        display: flex;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f1f3f4;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .item-image {
        width: 80px;
        height: 80px;
        margin-right: 1rem;
        border-radius: 8px;
        overflow: hidden;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-info {
        flex: 1;
    }

    .item-name {
        font-weight: 600;
        color: #343a40;
        margin-bottom: 0.5rem;
    }

    .item-details,
    .item-price {
        font-size: 0.9rem;
    }

    .item-total {
        font-size: 1.1rem;
        font-weight: 600;
        color: #dc3545;
    }

    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }

    .total-amount {
        color: #dc3545;
        font-size: 1.2rem;
    }

    .order-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
    }

    @media (max-width: 768px) {
        .order-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .order-footer {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .order-item {
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }

        .item-image {
            margin-right: 0;
            margin-bottom: 1rem;
        }
    }
</style>

<script>
    function cancelOrder(orderId) {
        if (confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')) {
            // Implement cancel order logic here
            alert('Tính năng hủy đơn hàng đang được phát triển');
        }
    }
</script>
@endsection