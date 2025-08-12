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
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;700&display=swap');

    * {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    :root {
        --galaxy-primary: #1976d2;
        --galaxy-secondary: #64b5f6;
        --galaxy-light: #90caf9;
        --galaxy-ultra-light: #e3f2fd;
        --galaxy-dark: #0d47a1;
        --text-primary: #1565c0;
        --text-secondary: #546e7a;
        --surface: #ffffff;
        --surface-variant: #f8faff;
    }

    body {
        background: linear-gradient(135deg, #ffffff 0%, #f8faff 30%, #e8f4fd 100%);
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
    }

    body::before {
        content: '';
        position: fixed;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: 
            radial-gradient(circle at 20% 30%, rgba(25, 118, 210, 0.03) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(100, 181, 246, 0.03) 0%, transparent 50%),
            radial-gradient(circle at 40% 80%, rgba(144, 202, 249, 0.02) 0%, transparent 50%);
        animation: floatingBackground 30s ease-in-out infinite alternate;
        z-index: -1;
    }

    /* Ultra Premium Status Badges */
 .status-badge {
    padding: 1rem 2rem;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    border: none;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;

   background-color: #ff7700; /* Đỏ */
    color: #fff; /* Chữ trắng */
}

    .status-badge::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
        transition: left 0.6s ease;
    }

    .status-badge:hover::before {
        left: 100%;
    }

    .status-badge::after {
        position: absolute;
        inset: 2px;
        border-radius: inherit;
        background: inherit;
        opacity: 0.1;
        z-index: -1;
    }

    .status-pending {
        background: linear-gradient(135deg, #ff6b35 0%, #ff8f65 50%, #ffad94 100%);
        color: #ffffff;
        box-shadow: 
            0 12px 40px rgba(255, 107, 53, 0.4),
            0 0 0 1px rgba(255, 255, 255, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .status-pending::after {
        content: '⏳';
        font-size: 1.2rem;
        filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.5));
    }

    .status-hoàn\.thành {
        background: linear-gradient(135deg, #00c851 0%, #00ff7f 50%, #7fffd4 100%);
        color: #ffffff;
        box-shadow: 
            0 12px 40px rgba(0, 200, 81, 0.4),
            0 0 0 1px rgba(255, 255, 255, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .status-hoàn\.thành::after {
        content: '✨';
        font-size: 1.2rem;
        filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.5));
    }

    .status-cancelled {
        background: linear-gradient(135deg, #ff4757 0%, #ff6b7d 50%, #ffa8b4 100%);
        color: #ffffff;
        box-shadow: 
            0 12px 40px rgba(255, 71, 87, 0.4),
            0 0 0 1px rgba(255, 255, 255, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .status-cancelled::after {
        content: '💥';
        font-size: 1.2rem;
        filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.5));
    }

    /* Premium Product Image */
    .product-image {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        border: 3px solid var(--galaxy-ultra-light);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        background: var(--surface);
        cursor: pointer;
    }

    .product-image::before {
        content: '';
        position: absolute;
        inset: -3px;
        background: linear-gradient(45deg, var(--galaxy-primary), var(--galaxy-secondary), var(--galaxy-light), var(--galaxy-primary));
        background-size: 300% 300%;
        border-radius: 27px;
        opacity: 0;
        transition: opacity 0.5s ease;
        animation: gradientRotate 3s ease-in-out infinite;
        z-index: -1;
    }

    .product-image:hover::before {
        opacity: 1;
    }

    .product-image:hover {
        transform: scale(1.08) rotate(1deg);
        box-shadow: 
            0 25px 60px rgba(25, 118, 210, 0.25),
            0 0 0 1px rgba(255, 255, 255, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    .product-image img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        transition: all 0.5s ease;
        filter: contrast(1.1) saturate(1.1);
    }

    .product-image:hover img {
        transform: scale(1.15);
        filter: contrast(1.2) saturate(1.3) brightness(1.1);
    }

    .product-image::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(25, 118, 210, 0.1) 0%, transparent 50%, rgba(100, 181, 246, 0.1) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        mix-blend-mode: overlay;
    }

    .product-image:hover::after {
        opacity: 1;
    }

    /* Luxury Notes Content */
    .notes-content {
        background: var(--surface);
        padding: 2.5rem;
        border-radius: 32px;
        border: 2px solid var(--galaxy-ultra-light);
        position: relative;
        margin: 3rem 0;
        transition: all 0.4s ease;
        backdrop-filter: blur(20px);
        overflow: hidden;
    }

    .notes-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 8px;
        height: 100%;
        background: linear-gradient(180deg, var(--galaxy-primary) 0%, var(--galaxy-secondary) 50%, var(--galaxy-light) 100%);
        border-radius: 0 4px 4px 0;
    }

    .notes-content::after {
        content: '📋';
        position: absolute;
        top: 2rem;
        right: 2rem;
        font-size: 2rem;
        opacity: 0.3;
        transition: all 0.3s ease;
    }

    .notes-content:hover {
        transform: translateY(-8px) scale(1.02);
        border-color: var(--galaxy-secondary);
        box-shadow: 
            0 25px 60px rgba(25, 118, 210, 0.15),
            0 0 0 1px rgba(255, 255, 255, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    .notes-content:hover::after {
        opacity: 0.8;
        transform: scale(1.1) rotate(5deg);
    }

    .notes-content h5 {
        color: var(--text-primary);
        font-weight: 900;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        background: linear-gradient(135deg, var(--galaxy-primary) 0%, var(--galaxy-secondary) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        position: relative;
    }

    .notes-content h5::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, var(--galaxy-primary), var(--galaxy-secondary));
        border-radius: 2px;
    }

    .notes-content p {
        color: var(--text-secondary);
        font-size: 1.2rem;
        line-height: 1.8;
        margin: 0;
        font-weight: 500;
    }

    /* Ultra Luxury Timeline */
    .timeline {
        position: relative;
        padding: 3rem 0 3rem 5rem;
        margin: 4rem 0;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 2.5rem;
        top: 0;
        bottom: 0;
        width: 6px;
        background: linear-gradient(180deg, 
            transparent 0%, 
            var(--galaxy-ultra-light) 10%, 
            var(--galaxy-secondary) 50%, 
            var(--galaxy-ultra-light) 90%, 
            transparent 100%);
        border-radius: 3px;
        box-shadow: 
            0 0 20px rgba(100, 181, 246, 0.4),
            inset 0 0 10px rgba(255, 255, 255, 0.5);
        animation: timelinePulse 3s ease-in-out infinite;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 4rem;
        background: var(--surface);
        border: 2px solid var(--galaxy-ultra-light);
        border-radius: 28px;
        padding: 2.5rem;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(20px);
        overflow: hidden;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        top: -1px;
        left: -1px;
        right: -1px;
        bottom: -1px;
        background: linear-gradient(45deg, transparent, var(--galaxy-ultra-light), transparent);
        border-radius: 28px;
        opacity: 0;
        transition: opacity 0.5s ease;
        z-index: -1;
    }

    .timeline-item:hover {
        transform: translateX(12px) scale(1.02);
        border-color: var(--galaxy-secondary);
        box-shadow: 
            0 30px 80px rgba(25, 118, 210, 0.2),
            0 0 0 1px rgba(255, 255, 255, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    .timeline-item:hover::before {
        opacity: 1;
    }

    .timeline-marker {
        position: absolute;
        left: -5.5rem;
        top: 2.5rem;
        width: 4.5rem;
        height: 4.5rem;
        background: linear-gradient(135deg, #e0e0e0 0%, #f5f5f5 100%);
        border: 6px solid var(--surface);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9e9e9e;
        font-size: 1.4rem;
        font-weight: 800;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 3;
        position: relative;
        overflow: hidden;
    }

    .timeline-marker::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: inherit;
        opacity: 0.1;
        scale: 0;
        transition: scale 0.5s ease;
    }

    .timeline-marker:hover::before {
        scale: 1.5;
    }

    .timeline-item.active .timeline-marker {
        background: linear-gradient(135deg, #ff6b35 0%, #ff8f65 100%);
        color: #ffffff;
        transform: scale(1.3);
        box-shadow: 
            0 15px 40px rgba(255, 107, 53, 0.5),
            0 0 0 8px rgba(255, 107, 53, 0.1),
            0 0 0 16px rgba(255, 107, 53, 0.05);
        animation: activeMarkerPulse 2s infinite;
    }

    .timeline-item.completed .timeline-marker {
        background: linear-gradient(135deg, #00c851 0%, #00ff7f 100%);
        color: #ffffff;
        transform: scale(1.2);
        box-shadow: 
            0 15px 40px rgba(0, 200, 81, 0.4),
            0 0 0 6px rgba(0, 200, 81, 0.1),
            0 0 0 12px rgba(0, 200, 81, 0.05);
    }

    .timeline-item.cancelled .timeline-marker {
        background: linear-gradient(135deg, #ff4757 0%, #ff6b7d 100%);
        color: #ffffff;
        transform: scale(1.2);
        box-shadow: 
            0 15px 40px rgba(255, 71, 87, 0.4),
            0 0 0 6px rgba(255, 71, 87, 0.1),
            0 0 0 12px rgba(255, 71, 87, 0.05);
    }

    .timeline-content h6 {
        color: var(--text-primary);
        font-weight: 900;
        font-size: 1.6rem;
        margin-bottom: 1.5rem;
        background: linear-gradient(135deg, var(--galaxy-primary) 0%, var(--galaxy-secondary) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        position: relative;
    }

    .timeline-content h6::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, var(--galaxy-primary), var(--galaxy-secondary));
        border-radius: 2px;
        opacity: 0.7;
    }

    .timeline-content p {
        color: var(--text-secondary);
        font-size: 1.2rem;
        line-height: 1.8;
        margin-bottom: 1.5rem;
        font-weight: 500;
    }

    .timeline-content small {
        color: var(--text-secondary);
        font-size: 1.1rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--surface-variant) 0%, var(--galaxy-ultra-light) 100%);
        padding: 0.8rem 1.5rem;
        border-radius: 20px;
        display: inline-block;
        border: 1px solid var(--galaxy-ultra-light);
        font-family: 'JetBrains Mono', monospace;
        letter-spacing: 0.5px;
    }

    /* Ultra Premium Button */
    .btn-cancel {
        background: linear-gradient(135deg, #ff4757 0%, #ff6b7d 100%);
        color: white;
        border: none;
        padding: 1.5rem 3rem;
        border-radius: 20px;
        font-size: 1.2rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(20px);
    }

    .btn-cancel::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.6s ease;
    }

    .btn-cancel::after {
        content: '';
        position: absolute;
        inset: 2px;
        border-radius: 18px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0));
        z-index: -1;
    }

    .btn-cancel:hover {
        transform: translateY(-6px) scale(1.05);
        box-shadow: 
            0 20px 50px rgba(255, 71, 87, 0.5),
            0 0 0 1px rgba(255, 255, 255, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    .btn-cancel:hover::before {
        left: 100%;
    }

    .btn-cancel:active {
        transform: translateY(-2px) scale(1.02);
    }

    /* Container Enhancements */
    .order-details-container {
        max-width: 1400px;
        margin: 3rem auto;
        padding: 0 3rem;
        position: relative;
    }

    .main-card {
        background: var(--surface);
        border: 2px solid var(--galaxy-ultra-light);
        border-radius: 40px;
        overflow: hidden;
        position: relative;
        backdrop-filter: blur(20px);
    }

    .main-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 8px;
        background: linear-gradient(90deg, 
            var(--galaxy-primary) 0%, 
            var(--galaxy-secondary) 25%, 
            var(--galaxy-light) 50%, 
            var(--galaxy-secondary) 75%, 
            var(--galaxy-primary) 100%);
        background-size: 200% 100%;
        animation: gradientSlide 3s ease-in-out infinite;
    }

    .card-header {
        padding: 3rem;
        background: linear-gradient(135deg, var(--surface-variant) 0%, rgba(248, 250, 255, 0.8) 100%);
        border-bottom: 2px solid var(--galaxy-ultra-light);
        position: relative;
        overflow: hidden;
    }

    .card-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: radial-gradient(circle, rgba(100, 181, 246, 0.05) 0%, transparent 70%);
        animation: headerFloat 8s ease-in-out infinite;
    }

    .card-body {
        padding: 3rem;
        position: relative;
    }

    /* Advanced Animations */
    @keyframes floatingBackground {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(1deg); }
    }

    @keyframes gradientRotate {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes gradientSlide {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    @keyframes timelinePulse {
        0%, 100% { opacity: 0.8; box-shadow: 0 0 20px rgba(100, 181, 246, 0.4); }
        50% { opacity: 1; box-shadow: 0 0 30px rgba(100, 181, 246, 0.6); }
    }

    @keyframes activeMarkerPulse {
        0%, 100% { 
            transform: scale(1.3);
            box-shadow: 
                0 15px 40px rgba(255, 107, 53, 0.5),
                0 0 0 8px rgba(255, 107, 53, 0.1),
                0 0 0 16px rgba(255, 107, 53, 0.05);
        }
        50% { 
            transform: scale(1.4);
            box-shadow: 
                0 20px 60px rgba(255, 107, 53, 0.6),
                0 0 0 12px rgba(255, 107, 53, 0.15),
                0 0 0 24px rgba(255, 107, 53, 0.08);
        }
    }

    @keyframes headerFloat {
        0%, 100% { transform: translateX(0%) rotate(0deg); }
        50% { transform: translateX(10%) rotate(1deg); }
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(50px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .timeline-item {
        animation: slideInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        opacity: 0;
    }

    .timeline-item:nth-child(1) { animation-delay: 0.1s; }
    .timeline-item:nth-child(2) { animation-delay: 0.2s; }
    .timeline-item:nth-child(3) { animation-delay: 0.3s; }
    .timeline-item:nth-child(4) { animation-delay: 0.4s; }
    .timeline-item:nth-child(5) { animation-delay: 0.5s; }

    /* Responsive Luxury */
    @media (max-width: 768px) {
        .order-details-container {
            padding: 0 1.5rem;
        }

        .timeline {
            padding-left: 3rem;
        }

        .timeline::before {
            left: 1.5rem;
            width: 4px;
        }

        .timeline-marker {
            left: -3.75rem;
            width: 3.5rem;
            height: 3.5rem;
            font-size: 1.2rem;
        }

        .timeline-item {
            padding: 2rem;
            margin-bottom: 3rem;
        }

        .notes-content {
            padding: 2rem;
        }

        .status-badge {
            padding: 1rem 2rem;
            font-size: 1rem;
        }

        .product-image img {
            width: 100px;
            height: 100px;
        }

        .btn-cancel {
            padding: 1.2rem 2rem;
            font-size: 1.1rem;
        }

        .card-header, .card-body {
            padding: 2rem;
        }
    }

    /* Ultra smooth loading states */
    .luxury-loader {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: luxuryShimmer 2s infinite;
    }

    @keyframes luxuryShimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    /* Glass morphism effects */
    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(30px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    /* Premium hover states */
    .premium-hover {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .premium-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 60px rgba(25, 118, 210, 0.15);
    }
</style>
<script>
    // Modern Cancel Order Function with Better UX
    function cancelOrder() {
        // Create modern confirmation modal
        const modal = document.createElement('div');
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            opacity: 0;
            transition: opacity 0.3s ease;
        `;

        const modalContent = document.createElement('div');
        modalContent.style.cssText = `
            background: white;
            padding: 3rem;
            border-radius: 24px;
            box-shadow: 0 24px 80px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            margin: 2rem;
            text-align: center;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        `;

        modalContent.innerHTML = `
            <div style="font-size: 3rem; margin-bottom: 1rem;">⚠️</div>
            <h3 style="color: #1565c0; font-weight: 800; font-size: 1.5rem; margin-bottom: 1rem;">
                Xác nhận hủy đơn hàng
            </h3>
            <p style="color: #546e7a; font-size: 1.1rem; margin-bottom: 2rem;">
                Bạn có chắc chắn muốn hủy đơn hàng này?<br>
                <strong>Hành động này không thể hoàn tác!</strong>
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <button onclick="confirmCancel()" style="
                    background: linear-gradient(135deg, #f44336 0%, #ef5350 100%);
                    color: white;
                    border: none;
                    padding: 1rem 2rem;
                    border-radius: 16px;
                    font-weight: 700;
                    cursor: pointer;
                    transition: all 0.3s ease;
                ">Xác nhận hủy</button>
                <button onclick="closeModal()" style="
                    background: #ffffff;
                    color: #1976d2;
                    border: 2px solid #e3f2fd;
                    padding: 1rem 2rem;
                    border-radius: 16px;
                    font-weight: 700;
                    cursor: pointer;
                    transition: all 0.3s ease;
                ">Không hủy</button>
            </div>
        `;

        modal.appendChild(modalContent);
        document.body.appendChild(modal);

        // Animate modal in
        setTimeout(() => {
            modal.style.opacity = '1';
            modalContent.style.transform = 'scale(1)';
        }, 10);

        // Global functions for modal
        window.confirmCancel = function() {
            // Add loading state
            modalContent.innerHTML = `
                <div class="loading-shimmer" style="width: 60px; height: 60px; border-radius: 50%; margin: 0 auto 1rem;"></div>
                <p style="color: #546e7a; font-size: 1.1rem;">Đang xử lý yêu cầu hủy...</p>
            `;
            
            setTimeout(() => {
                alert('Tính năng hủy đơn hàng đang được phát triển');
                closeModal();
            }, 2000);
        };

        window.closeModal = function() {
            modal.style.opacity = '0';
            modalContent.style.transform = 'scale(0.9)';
            setTimeout(() => {
                document.body.removeChild(modal);
                delete window.confirmCancel;
                delete window.closeModal;
            }, 300);
        };
    }

    // Add smooth scrolling and animations on load
    document.addEventListener('DOMContentLoaded', function() {
        // Add intersection observer for animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        });

        // Observe all timeline items
        document.querySelectorAll('.timeline-item').forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(30px)';
            item.style.transition = 'all 0.6s ease';
            observer.observe(item);
        });
    });
</script>

<script>
    function cancelOrder() {
        if (confirm('Bạn có chắc chắn muốn hủy đơn hàng này? Hành động này không thể hoàn tác.')) {
            // Implement cancel order logic here
            alert('Tính năng hủy đơn hàng đang được phát triển');
        }
    }
</script>
@endsection
