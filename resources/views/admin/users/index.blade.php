@extends('admin.layouts.app')
@section('title', 'Quản lý khách hàng')

@section('content')
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

    .table-wrapper {
        padding: 24px;
        background: linear-gradient(135deg, #f8faff 0%, #eef3ff 100%);
        min-height: 100vh;
    }

    .table-header-customer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding: 20px 24px;
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(30, 58, 138, 0.08);
    }

    .main-title {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        background: var(--galaxy-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        color: var(--galaxy-primary);
    }

    .customer-search {
        position: relative;
        display: flex !important;
        align-items: center;
        background: white;
        border: 2px solid var(--galaxy-light);
        border-radius: 12px;
        padding: 2px;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
    }

    .customer-search:focus-within {
        border-color: var(--galaxy-accent);
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .customer-text-search {
        border: none;
        outline: none;
        padding: 12px 16px;
        font-size: 14px;
        border-radius: 10px;
        width: 280px;
        background: transparent;
        color: var(--galaxy-dark);
    }

    .customer-text-search::placeholder {
        color: #94a3b8;
    }

    .customer-search button {
        padding: 12px 16px !important;
        background: var(--galaxy-gradient) !important;
        border: none !important;
        border-radius: 10px;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-left: 4px;
    }

    .customer-search button:hover {
        background: var(--galaxy-gradient-hover) !important;
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
    }

    .table-container {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(30, 58, 138, 0.08);
    }

    .table-container table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .table-container th {
        background: var(--galaxy-gradient);
        color: white;
        padding: 16px 20px;
        text-align: left;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }

    .table-container td {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        color: var(--galaxy-dark);
        transition: all 0.2s ease;
    }

    .table-container tr:hover td {
        background: linear-gradient(135deg, #f8faff 0%, #eef7ff 100%);
        transform: scale(1.01);
    }

    .table-container tr:last-child td {
        border-bottom: none;
    }

    .icon-change {
        background-color: #2563eb;
        border: none;
        color: var(--galaxy-accent);
        cursor: pointer;
        padding: 10px;
        margin-right: 8px;
        font-size: 16px;
        border-radius: 8px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .icon-change::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: var(--galaxy-gradient);
        transition: left 0.3s ease;
        z-index: -1;
        opacity: 0.1;
    }

    .icon-change:hover::before {
        left: 0;
    }

    .icon-change:hover {
        color: rgb(255, 255, 255);
        background: var(--galaxy-gradient);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .lock-btn {
        background: none;
        border: none;
        color: #d97706;
        cursor: pointer;
        padding: 8px 12px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .lock-btn:hover {
        background: rgba(217, 119, 6, 0.1);
        transform: translateY(-1px);
    }

    /* Modal modern styling */
    .modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(30, 58, 138, 0.4);
        backdrop-filter: blur(8px);
        align-items: center;
        justify-content: center;
        z-index: 2000;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .modal .modal-card {
        background: white;
        width: 450px;
        border-radius: 20px;
        padding: 28px;
        box-shadow: var(--shadow-xl);
        position: relative;
        border: 1px solid rgba(255, 255, 255, 0.2);
        animation: slideUp 0.3s ease;
    }

    .modal .modal-card h3 {
        margin: 0 0 12px;
        font-size: 22px;
        font-weight: 700;
        color: var(--galaxy-primary);
    }

    .modal .modal-card p {
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 24px;
    }

    .modal .modal-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 10px;
        border: 2px solid transparent;
        background: #f8fafc;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.5s ease;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-primary {
        background: var(--galaxy-gradient);
        color: white;
        border-color: var(--galaxy-accent);
    }

    .btn-primary:hover {
        background: var(--galaxy-gradient-hover);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border-color: #ef4444;
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
    }

    /* Toast messages */
    .toast-message {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
        padding: 10px 16px;
        border-radius: 8px;
        color: white;
        z-index: 3000;
        box-shadow: var(--shadow-lg);
        animation: slideInFade 0.3s ease;
        backdrop-filter: blur(10px);
        max-width: 200px;
        width: max-content;
        font-size: 14px;
        text-align: center;
        word-wrap: break-word;
        white-space: normal;
    }

    /* Hiệu ứng xuất hiện */
    @keyframes slideInFade {
        from {
            opacity: 0;
            transform: translate(-50%, -60%);
        }

        to {
            opacity: 1;
            transform: translate(-50%, -50%);
        }
    }

    /* Thành công */
    .toast-success {
        background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Lỗi */
    .toast-error {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Pagination modern styling */
    .pagination {
        margin-top: 24px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        padding: 20px;
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-md);
    }

    .pagination a,
    .pagination span {
        padding: 10px 16px;
        border: 2px solid var(--galaxy-light);
        border-radius: 10px;
        text-decoration: none;
        color: var(--galaxy-primary);
        transition: all 0.3s ease;
        background: white;
        font-weight: 500;
        position: relative;
        overflow: hidden;
    }

    .pagination a::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: var(--galaxy-gradient);
        transition: left 0.3s ease;
        z-index: -1;
    }

    .pagination a:hover::before {
        left: 0;
    }

    .pagination a:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--galaxy-accent);
    }

    .pagination span[aria-current="page"] {
        background: var(--galaxy-gradient) !important;
        color: white !important;
        border-color: var(--galaxy-accent);
        box-shadow: var(--shadow-md);
    }

    .pagination span:not([aria-current]) {
        color: #94a3b8;
        border-color: #e2e8f0;
    }

    /* Status badges */
    .status-locked {
        color: #ef4444;
        font-size: 12px;
        margin-left: 8px;
        padding: 4px 8px;
        background: rgba(239, 68, 68, 0.1);
        border-radius: 6px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Close button styling */
    .close-lock-modal {
        position: absolute !important;
        right: 16px !important;
        top: 12px !important;
        font-size: 24px !important;
        background: none !important;
        border: none !important;
        color: #94a3b8;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .close-lock-modal:hover {
        background: rgba(239, 68, 68, 0.1) !important;
        color: #ef4444;
        transform: rotate(90deg);
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .table-header-customer {
            flex-direction: column;
            gap: 16px;
            align-items: stretch;
        }

        .customer-text-search {
            width: 100%;
        }

        .modal .modal-card {
            width: 90%;
            margin: 0 20px;
        }

        .table-container {
            overflow-x: auto;
        }
    }
</style>

<div class="table-wrapper">
    <div class="table-header table-header-customer">
        <h3 class="main-title">Thông tin khách hàng</h3>
        <form method="GET" action="" class="customer-search">
            <input type="text" name="search" value="{{ request('search') }}" class="customer-text-search" placeholder="Tìm kiếm khách hàng...">
            <button type="submit" class="fa-solid fa-magnifying-glass"></button>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Ngày sinh</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->date_of_birth }}</td>
                    <td>{{ $user->address }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @php $locked = (isset($user->is_locked) && $user->is_locked); @endphp
                        <button type="button"
                            class="icon-change lock-customer-btn"
                            data-customer-id="{{ $user->id }}"
                            data-username="{{ $user->username }}"
                            data-locked="{{ $locked ? '1' : '0' }}"
                            title="{{ $locked ? 'Mở khóa tài khoản' : 'Khóa tài khoản' }}">
                            {{ $locked ? '🔓' : '🔒' }}
                        </button>

                        @if($locked)
                        <span class="status-locked">Đã khóa</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- pagination custom -->
        @php
        $currentPage = $users->currentPage();
        $lastPage = $users->lastPage();
        $baseUrl = url()->current();
        // preserve all existing query params except 'page'
        $preserve = request()->except('page');
        @endphp

        @if ($lastPage > 1)
        <div class="pagination" aria-label="Pagination">
            {{-- Prev --}}
            @if ($users->onFirstPage())
            <span>&laquo; Trang trước</span>
            @else
            @php
            $prevPage = $currentPage - 1;
            $params = $preserve;
            if ($prevPage > 1) $params['page'] = $prevPage;
            $prevUrl = $baseUrl . (count($params) ? '?' . http_build_query($params) : '');
            @endphp
            <a href="{{ $prevUrl }}">&laquo; Trang trước</a>
            @endif

            {{-- If first page not in window, show 1 --}}
            @php
            $start = max(1, $currentPage - 2);
            $end = min($lastPage, $currentPage + 2);
            @endphp

            @if ($start > 1)
            @php
            $paramsFirst = $preserve;
            // page 1 -> don't add 'page'
            $firstUrl = $baseUrl . (count($paramsFirst) ? '?' . http_build_query($paramsFirst) : '');
            @endphp
            <a href="{{ $firstUrl }}">1</a>
            @if ($start > 2)
            <span>…</span>
            @endif
            @endif

            {{-- Page numbers --}}
            @for ($i = $start; $i <= $end; $i++)
                @php
                $paramsI=$preserve;
                if ($i> 1) $paramsI['page'] = $i;
                $urlI = $baseUrl . (count($paramsI) ? '?' . http_build_query($paramsI) : '');
                @endphp

                @if ($i == $currentPage)
                <span aria-current="page">{{ $i }}</span>
                @else
                <a href="{{ $urlI }}">{{ $i }}</a>
                @endif
                @endfor

                @if ($end < $lastPage)
                    @if ($end < $lastPage - 1)
                    <span>…</span>
                    @endif
                    @php
                    $paramsLast = $preserve;
                    $paramsLast['page'] = $lastPage;
                    $lastUrl = $baseUrl . (count($paramsLast) ? '?' . http_build_query($paramsLast) : '');
                    @endphp
                    <a href="{{ $lastUrl }}">{{ $lastPage }}</a>
                    @endif

                    {{-- Next --}}
                    @if ($users->hasMorePages())
                    @php
                    $nextPage = $currentPage + 1;
                    $paramsNext = $preserve;
                    if ($nextPage > 1) $paramsNext['page'] = $nextPage;
                    $nextUrl = $baseUrl . (count($paramsNext) ? '?' . http_build_query($paramsNext) : '');
                    @endphp
                    <a href="{{ $nextUrl }}">Trang sau &raquo;</a>
                    @else
                    <span>Trang sau &raquo;</span>
                    @endif
        </div>
        @endif

    </div>
</div>

{{-- Lock / Unlock Modal --}}
<div id="lockCustomerModal" class="modal" aria-hidden="true">
    <div class="modal-card" role="dialog" aria-modal="true">
        <button type="button" class="close-lock-modal">&times;</button>
        <h3 id="lockModalTitle">Khóa tài khoản</h3>
        <p id="lockModalBody">Bạn có chắc chắn muốn khóa tài khoản <strong id="lockCustomerName">—</strong> không?</p>

        <form id="lockCustomerForm" method="POST" action="">
            @csrf
            @method('PUT')
            <input type="hidden" name="page" value="{{ request('page', 1) }}">
            <div class="modal-actions">
                <button type="button" class="btn" id="cancelLockBtn">Hủy</button>
                <button type="submit" class="btn btn-danger" id="confirmLockBtn">Xác nhận</button>
            </div>
        </form>
    </div>
</div>

{{-- Toasts --}}
<div id="toast-customer-success" class="toast-message toast-success"><span class="toast-text"></span></div>
<div id="toast-customer-error" class="toast-message toast-error"><span class="toast-text"></span></div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lockButtons = document.querySelectorAll('.lock-customer-btn');
        const modal = document.getElementById('lockCustomerModal');
        const lockCustomerName = document.getElementById('lockCustomerName');
        const lockForm = document.getElementById('lockCustomerForm');
        const cancelBtn = document.getElementById('cancelLockBtn');
        const closeBtn = document.querySelector('.close-lock-modal');
        const toastSuccess = document.getElementById('toast-customer-success');
        const toastError = document.getElementById('toast-customer-error');

        const baseUrl = "{{ url('/admin/users') }}"; // Đường dẫn đến route xử lý
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '{{ csrf_token() }}';

        let willLock = true; // mặc định

        function showToast(type, message, duration = 2200) {
            const el = type === 'success' ? toastSuccess : toastError;
            el.querySelector('.toast-text').innerText = message;
            el.style.display = 'block';
            setTimeout(() => el.style.display = 'none', duration);
        }

        function openModal(id, username, locked) {
            lockCustomerName.innerText = username;
            willLock = (locked === '0'); // nếu chưa bị khóa thì sẽ khóa, ngược lại sẽ mở

            if (!willLock) {
                document.getElementById('lockModalTitle').innerText = 'Mở khóa tài khoản';
                document.getElementById('lockModalBody').innerHTML = `Bạn có chắc chắn muốn mở khóa tài khoản <strong>${username}</strong> không?`;
                document.getElementById('confirmLockBtn').innerText = 'Mở khóa';
            } else {
                document.getElementById('lockModalTitle').innerText = 'Khóa tài khoản';
                document.getElementById('lockModalBody').innerHTML = `Bạn có chắc chắn muốn khóa tài khoản <strong>${username}</strong> không?`;
                document.getElementById('confirmLockBtn').innerText = 'Khóa tài khoản';
            }

            lockForm.action = `${baseUrl}/${id}/lock`;
            modal.style.display = 'flex';
            modal.setAttribute('aria-hidden', 'false');
        }

        function closeModal() {
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
        }

        lockButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.customerId;
                const username = this.dataset.username;
                const locked = this.dataset.locked;
                openModal(id, username, locked);
            });
        });

        cancelBtn.addEventListener('click', closeModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', e => {
            if (e.target === modal) closeModal();
        });
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeModal();
        });

        lockForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const url = this.action;
            const submitBtn = document.getElementById('confirmLockBtn');
            submitBtn.disabled = true;
            submitBtn.innerText = 'Đang xử lý...';

            fetch(url, {
                    method: 'PUT',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        lock: willLock
                    })
                })
                .then(async res => {
                    const json = await res.json().catch(() => null);
                    if (!res.ok) throw {
                        status: res.status,
                        json
                    };
                    return json;
                })
                .then(data => {
                    showToast('success', data.message || 'Thao tác thành công');
                    closeModal();
                    setTimeout(() => location.reload(), 600);
                })
                .catch(err => {
                    console.error(err);
                    let msg = 'Có lỗi xảy ra';
                    if (err.json && err.json.message) msg = err.json.message;
                    showToast('error', msg);
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'Xác nhận';
                });
        });
    });
</script>
@endpush


@endsection