@extends('admin.layouts.app')
@section('title', 'Quản lý đơn hàng')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="order-management-container">
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-shopping-cart"></i>
                Đơn hàng đã được duyệt
            </h1>
            <div class="header-stats">
                <div class="stat-card">
                    <span class="stat-number">{{ $orders->total() }}</span>
                    <span class="stat-label">Tổng đơn hàng</span>
                </div>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-header">
            <h3 class="table-title">Danh sách đơn hàng</h3>
            <div class="table-actions">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Tìm kiếm đơn hàng...">
                </div>
            </div>
        </div>

        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th class="sortable">
                            <span>Mã đơn</span>
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable">
                            <span>Ngày đặt</span>
                            <i class="fas fa-sort"></i>
                        </th>
                        <th>Khách hàng</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th class="sortable">
                            <span>Tổng tiền</span>
                            <i class="fas fa-sort"></i>
                        </th>
                        <th>Trạng thái</th>
                        <th>Ghi chú</th>
                        <th class="actions-column">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr class="table-row">
                        <td class="order-id">
                            <span class="id-badge">#{{ $order->id }}</span>
                        </td>
                        <td class="order-date">
                            <div class="date-info">
                                <span class="date">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</span>
                                <span class="time">{{ \Carbon\Carbon::parse($order->created_at)->format('H:i') }}</span>
                            </div>
                        </td>
                        <td class="customer-info">
                            <div class="customer-avatar">
                                {{ substr($order->user->fullname ?? 'N', 0, 1) }}
                            </div>
                            <span class="customer-name">{{ $order->user->fullname ?? 'N/A' }}</span>
                        </td>
                        <td class="order-address">
                            <span class="address-text" title="{{ $order->user->address ?? 'Chưa có địa chỉ' }}">
                                {{ Str::limit($order->user->address ?? 'Chưa có địa chỉ', 30) }}
                            </span>
                        </td>
                        <td class="order-phone">
                            <a href="tel:{{ $order->user->phone_number ?? '' }}" class="phone-link">
                                {{ $order->user->phone_number ?? 'N/A' }}
                            </a>
                        </td>
                        <td class="order-total">
                            <span class="amount">{{ number_format($order->computed_total ?? $order->total_amount ?? 0, 0, ',', '.') }}</span>
                            <span class="currency">VND</span>
                        </td>
                        <td class="order-status">
                            <span class="status-badge status-{{ strtolower($order->status) }}">
                                <i class="fas fa-check-circle"></i>
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="order-notes">
                            @if($order->notes)
                                <span class="notes-preview" title="{{ $order->notes }}">
                                    {{ Str::limit($order->notes, 20) }}
                                </span>
                            @else
                                <span class="no-notes">Không có ghi chú</span>
                            @endif
                        </td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                <button type="button" 
                                        class="action-btn delete-btn js-delete-order" 
                                        data-order-id="{{ $order->id }}" 
                                        data-status="{{ $order->status }}"
                                        title="Xóa đơn hàng">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                   class="action-btn view-btn"
                                   title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.js-delete-order').forEach(button => {
            button.addEventListener('click', function () {
                const orderId = this.getAttribute('data-order-id');

                Swal.fire({
                    title: 'Xác nhận',
                    text: "Bạn có chắc chắn muốn xóa đơn hàng không?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/admin/orders/${orderId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Lỗi khi xóa đơn hàng');
                            return response.json();
                        })
                        .then(data => {
                            Swal.fire({
                                title: 'Đã xóa!',
                                text: 'Đơn hàng đã được xóa thành công.',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1500,
                                position: 'center',
                                toast: false
                            }).then(() => {
                                location.reload(); // Tải lại trang
                            });
                        })
                        .catch(error => {
                            Swal.fire({
                                title: 'Lỗi!',
                                text: 'Không thể xóa đơn hàng.',
                                icon: 'error'
                            });
                        });
                    }
                });
            });
        });
    });
</script>


        <!-- Modern Pagination -->
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Hiển thị {{ $orders->firstItem() ?? 0 }} - {{ $orders->lastItem() ?? 0 }} 
                trong tổng số {{ $orders->total() }} đơn hàng
            </div>
            <div class="pagination-controls">
                @php
                $currentPage = $orders->currentPage();
                $lastPage = $orders->lastPage();
                @endphp
                
                <a href="{{ $orders->url(max($currentPage-1,1)) }}" 
                   class="pagination-btn {{ $currentPage == 1 ? 'disabled' : '' }}">
                    <i class="fas fa-chevron-left"></i>
                    Trước
                </a>
                
                @for ($i = max(1, $currentPage - 2); $i <= min($lastPage, $currentPage + 2); $i++)
                    <a href="{{ $orders->url($i) }}" 
                       class="pagination-btn {{ $currentPage == $i ? 'active' : '' }}">
                        {{ $i }}
                    </a>
                @endfor
                
                <a href="{{ $orders->url(min($currentPage+1,$lastPage)) }}" 
                   class="pagination-btn {{ $currentPage == $lastPage ? 'disabled' : '' }}">
                    Sau
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
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
}

.order-management-container {
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
    align-items: center;
    background: var(--galaxy-gradient);
    padding: 2rem;
    border-radius: 16px;
    color: white;
    box-shadow: var(--shadow-lg);
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

.header-stats {
    display: flex;
    gap: 1rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    padding: 1rem 1.5rem;
    border-radius: 12px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.stat-number {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
}

.stat-label {
    font-size: 0.875rem;
    opacity: 0.9;
}

.table-card {
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-md);
    overflow: hidden;
}

.table-header {
    padding: 1.5rem 2rem;
    background: var(--galaxy-light);
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.table-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--galaxy-dark);
    margin: 0;
}

.search-box {
    position: relative;
    display: flex;
    align-items: center;
}

.search-box i {
    position: absolute;
    left: 1rem;
    color: #6b7280;
}

.search-box input {
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    width: 250px;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.search-box input:focus {
    outline: none;
    border-color: var(--galaxy-accent);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.table-container {
    overflow-x: auto;
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
}

.modern-table thead th {
    background: var(--galaxy-primary);
    color: white;
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.modern-table thead th.sortable {
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.modern-table thead th.sortable:hover {
    background: var(--galaxy-secondary);
}

.modern-table thead th.sortable span {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.modern-table thead th.sortable i {
    opacity: 0.6;
    font-size: 0.75rem;
}

.table-row {
    transition: all 0.3s ease;
    border-bottom: 1px solid #f3f4f6;
}

.table-row:hover {
    background: #f8fafc;
    transform: translateY(-1px);
    box-shadow: var(--shadow-sm);
}

.modern-table td {
    padding: 1rem;
    vertical-align: middle;
}

.id-badge {
    background: var(--galaxy-light);
    color: var(--galaxy-primary);
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.875rem;
}

.date-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.date {
    font-weight: 600;
    color: var(--galaxy-dark);
}

.time {
    font-size: 0.75rem;
    color: #6b7280;
}

.customer-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.customer-avatar {
    width: 2.5rem;
    height: 2.5rem;
    background: var(--galaxy-gradient);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
}

.customer-name {
    font-weight: 500;
    color: var(--galaxy-dark);
}

.address-text {
    color: #6b7280;
    font-size: 0.875rem;
}

.phone-link {
    color: var(--galaxy-accent);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.phone-link:hover {
    color: var(--galaxy-primary);
}

.order-total {
    text-align: right;
}

.amount {
    font-weight: 700;
    color: var(--galaxy-dark);
    font-size: 1rem;
}

.currency {
    font-size: 0.75rem;
    color: #6b7280;
    margin-left: 0.25rem;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.status-approved,
.status-đã_duyệt {
    background: #dcfce7;
    color: #166534;
}

.notes-preview {
    color: #6b7280;
    font-style: italic;
    font-size: 0.875rem;
}

.no-notes {
    color: #9ca3af;
    font-size: 0.875rem;
}

.actions-cell {
    width: 120px;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.action-btn {
    width: 2.5rem;
    height: 2.5rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.delete-btn {
    background: #fee2e2;
    color: #dc2626;
}

.delete-btn:hover {
    background: #fca5a5;
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.view-btn {
    background: var(--galaxy-light);
    color: var(--galaxy-primary);
}

.view-btn:hover {
    background: var(--galaxy-accent);
    color: white;
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.pagination-wrapper {
    padding: 1.5rem 2rem;
    background: #f9fafb;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.pagination-info {
    color: #6b7280;
    font-size: 0.875rem;
}

.pagination-controls {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.pagination-btn {
    padding: 0.5rem 1rem;
    border: 1px solid #d1d5db;
    background: white;
    color: var(--galaxy-dark);
    text-decoration: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.pagination-btn:hover:not(.disabled) {
    background: var(--galaxy-light);
    border-color: var(--galaxy-accent);
    color: var(--galaxy-primary);
}

.pagination-btn.active {
    background: var(--galaxy-gradient);
    border-color: var(--galaxy-primary);
    color: white;
}

.pagination-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .order-management-container {
        padding: 1rem;
    }
    
    .header-content {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .table-header {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .search-box input {
        width: 100%;
    }
}

@media (max-width: 768px) {
    .modern-table {
        font-size: 0.875rem;
    }
    
    .modern-table td {
        padding: 0.75rem 0.5rem;
    }
    
    .pagination-wrapper {
        flex-direction: column;
        gap: 1rem;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>

@endsection