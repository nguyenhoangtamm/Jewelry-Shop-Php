@extends('admin.layouts.app')

@section('title', 'Quản lý đánh giá')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<div class="alert alert-galaxy-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle mr-2"></i>
    {{ session('success') }}
    <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<style>
    /* Galaxy 
    
    lue Theme Styles */
    .galaxy-blue-gradient {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    }

    .galaxy-blue {
        background-color: #1e3a8a;
    }

    .galaxy-blue-light {
        background-color: #3b82f6;
    }

    .galaxy-blue-dark {
        background-color: #1e40af;
    }

    .text-galaxy-blue {
        color: #1e3a8a;
    }

    .border-galaxy-blue {
        border-color: #1e3a8a;
    }

    /* Enhanced Typography */
    body,
    .card-body {
        font-size: 16px;
        line-height: 1.6;
    }

    .table {
        font-size: 15px;
    }

    .table th {
        font-size: 14px;
        font-weight: 700;
    }

    .table td {
        font-size: 15px;
    }

    h1,
    .h1 {
        font-size: 2.5rem;
        font-weight: 700;
    }

    h6,
    .h6 {
        font-size: 1.25rem;
        font-weight: 600;
    }

    .btn {
        font-size: 15px;
        font-weight: 600;
    }

    .form-control {
        font-size: 15px;
    }

    .badge {
        font-size: 13px;
    }

    /* Custom Card Styles */
    .custom-card {
        border: none;
        box-shadow: 0 0.5rem 1.5rem rgba(30, 58, 138, 0.15);
        border-radius: 20px;
        background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    }

    .custom-card-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        border-radius: 20px 20px 0 0;
        border: none;
        padding: 20px;
    }

    /* Button Styles */
    .btn-galaxy {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        border: none;
        border-radius: 15px;
        color: white;
        font-weight: 600;
        padding: 12px 24px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
        font-size: 15px;
    }

    .btn-galaxy:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(30, 58, 138, 0.4);
        color: white;
    }

    .btn-galaxy-outline {
        background: transparent;
        border: 2px solid #1e3a8a;
        border-radius: 15px;
        color: #1e3a8a;
        font-weight: 600;
        padding: 10px 24px;
        transition: all 0.3s ease;
        font-size: 15px;
    }

    .btn-galaxy-outline:hover {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(30, 58, 138, 0.4);
    }

    .btn-rounded {
        border-radius: 15px;
    }

    .btn-sm-rounded {
        border-radius: 12px;
        padding: 10px 16px;
        font-size: 14px;
        font-weight: 600;
    }

    /* Action Button Styles */
    .btn-action-view {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        border: none;
        color: white;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        transition: all 0.3s ease;
    }

    .btn-action-view:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 8px 20px rgba(5, 150, 105, 0.4);
        color: white;
    }

    .btn-action-delete {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        border: none;
        color: white;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        transition: all 0.3s ease;
    }

    .btn-action-delete:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 8px 20px rgba(220, 38, 38, 0.4);
        color: white;
    }

    .btn-action-restore {
        background: linear-gradient(135deg, #0ea5e9 0%, #3b82f6 100%);
        border: none;
        color: white;
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        transition: all 0.3s ease;
    }

    .btn-action-restore:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 8px 20px rgba(14, 165, 233, 0.4);
        color: white;
    }

    .btn-inline-group {
        display: inline-flex;
        gap: 6px;
        /* khoảng cách giữa các nút */
        flex-wrap: nowrap;
        align-items: center;
    }

    .btn-inline-group form {
        margin: 0;
    }

    .btn-inline-group .btn {
        border-radius: 8px;
        min-width: 36px;
        /* nhỏ hơn */
        height: 36px;
        /* nhỏ hơn */
        padding: 6px 8px;
        font-size: 0.95rem;
        /* giảm kích thước chữ/icon */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* make icons inside action buttons smaller */
    .btn-inline-group .btn i {
        font-size: 14px;
        line-height: 1;
    }

    /* Narrow the status and action columns to save horizontal space */
    .table-galaxy tbody td:nth-child(7),
    .table-galaxy tbody td:nth-child(8) {
        white-space: nowrap;
        width: 120px;
        max-width: 140px;
        vertical-align: middle;
        text-align: center;
        padding: 12px 8px;
    }

    /* make status badges more compact in that column */
    .table-galaxy tbody td:nth-child(7) .badge-rounded {
        padding: 6px 10px;
        font-size: 12px;
    }

    /* Form Styles */
    .form-control-rounded {
        border-radius: 15px;
        border: 2px solid #e5e7eb;
        padding: 14px 18px;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.9);
        font-size: 15px;
    }

    .form-control-rounded:focus {
        border-color: #1e3a8a;
        box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
        background: white;
    }

    /* Table Styles */
    .table-galaxy {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        font-size: 15px;
    }

    .table-galaxy thead th {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
        border: none;
        padding: 18px 16px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 14px;
        letter-spacing: 0.5px;
    }

    .table-galaxy tbody tr {
        transition: all 0.3s ease;
        background: white;
    }

    .table-galaxy tbody tr:hover {
        background: rgba(30, 58, 138, 0.05);
        transform: scale(1.01);
    }

    .table-galaxy tbody td {
        padding: 18px 16px;
        border: 1px solid #f1f5f9;
        vertical-align: middle;
        font-size: 15px;
    }

    /* Alert Styles */
    .alert-galaxy-success {
        background: linear-gradient(135deg, #059669 0%, #34d399 100%);
        border: none;
        border-radius: 15px;
        color: white;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        font-size: 15px;
    }

    .alert-galaxy-danger {
        background: linear-gradient(135deg, #dc2626 0%, #f87171 100%);
        border: none;
        border-radius: 15px;
        color: white;
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        font-size: 15px;
    }

    /* Badge Styles */
    .badge-rounded {
        border-radius: 12px;
        padding: 10px 14px;
        font-weight: 600;
        font-size: 13px;
        display: inline-flex;
        /* keep icon and text on single line */
        align-items: center;
        gap: 8px;
        /* space between icon and text */
        white-space: nowrap;
        /* prevent text from wrapping to next line */
        line-height: 1;
    }

    .badge-galaxy-success {
        background: linear-gradient(135deg, #059669 0%, #34d399 100%);
        color: white;
    }

    .badge-galaxy-danger {
        background: linear-gradient(135deg, #dc2626 0%, #f87171 100%);
        color: white;
    }

    /* Image Styles */
    .product-image {
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .product-image:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    /* Star Rating */
    .star-rating .fas.fa-star {
        color: #ffd700;
        filter: drop-shadow(0 2px 4px rgba(255, 215, 0, 0.3));
    }

    .star-rating .far.fa-star {
        color: #e0e0e0;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
        padding: 35px;
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 8px 25px rgba(30, 58, 138, 0.3);
    }

    /* Filter Section */
    .filter-section {
        background: rgba(30, 58, 138, 0.05);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 25px;
        border: 1px solid rgba(30, 58, 138, 0.1);
    }

    /* Responsive improvements */
    @media (max-width: 768px) {
        .custom-card {
            border-radius: 15px;
        }

        .page-header {
            border-radius: 15px;
            padding: 20px;
        }

        .filter-section {
            border-radius: 15px;
            padding: 15px;
        }
    }
</style>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="page-header">
        <h1 class="h3 mb-0 font-weight-bold">🌟 Quản lý đánh giá</h1>
        <p class="mb-0 mt-2 opacity-75">Theo dõi và quản lý tất cả đánh giá từ khách hàng</p>
    </div>

    @if(session('success'))
    <div class="alert alert-galaxy-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('success') }}
        <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-galaxy-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle mr-2"></i>
        {{ session('error') }}
        <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card custom-card">
                <div class="card-header custom-card-header">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-star mr-2"></i>
                        Danh sách đánh giá
                    </h6>
                </div>
                <div class="card-body" style="padding: 30px;">
                    <!-- Filters -->
                    <div class="filter-section">
                        <form method="GET" action="{{ route('admin.reviews.index') }}">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="text-galaxy-blue font-weight-bold mb-2">
                                        <i class="fas fa-search mr-1"></i>Tìm kiếm
                                    </label>
                                    <input type="text" class="form-control form-control-rounded" name="search"
                                        placeholder="Nhập nội dung cần tìm..." value="{{ $search }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="text-galaxy-blue font-weight-bold mb-2">
                                        <i class="fas fa-gem mr-1"></i>Sản phẩm
                                    </label>
                                    <select class="form-control form-control-rounded" name="jewelry_id">
                                        <option value="">-- Tất cả sản phẩm --</option>
                                        @foreach($jewelries as $jewelry)
                                        <option value="{{ $jewelry->id }}" {{ $jewelry_id == $jewelry->id ? 'selected' : '' }}>
                                            {{ $jewelry->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="text-galaxy-blue font-weight-bold mb-2">
                                        <i class="fas fa-star mr-1"></i>Đánh giá
                                    </label>
                                    <select class="form-control form-control-rounded" name="rating">
                                        <option value="">-- Tất cả rating --</option>
                                        <option value="5" {{ $rating == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 5 sao</option>
                                        <option value="4" {{ $rating == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ 4 sao</option>
                                        <option value="3" {{ $rating == 3 ? 'selected' : '' }}>⭐⭐⭐ 3 sao</option>
                                        <option value="2" {{ $rating == 2 ? 'selected' : '' }}>⭐⭐ 2 sao</option>
                                        <option value="1" {{ $rating == 1 ? 'selected' : '' }}>⭐ 1 sao</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="text-galaxy-blue font-weight-bold mb-2">Thao tác</label>
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-galaxy mr-2">
                                            <i class="fas fa-filter mr-1"></i>Lọc
                                        </button>
                                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-galaxy-outline">
                                            <i class="fas fa-redo mr-1"></i>Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Reviews Table -->
                    <div class="table-responsive">
                        <table class="table table-galaxy">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag mr-1"></i>ID</th>
                                    <th><i class="fas fa-user mr-1"></i>Người dùng</th>
                                    <th><i class="fas fa-gem mr-1"></i>Sản phẩm</th>
                                    <th><i class="fas fa-star mr-1"></i>Rating</th>
                                    <th><i class="fas fa-comment mr-1"></i>Nội dung</th>
                                    <th><i class="fas fa-calendar mr-1"></i>Ngày tạo</th>
                                    <th><i class="fas fa-info-circle mr-1"></i>Trạng thái</th>
                                    <th><i class="fas fa-cogs mr-1"></i>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $review)
                                <tr class="{{ $review->is_deleted ? 'table-secondary' : '' }}">
                                    <td>
                                        <span class="badge badge-light badge-rounded">
                                            #{{ $review->id }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-galaxy-blue text-white rounded-circle d-flex align-items-center justify-content-center mr-3"
                                                style="width: 40px; height: 40px; font-weight: bold;">
                                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-galaxy-blue">{{ $review->user->name }}</div>
                                                <small class="text-muted">{{ $review->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($review->jewelry && $review->jewelry->jewelryFiles->count() > 0)
                                            <img src="{{$review->image}}"
                                                alt="{{ $review->jewelry->name }}"
                                                class="product-image mr-3"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <div class="font-weight-bold">{{ $review->jewelry->name ?? 'Sản phẩm đã bị xóa' }}</div>
                                                @if($review->jewelry)
                                                <small class="text-galaxy-blue">
                                                    <a href="{{ route('admin.reviews.by-product', $review->jewelry->id) }}"
                                                        class="text-decoration-none text-galaxy-blue">
                                                        <i class="fas fa-eye mr-1"></i>Xem tất cả đánh giá
                                                    </a>
                                                </small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="star-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <=$review->rating)
                                                <i class="fas fa-star"></i>
                                                @else
                                                <i class="far fa-star"></i>
                                                @endif
                                                @endfor
                                                <div><small class="text-muted font-weight-bold">({{ $review->rating }}/5)</small></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="bg-light p-3 rounded" style="max-width: 250px;">
                                            <p class="mb-0" style="font-size: 0.9rem; line-height: 1.4;">
                                                {{ Str::limit($review->content, 100) }}
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <div class="font-weight-bold">{{ $review->created_at->format('d/m/Y') }}</div>
                                            <small class="text-muted">{{ $review->created_at->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if($review->is_deleted)
                                        <span class="badge badge-galaxy-danger badge-rounded">
                                            <i class="fas fa-trash mr-1"></i>Đã xóa
                                        </span>
                                        @else
                                        <span class="badge badge-galaxy-success badge-rounded">
                                            <i class="fas fa-check mr-1"></i>Hoạt động
                                        </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-inline-group">
                                            <a href="{{ route('admin.reviews.show', $review->id) }}"
                                                class="btn btn-action-view btn-sm" title="Xem chi tiết">
                                                <i class="fas fa-eye fa-lg"></i>
                                            </a>

                                            @if(!$review->is_deleted)
                                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-action-delete btn-sm btn-delete" title="Xóa">
                                                    <i class="fas fa-trash fa-lg"></i>
                                                </button>

                                            </form>
                                            @else
                                            <form action="{{ route('admin.reviews.restore', $review->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-action-restore btn-sm"
                                                    title="Khôi phục">
                                                    <i class="fas fa-undo fa-lg"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.reviews.force-delete', $review->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-action-delete btn-sm btn-force-delete" title="Xóa vĩnh viễn">
                                                    <i class="fas fa-times fa-lg"></i>
                                                </button>

                                            </form>
                                            @endif
                                        </div>
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-galaxy-blue">
                                            <i class="fas fa-star fa-3x mb-3 opacity-50"></i>
                                            <h5>Không có đánh giá nào</h5>
                                            <p class="text-muted">Chưa có đánh giá nào được tìm thấy với bộ lọc hiện tại.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        <div class="pagination-wrapper">
                            {{ $reviews->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xóa mềm
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                let form = this.closest('form');
                Swal.fire({
                    title: 'Bạn có chắc?',
                    text: "Đánh giá sẽ bị xóa tạm thời!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Xóa vĩnh viễn
        document.querySelectorAll('.btn-force-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                let form = this.closest('form');
                Swal.fire({
                    title: 'Xóa vĩnh viễn?',
                    text: "Hành động này không thể hoàn tác!",
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#b91c1c',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Xóa vĩnh viễn',
                    cancelButtonText: 'Hủy',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

<style>
    /* Custom Pagination Styles */
    .pagination-wrapper .pagination {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
    }

    .pagination-wrapper .page-link {
        color: #1e3a8a;
        background-color: white;
        border: 1px solid #e5e7eb;
        padding: 14px 18px;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 15px;
    }

    .pagination-wrapper .page-link:hover {
        color: white;
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        border-color: #1e3a8a;
        transform: translateY(-1px);
    }

    .pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        border-color: #1e3a8a;
        box-shadow: 0 4px 10px rgba(30, 58, 138, 0.3);
    }

    .pagination-wrapper .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #f8f9fa;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Nếu có thông báo thành công
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
        @endif

        // Nếu có thông báo lỗi
        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true
        });
        @endif
    });
</script>

@endsection