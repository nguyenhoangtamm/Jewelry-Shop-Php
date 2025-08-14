@extends('admin.layouts.app')
@section('title', 'Duyệt đơn hàng')

@section('content')
<div class="order-approval-container">
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-clock"></i>
                Duyệt đơn hàng
            </h1>
            <div class="header-stats">
                <div class="stat-card">
                    <span class="stat-number">{{ $orders->total() }}</span>
                    <span class="stat-label">Đơn chờ xử lý</span>
                </div>
                @if($orders->total() > 0)
                <div class="bulk-actions">
                    <button class="bulk-approve-btn" onclick="showBulkApproveModal()">
                        <i class="fas fa-check-double"></i>
                        Duyệt hàng loạt
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-header">
            <h3 class="table-title">Danh sách đơn hàng chờ xử lý</h3>
            <div class="table-actions">
                <div class="filter-group">
                    <select class="filter-select">
                        <option value="">Tất cả đơn hàng</option>
                        <option value="today">Hôm nay</option>
                        <option value="week">Tuần này</option>
                        <option value="month">Tháng này</option>
                    </select>
                </div>
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
                        <th class="checkbox-column">
                            <input type="checkbox" id="selectAll" class="select-all-checkbox">
                        </th>
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
                        <th>SĐT</th>
                        <th class="sortable">
                            <span>Tổng tiền</span>
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="actions-column">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                    <tr class="table-row" data-order-id="{{ $order->id }}">
                        <td>
                            <input type="checkbox" class="order-checkbox" value="{{ $order->id }}">
                        </td>
                        <td class="order-id">
                            <span class="id-badge">#{{ $order->id }}</span>
                        </td>
                        <td class="order-date">
                            <div class="date-info">
                                <span class="date">
                                    {{ $order->created_at ? $order->created_at->format('d/m/Y') : 'Chưa xác định' }}
                                </span>
                                <span class="time">
                                    {{ $order->created_at ? $order->created_at->format('H:i') : '' }}
                                </span>

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
                        <td class="actions-cell">
                            <form action="{{ route('admin.orders.approve', $order->id) }}"
                                method="POST"
                                class="approval-form"
                                onsubmit="return confirmApproval('{{ $order->id }}', '{{ $order->user->fullname ?? 'N/A' }}')">
                                @csrf
                                <input type="hidden" name="page" value="{{ request('page', 1) }}">
                                <button type="submit" class="approve-btn">
                                    <i class="fas fa-check"></i>
                                    <span class="btn-text">Duyệt</span>
                                </button>
                            </form>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="preview-btn">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="8" class="empty-state">
                            <div class="empty-content">
                                <i class="fas fa-inbox"></i>
                                <h4>Không có đơn hàng chờ xử lý</h4>
                                <p>Tất cả đơn hàng đã được xử lý hoặc chưa có đơn hàng mới.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modern Pagination -->
        @if($orders->hasPages())
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Hiển thị {{ $orders->firstItem() ?? 0 }} - {{ $orders->lastItem() ?? 0 }}
                trong tổng số {{ $orders->total() }} đơn hàng
            </div>
            <div class="pagination-controls">
                {{ $orders->links('custom.pagination') }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Approval Confirmation Modal -->
<div id="approvalModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Xác nhận duyệt đơn hàng</h3>
            <button type="button" class="close-btn" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="confirmation-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <p>Bạn có chắc chắn muốn duyệt đơn hàng <strong id="orderIdText"></strong> của khách hàng <strong id="customerNameText"></strong>?</p>
            <div class="modal-actions">
                <button type="button" class="cancel-btn" onclick="closeModal()">Hủy</button>
                <button type="button" class="confirm-btn" onclick="confirmApprovalAction()">Xác nhận duyệt</button>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Approval Modal -->
<div id="bulkApprovalModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Duyệt hàng loạt</h3>
            <button type="button" class="close-btn" onclick="closeBulkModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p>Chọn các đơn hàng cần duyệt và nhấn "Duyệt tất cả" để xử lý hàng loạt.</p>
            <div class="selected-orders" id="selectedOrdersList"></div>
            <div class="modal-actions">
                <button type="button" class="cancel-btn" onclick="closeBulkModal()">Hủy</button>
                <button type="button" class="confirm-btn" onclick="processBulkApproval()" id="bulkApproveBtn" disabled>
                    Duyệt tất cả (<span id="selectedCount">0</span>)
                </button>
            </div>
        </div>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">
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
    }

    .order-approval-container {
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
        align-items: center;
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

    .bulk-approve-btn {
        background: var(--success-color);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .bulk-approve-btn:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
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

    .table-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .filter-select {
        padding: 0.5rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: white;
        font-size: 0.875rem;
        color: var(--galaxy-dark);
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

    .checkbox-column {
        width: 50px;
        text-align: center;
    }

    .actions-column {
        width: 150px;
        text-align: center;
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

    .select-all-checkbox,
    .order-checkbox {
        width: 1rem;
        height: 1rem;
        accent-color: var(--galaxy-accent);
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
        background: var(--warning-light);
        color: var(--warning-color);
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

    .actions-cell {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        align-items: center;
    }

    .approval-form {
        display: inline-block;
    }

    .approve-btn {
        background: var(--success-color);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .approve-btn:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .preview-btn {
        background: var(--galaxy-light);
        color: var(--galaxy-primary);
        border: none;
        padding: 0.5rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .preview-btn:hover {
        background: var(--galaxy-accent);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .empty-row td {
        padding: 3rem 1rem;
    }

    .empty-state {
        text-align: center;
    }

    .empty-content {
        color: #6b7280;
    }

    .empty-content i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }

    .empty-content h4 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--galaxy-dark);
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

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }

    .modal-content {
        background-color: white;
        margin: 5% auto;
        border-radius: 16px;
        width: 90%;
        max-width: 500px;
        box-shadow: var(--shadow-xl);
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        color: var(--galaxy-dark);
        font-size: 1.25rem;
        font-weight: 600;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6b7280;
        padding: 0.5rem;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .close-btn:hover {
        background: #f3f4f6;
        color: var(--galaxy-dark);
    }

    .modal-body {
        padding: 2rem 1.5rem;
        text-align: center;
    }

    .confirmation-icon {
        margin-bottom: 1rem;
    }

    .confirmation-icon i {
        font-size: 3rem;
        color: var(--success-color);
    }

    .modal-body p {
        color: #6b7280;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .modal-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    .cancel-btn,
    .confirm-btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .cancel-btn {
        background: #f3f4f6;
        color: var(--galaxy-dark);
    }

    .cancel-btn:hover {
        background: #e5e7eb;
    }

    .confirm-btn {
        background: var(--success-color);
        color: white;
    }

    .confirm-btn:hover:not(:disabled) {
        background: #059669;
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }

    .confirm-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .order-approval-container {
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

        .table-actions {
            flex-direction: column;
            gap: 0.5rem;
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

        .actions-cell {
            flex-direction: column;
            gap: 0.25rem;
        }

        .approve-btn .btn-text {
            display: none;
        }

        .modal-content {
            margin: 10% auto;
            width: 95%;
        }
    }
</style>

<script>
    // Thiết lập CSRF cho mọi request AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let currentOrderId = null;
    let currentCustomerName = null;

    // Select all functionality
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const orderCheckboxes = document.querySelectorAll('.order-checkbox');

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                orderCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkApproveButton();
            });
        }

        orderCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkApproveButton);
        });
    });

    function updateBulkApproveButton() {
        const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
        const bulkBtn = document.getElementById('bulkApproveBtn');
        const countSpan = document.getElementById('selectedCount');

        if (bulkBtn && countSpan) {
            countSpan.textContent = checkedBoxes.length;
            bulkBtn.disabled = checkedBoxes.length === 0;
        }
    }

    function confirmApproval(orderId, customerName) {
        currentOrderId = orderId;
        currentCustomerName = customerName;

        document.getElementById('orderIdText').textContent = '#' + orderId;
        document.getElementById('customerNameText').textContent = customerName;
        document.getElementById('approvalModal').style.display = 'block';

        return false; // Prevent form submission
    }

    function confirmApprovalAction() {
        if (currentOrderId) {
            // Submit the form
            const form = document.querySelector(`form[action*="${currentOrderId}"]`);
            if (form) {
                form.submit();
            }
        }
        closeModal();
    }

    function closeModal() {
        document.getElementById('approvalModal').style.display = 'none';
        currentOrderId = null;
        currentCustomerName = null;
    }

    function showBulkApproveModal() {
        const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
        if (checkedBoxes.length === 0) {
            alert('Vui lòng chọn ít nhất một đơn hàng để duyệt.');
            return;
        }

        const selectedOrdersList = document.getElementById('selectedOrdersList');
        selectedOrdersList.innerHTML = '';

        checkedBoxes.forEach(checkbox => {
            const row = checkbox.closest('tr');
            const orderId = checkbox.value;
            const customerName = row.querySelector('.customer-name').textContent;

            const orderItem = document.createElement('div');
            orderItem.className = 'selected-order-item';
            orderItem.innerHTML = `<strong>#${orderId}</strong> - ${customerName}`;
            selectedOrdersList.appendChild(orderItem);
        });

        document.getElementById('bulkApprovalModal').style.display = 'block';
    }

    function closeBulkModal() {
        document.getElementById('bulkApprovalModal').style.display = 'none';
    }

    function processBulkApproval() {
        const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
        const orderIds = Array.from(checkedBoxes).map(cb => cb.value);

        if (orderIds.length === 0) return;

        // Duyệt hàng loạt bằng AJAX
        $.ajax({
            url: '{{ route("api.orders.bulkApprove") }}',
            method: 'POST',
            data: {
                order_ids: orderIds
            },
            success: function(response) {
                closeBulkModal();
                if (response.success || response.status === 'success') {
                    alert(response.message || 'Đã duyệt thành công!');
                    window.location.reload();
                } else {
                    alert(response.error || 'Có lỗi xảy ra!');
                }
            },
            error: function(xhr) {
                closeBulkModal();
                alert('Có lỗi xảy ra khi duyệt đơn hàng!');
            }
        });
    }

    function showOrderPreview(orderId) {
        // Implement order preview functionality
        alert(`Xem chi tiết đơn hàng #${orderId}`);
    }

    // Close modals when clicking outside
    window.addEventListener('click', function(event) {
        const approvalModal = document.getElementById('approvalModal');
        const bulkModal = document.getElementById('bulkApprovalModal');

        if (event.target === approvalModal) {
            closeModal();
        }
        if (event.target === bulkModal) {
            closeBulkModal();
        }
    });
</script>

@endsection