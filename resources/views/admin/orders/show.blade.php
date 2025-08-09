@extends('admin.layouts.app')
@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="order-detail-container">
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <div class="breadcrumb">
                    <a href="{{ route('admin.orders.index') }}" class="breadcrumb-link">
                        <i class="fas fa-arrow-left"></i>
                        Danh sách đơn hàng
                    </a>
                    <span class="breadcrumb-separator">/</span>
                    <span class="breadcrumb-current">Chi tiết đơn hàng</span>
                </div>
                <h1 class="page-title">
                    <i class="fas fa-receipt"></i>
                    Chi tiết đơn hàng #{{ $order->id }}
                </h1>
            </div>
            <div class="header-actions">
                <div class="order-status-badge status-{{ strtolower($order->status) }}">
                    <i class="fas fa-circle"></i>
                    {{ ucfirst($order->status) }}
                </div>
                <button class="action-btn print-btn" onclick="window.print()">
                    <i class="fas fa-print"></i>
                    In đơn hàng
                </button>
            </div>
        </div>
    </div>

    <div class="detail-grid">
        <!-- Customer Information Card -->
        <div class="info-card customer-card">
            <div class="card-header">
                <div class="card-icon">
                    <i class="fas fa-user"></i>
                </div>
                <h3 class="card-title">Thông tin khách hàng</h3>
            </div>
            <div class="card-body">
                <div class="customer-info">
                    <div class="customer-avatar">
                        {{ substr($order->user->fullname ?? 'N', 0, 1) }}
                    </div>
                    <div class="customer-details">
                        <h4 class="customer-name">{{ $order->user->fullname ?? 'N/A' }}</h4>
                        <div class="contact-info">
                            <div class="contact-item">
                                <i class="fas fa-phone"></i>
                                <a href="tel:{{ $order->user->phone_number ?? '' }}" class="contact-link">
                                    {{ $order->user->phone_number ?? 'Chưa có số điện thoại' }}
                                </a>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="contact-text">{{ $order->user->address ?? 'Chưa có địa chỉ' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Information Card -->
        <div class="info-card order-info-card">
            <div class="card-header">
                <div class="card-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <h3 class="card-title">Thông tin đơn hàng</h3>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Ngày đặt</span>
                        <span class="info-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Trạng thái</span>
                        <span class="info-value">
                            <span class="status-badge status-{{ strtolower($order->status) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </span>
                    </div>
                    <div class="info-item full-width">
                        <span class="info-label">Ghi chú</span>
                        <span class="info-value notes">
                            {{ $order->notes ?? 'Không có ghi chú' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table Card -->
    <div class="products-card">
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-gems"></i>
            </div>
            <h3 class="card-title">Danh sách sản phẩm</h3>
            <div class="product-count">
                {{ $order->orderDetails->count() }} sản phẩm
            </div>
        </div>
        
        <div class="products-table-container">
            <table class="products-table">
                <thead>
                    <tr>
                        <th class="product-column">Sản phẩm</th>
                        <th class="quantity-column">Số lượng</th>
                        <th class="price-column">Đơn giá</th>
                        <th class="total-column">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($order->orderDetails as $detail)
                        @php
                            $quantity = $detail->quantity ?? 0;
                            $unitPrice = $detail->price ?? $detail->unit_price ?? 0;
                            $lineTotal = $quantity * $unitPrice;
                            $total += $lineTotal;
                        @endphp
                        <tr class="product-row">
                            <td class="product-info">
                                <div class="product-details">
                                    <div class="product-icon">
                                        <i class="fas fa-gem"></i>
                                    </div>
                                    <div class="product-text">
                                        <span class="product-name">{{ $detail->jewelry->name }}</span>
                                        <span class="product-code">#{{ $detail->jewelry->id ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="quantity-cell">
                                <div class="quantity-badge">{{ $quantity }}</div>
                            </td>
                            <td class="price-cell">
                                <span class="price-amount">{{ number_format($unitPrice, 0, ',', '.') }}</span>
                                <span class="price-currency">VND</span>
                            </td>
                            <td class="total-cell">
                                <span class="total-amount">{{ number_format($lineTotal, 0, ',', '.') }}</span>
                                <span class="total-currency">VND</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
<!-- Order Summary -->
<div class="order-summary">
    <div class="summary-content" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap;">
        <!-- ✅ QR nằm bên trái -->
         <div id="qr-payment" style="flex: 0 0 50%; text-align: left;">
            <h4>Quét mã để thanh toán</h4>
            <img src="https://img.vietqr.io/image/sacombank-070130092398-compact2.png?accountName=PHAM%20MY%20TIEN&amount={{ $total }}&addInfo=Thanh+toan+don+hang+{{ $order->id }}"
     alt="QR chuyển khoản" style="max-width: 200px;">

         
        </div>

        <!-- ✅ Tổng tiền nằm bên phải -->
        <div style="min-width: 250px;">
            <div class="summary-row subtotal">
                <span class="summary-label">Tạm tính:</span>
                <span class="summary-value">{{ number_format($total, 0, ',', '.') }} VND</span>
            </div>
            <div class="summary-row shipping">
                <span class="summary-label">Phí vận chuyển:</span>
                <span class="summary-value">Miễn phí</span>
            </div>
            <div class="summary-row total" style="font-weight: bold; border-top: 2px solid #2c2c7c; padding-top: 10px;">
                <span class="summary-label">Tổng cộng:</span>
                <span class="summary-value" style="color: #2c2c7c;">{{ number_format($total, 0, ',', '.') }} VND</span>
            </div>
        </div>
    </div>
</div>


    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Quay lại danh sách
        </a>
        
        @if($order->status === 'pending')
        <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST" class="inline-form">
            @csrf
            <button type="submit" class="btn btn-success" onclick="return confirm('Xác nhận duyệt đơn hàng này?')">
                <i class="fas fa-check"></i>
                Duyệt đơn hàng
            </button>
        </form>
        @endif
        
       <!-- Nút in đơn hàng -->
<button class="btn btn-primary" onclick="showQRAndPrint()">
    <i class="fas fa-print"></i>
    In đơn hàng
</button>


<!-- JS: Hiện QR rồi in -->
<script>
    function showQRAndPrint() {
        const qrDiv = document.getElementById('qr-payment');
        qrDiv.style.display = 'block'; // Hiện QR code

        setTimeout(() => {
            window.print(); // Gọi lệnh in sau khi QR hiện
        }, 200);

        setTimeout(() => {
            qrDiv.style.display = 'none'; // Ẩn lại sau khi in (nếu muốn)
        }, 1500);
    }
</script>


    </div>
</div>

<style>
:root {
    --galaxy-primary: #1e3a8a;
    --galaxy-secondary: #1e40af;
    --galaxy-accent: #3b82f6;
    --galaxy-light: #dbeafe;
    --galaxy-dark: #1e293b;
    --galaxy-gradient: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #06b6d4 100%);
    --galaxy-gradient-hover: linear-gradient(135deg, #1e40af 0%, #2563eb 50%, #0891b2 100%);
    --shadow-sm: 0 2px 4px rgba(30, 58, 138, 0.1);
    --shadow-md: 0 4px 12px rgba(30, 58, 138, 0.15);
    --shadow-lg: 0 8px 25px rgba(30, 58, 138, 0.2);
    --shadow-xl: 0 12px 40px rgba(30, 58, 138, 0.25);
    --success-color: #10b981;
    --success-light: #d1fae5;
    --warning-color: #f59e0b;
    --warning-light: #fef3c7;
    --danger-color: #ef4444;
    --danger-light: #fee2e2;
}

.order-detail-container {
    padding: 2rem;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    min-height: 100vh;
}

.page-header {
    margin-bottom: 2rem;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    background: var(--galaxy-gradient);
    padding: 2rem;
    border-radius: 16px;
    color: white;
    box-shadow: var(--shadow-lg);
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
    opacity: 0.9;
}

.breadcrumb-link {
    color: white;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: opacity 0.3s ease;
}

.breadcrumb-link:hover {
    opacity: 0.8;
    color: white;
}

.breadcrumb-separator {
    opacity: 0.6;
}

.breadcrumb-current {
    opacity: 0.7;
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.page-title i {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.5rem;
    border-radius: 12px;
}

.header-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.order-status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.status-pending {
    background: var(--warning-light);
    color: var(--warning-color);
}

.status-approved,
.status-completed {
    background: var(--success-light);
    color: var(--success-color);
}

.status-cancelled {
    background: var(--danger-light);
    color: var(--danger-color);
}

.print-btn {
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.print-btn:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
}

.detail-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

.info-card {
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-md);
    overflow: hidden;
}

.card-header {
    padding: 1.5rem 2rem;
    background: var(--galaxy-light);
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.card-icon {
    width: 2.5rem;
    height: 2.5rem;
    background: var(--galaxy-gradient);
    color: white;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--galaxy-dark);
    margin: 0;
}

.card-body {
    padding: 2rem;
}

.customer-info {
    display: flex;
    gap: 1.5rem;
    align-items: flex-start;
}

.customer-avatar {
    width: 4rem;
    height: 4rem;
    background: var(--galaxy-gradient);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.customer-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--galaxy-dark);
    margin: 0 0 1rem 0;
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.contact-item i {
    width: 1.25rem;
    color: var(--galaxy-accent);
    flex-shrink: 0;
}

.contact-link {
    color: var(--galaxy-accent);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.contact-link:hover {
    color: var(--galaxy-primary);
}

.contact-text {
    color: #6b7280;
    line-height: 1.5;
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.info-item.full-width {
    grid-column: 1 / -1;
}

.info-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.info-value {
    font-weight: 500;
    color: var(--galaxy-dark);
}

.info-value.notes {
    color: #6b7280;
    font-style: italic;
    line-height: 1.5;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.products-card {
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-md);
    overflow: hidden;
    margin-bottom: 2rem;
}

.products-card .card-header {
    justify-content: space-between;
}

.product-count {
    background: rgba(59, 130, 246, 0.1);
    color: var(--galaxy-primary);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.products-table-container {
    overflow-x: auto;
}

.products-table {
    width: 100%;
    border-collapse: collapse;
}

.products-table thead th {
    background: var(--galaxy-primary);
    color: white;
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.product-column {
    width: 40%;
}

.quantity-column {
    width: 15%;
    text-align: center;
}

.price-column,
.total-column {
    width: 22.5%;
    text-align: right;
}

.product-row {
    transition: background-color 0.3s ease;
    border-bottom: 1px solid #f3f4f6;
}

.product-row:hover {
    background: #f8fafc;
}

.products-table td {
    padding: 1.5rem 1rem;
    vertical-align: middle;
}

.product-info {
    display: flex;
    align-items: center;
}

.product-details {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.product-icon {
    width: 2.5rem;
    height: 2.5rem;
    background: var(--galaxy-light);
    color: var(--galaxy-primary);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.product-text {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.product-name {
    font-weight: 600;
    color: var(--galaxy-dark);
}

.product-code {
    font-size: 0.75rem;
    color: #6b7280;
}

.quantity-cell {
    text-align: center;
}

.quantity-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    background: var(--galaxy-light);
    color: var(--galaxy-primary);
    border-radius: 50%;
    font-weight: 600;
}

.price-cell,
.total-cell {
    text-align: right;
}

.price-amount,
.total-amount {
    font-weight: 600;
    color: var(--galaxy-dark);
}

.price-currency,
.total-currency {
    font-size: 0.75rem;
    color: #6b7280;
    margin-left: 0.25rem;
}

.order-summary {
    background: #f9fafb;
    border-top: 1px solid #e5e7eb;
    padding: 2rem;
}

.summary-content {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 40px;
    width: 100%;
    max-width: none; /* hoặc xoá dòng này */
    margin-left: 0;   /* Đừng đẩy sang phải nữa */
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
}

.summary-row:not(:last-child) {
    border-bottom: 1px solid #e5e7eb;
}

.summary-row.total {
    border-top: 2px solid var(--galaxy-primary);
    margin-top: 0.5rem;
    padding-top: 1rem;
}

.summary-label {
    font-weight: 500;
    color: #6b7280;
}

.summary-row.total .summary-label {
    font-weight: 700;
    color: var(--galaxy-dark);
    font-size: 1.125rem;
}

.summary-value {
    font-weight: 600;
    color: var(--galaxy-dark);
}

.summary-row.total .summary-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--galaxy-primary);
}

.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: flex-start;
    align-items: center;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.btn-secondary {
    background: #f3f4f6;
    color: var(--galaxy-dark);
    border: 1px solid #d1d5db;
}

.btn-secondary:hover {
    background: #e5e7eb;
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.btn-success {
    background: var(--success-color);
    color: white;
}

.btn-success:hover {
    background: #059669;
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.btn-primary {
    background: var(--galaxy-gradient);
    color: white;
}

.btn-primary:hover {
    background: var(--galaxy-gradient-hover);
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.inline-form {
    display: inline-block;
}

/* Print Styles */
@media print {
    .page-header .header-actions,
    .action-buttons {
        display: none !important;
    }
    
    .order-detail-container {
        background: white !important;
        padding: 1rem !important;
    }
    
    .info-card,
    .products-card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }
}

/* Responsive Design */
@media (max-width: 1024px) {
    .order-detail-container {
        padding: 1rem;
    }
    
    .detail-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .header-content {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .header-actions {
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .page-title {
        font-size: 1.5rem;
    }
    
    .customer-info {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .products-table {
        font-size: 0.875rem;
    }
    
    .products-table td {
        padding: 1rem 0.5rem;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: stretch;
    }
    
    .product-details {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .quantity-column,
    .price-column,
    .total-column {
        text-align: center;
    }
}
</style>

@endsection