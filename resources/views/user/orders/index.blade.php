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
                        chờ xử lý
                        @break
                        @case('hoàn thành')
                        <i class="fas fa-check-circle me-1"></i>
                        hoàn thành
                        @break
                        @case('cancelled')
                        <i class="fas fa-times-circle me-1"></i>
                        đã hủy
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
                  @if($order->status === 'chờ xử lý')
<form action="{{ route('user.orders.cancel', $order->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('PUT')
    <button type="submit" class="btn btn-outline-danger btn-sm" 
            onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">
        <i class="fas fa-times me-1"></i>
        Hủy đơn
    </button>
</form>
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
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

    * {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    body {
        background: linear-gradient(135deg, #ffffff 0%, #f8faff 100%);
        min-height: 100vh;
    }

    .empty-orders-container {
        background: #ffffff;
        border: 2px solid #e3f2fd;
        border-radius: 32px;
        padding: 4rem;
        text-align: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 24px 80px rgba(33, 150, 243, 0.08);
    }

    .empty-orders-container::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(100, 181, 246, 0.03) 0%, transparent 50%);
        animation: rotate 20s linear infinite;
    }

    .empty-orders-icon {
        font-size: 7rem;
        background: linear-gradient(135deg, #1976d2 0%, #64b5f6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        filter: drop-shadow(0 8px 32px rgba(25, 118, 210, 0.2));
        position: relative;
        z-index: 2;
    }

    .order-card {
        background: #ffffff;
        border: 2px solid #e3f2fd;
        border-radius: 28px;
        overflow: hidden;
        margin-bottom: 2rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        box-shadow: 0 12px 48px rgba(33, 150, 243, 0.06);
    }

    .order-card:hover {
        transform: translateY(-12px);
        border-color: #64b5f6;
        box-shadow: 0 32px 80px rgba(33, 150, 243, 0.15);
    }

    .order-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #1976d2 0%, #64b5f6 50%, #90caf9 100%);
    }

    .order-header {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 2rem;
        padding: 2.5rem;
        background: linear-gradient(135deg, #fafbff 0%, #f3f8ff 100%);
        position: relative;
    }

    .order-header-left h3 {
        color: #1565c0;
        font-weight: 900;
        font-size: 1.8rem;
        margin: 0 0 0.5rem 0;
        letter-spacing: -0.02em;
    }

    .order-date {
        color: #546e7a;
        font-size: 1.2rem;
        font-weight: 600;
    }
.status-badge {
    padding: 1rem 2rem;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: inline-flex;
    align-items: center;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    border: none;
    
    background-color: #ff7700; /* Đỏ */
    color: #fff; /* Chữ trắng */
}


    .status-pending {
        background: linear-gradient(135deg, #ff9800 0%, #ffb74d 100%);
        color: #ffffff;
        box-shadow: 0 8px 24px rgba(255, 152, 0, 0.3);
    }

    .status-hoàn.thành {
        background: linear-gradient(135deg, #4caf50 0%, #66bb6a 100%);
        color: #2ee82e;
        box-shadow: 0 8px 24px rgba(76, 175, 80, 0.3);
    }

    .status-cancelled {
        background: linear-gradient(135deg, #f44336 0%, #ef5350 100%);
        color: #780e48;
        box-shadow: 0 8px 24px rgba(244, 67, 54, 0.3);
    }

    .order-body {
        padding: 2.5rem;
        background: #ffffff;
    }

    .order-item {
        display: grid;
        grid-template-columns: 120px 1fr auto;
        gap: 2rem;
        align-items: center;
        padding: 2rem 0;
        border-bottom: 2px solid #f5f8ff;
        transition: all 0.3s ease;
    }

    .order-item:hover {
        background: linear-gradient(135deg, #fafbff 0%, transparent 100%);
        border-radius: 16px;
        padding: 2rem 1rem;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .item-image {
        width: 120px;
        height: 120px;
        border-radius: 20px;
        overflow: hidden;
        border: 3px solid #e3f2fd;
        box-shadow: 0 12px 32px rgba(33, 150, 243, 0.08);
        transition: all 0.3s ease;
    }

    .item-image:hover {
        border-color: #64b5f6;
        transform: scale(1.05);
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-info h4 {
        font-weight: 800;
        font-size: 1.5rem;
        color: #1565c0;
        margin: 0 0 1rem 0;
        line-height: 1.3;
    }

    .item-details {
        font-size: 1.2rem;
        color: #546e7a;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .item-price {
        font-size: 1.1rem;
        color: #757575;
        font-weight: 600;
    }

    .item-total {
        font-size: 1.8rem;
        font-weight: 900;
        background: linear-gradient(135deg, #1976d2 0%, #64b5f6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-align: right;
    }

    .order-footer {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 2rem;
        align-items: center;
        padding: 2.5rem;
        background: linear-gradient(135deg, #f8faff 0%, #e8f4fd 100%);
        border-top: 2px solid #e3f2fd;
    }

    .total-amount {
        font-size: 2.2rem;
        font-weight: 900;
        background: linear-gradient(135deg, #1976d2 0%, #64b5f6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .order-actions {
        display: flex;
        gap: 1.5rem;
    }

    .btn-sm {
        padding: 1.2rem 2.5rem;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .btn-primary {
        background: linear-gradient(135deg, #1976d2 0%, #64b5f6 100%);
        color: white;
        box-shadow: 0 8px 24px rgba(25, 118, 210, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(25, 118, 210, 0.4);
    }

    .btn-secondary {
        background: #ffffff;
        color: #1976d2;
        border: 2px solid #e3f2fd;
        box-shadow: 0 8px 24px rgba(33, 150, 243, 0.08);
    }

    .btn-secondary:hover {
        transform: translateY(-4px);
        border-color: #64b5f6;
        box-shadow: 0 16px 40px rgba(33, 150, 243, 0.15);
    }

    /* Floating Action Button Style */
    .fab-container {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        z-index: 1000;
    }

    .fab {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1976d2 0%, #64b5f6 100%);
        color: white;
        border: none;
        font-size: 1.5rem;
        box-shadow: 0 8px 24px rgba(25, 118, 210, 0.3);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .fab:hover {
        transform: scale(1.1);
        box-shadow: 0 12px 32px rgba(25, 118, 210, 0.4);
    }

    /* Modern Card Layout Alternative */
    .modern-card-layout {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 2rem;
        margin: 2rem 0;
    }

    @keyframes rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }

    @media (max-width: 768px) {
        .order-header {
            grid-template-columns: 1fr;
            gap: 1.5rem;
            padding: 2rem;
        }

        .order-footer {
            grid-template-columns: 1fr;
            gap: 1.5rem;
            text-align: center;
        }

        .order-item {
            grid-template-columns: 1fr;
            gap: 1.5rem;
            text-align: center;
        }

        .item-image {
            justify-self: center;
        }

        .item-total {
            text-align: center;
        }

        .order-actions {
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-sm {
            flex: 1;
            min-width: 140px;
        }

        .modern-card-layout {
            grid-template-columns: 1fr;
        }
    }

    /* Glassmorphism effect */
    .glass-effect {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Hover glow effect */
    .glow-on-hover {
        position: relative;
    }

    .glow-on-hover::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: inherit;
        padding: 2px;
        background: linear-gradient(135deg, #1976d2, #64b5f6, #90caf9);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: exclude;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .glow-on-hover:hover::before {
        opacity: 1;
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
