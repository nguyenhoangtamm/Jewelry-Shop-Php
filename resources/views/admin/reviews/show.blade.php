@extends('admin.layouts.app')

@section('title', 'Chi tiết đánh giá #' . $review->id)

@section('content')
<style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        color: #2c3e50;
        line-height: 1.6;
    }

    .container-fluid {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Header Styles */
    .page-header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        padding: 30px;
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 15px 35px rgba(30, 60, 114, 0.2);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: shimmer 3s ease-in-out infinite;
    }

    @keyframes shimmer {
        0%, 100% { transform: translateX(-100%); }
        50% { transform: translateX(100%); }
    }

.page-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
    text-shadow: 2px 2px 4px rgb(184, 212, 246);
    position: relative;
    z-index: 1;
    color: white; /* Chữ màu trắng */
}

    .d-sm-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
        position: relative;
        z-index: 1;
    }

    /* Card Styles */
    .card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: none;
        overflow: hidden;
        transition: all 0.3s ease;
        margin-bottom: 30px;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .card-header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        padding: 20px 30px;
        border: none;
        font-weight: 600;
        font-size: 1.2rem;
        position: relative;
    }
.card-header,
.card-header * {
    color: white !important;
}

    .card-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #ffd700, #ff6b6b, #4ecdc4);
    }

    .card-body {
        padding: 30px;
    }

    /* Button Styles */
    .btn {
        border: none;
        padding: 12px 25px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        font-size: 14px;
        position: relative;
        overflow: hidden;
        color: white;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        color: white;
        text-decoration: none;
    }

    .btn:active {
        transform: translateY(0);
    }

    /* Info Button */
    .btn-info {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    }

    .btn-info:hover {
        background: linear-gradient(135deg, #2980b9 0%, #3498db 100%);
        box-shadow: 0 10px 25px rgba(52, 152, 219, 0.4);
    }

    /* Warning Button */
    .btn-warning {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(243, 156, 18, 0.3);
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, #e67e22 0%, #f39c12 100%);
        box-shadow: 0 10px 25px rgba(243, 156, 18, 0.4);
    }

    /* Success Button */
    .btn-success {
        background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
        box-shadow: 0 10px 25px rgba(39, 174, 96, 0.4);
    }

    /* Danger Button */
    .btn-danger {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
        box-shadow: 0 10px 25px rgba(231, 76, 60, 0.4);
    }

    /* Secondary Button */
    .btn-secondary {
        background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(149, 165, 166, 0.3);
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #7f8c8d 0%, #95a5a6 100%);
        box-shadow: 0 10px 25px rgba(149, 165, 166, 0.4);
    }

    .btn-block {
        width: 100%;
        margin-bottom: 15px;
    }

    .mr-2 {
        margin-right: 15px;
    }

    /* Alert Styles */
    .alert {
        border: none;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
        position: relative;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
        border-left: 5px solid #28a745;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
        border-left: 5px solid #dc3545;
    }

    .alert-dismissible .close {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: inherit;
        cursor: pointer;
        padding: 0;
        margin: 0;
        position: absolute;
        top: 15px;
        right: 20px;
    }

    /* Review Info Styles */
    .row.mb-3 {
        display: flex;
        padding: 15px 0;
        border-bottom: 1px solid #ecf0f1;
        transition: background 0.3s ease;
        margin-bottom: 0;
    }

    .row.mb-3:hover {
        background: rgba(30, 60, 114, 0.02);
        border-radius: 10px;
        padding-left: 15px;
        padding-right: 15px;
    }

    .row.mb-3:last-child {
        border-bottom: none;
    }

    .col-sm-3 {
        font-weight: 600;
        color: #2c3e50;
        flex: 0 0 200px;
        padding-right: 20px;
    }

    .col-sm-9 {
        flex: 1;
        color: #34495e;
    }

    /* Rating Stars */
    .text-warning {
        color: #f39c12 !important;
        font-size: 1.2rem;
        margin-bottom: 10px;
    }

    .text-dark {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white !important;
        padding: 5px 15px;
        border-radius: 20px;
        display: inline-block;
        font-weight: 600;
        margin-left: 10px;
    }

    /* Content Box */
    .bg-light.p-3.rounded {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
        border-left: 4px solid #2a5298;
        padding: 20px !important;
        border-radius: 15px !important;
        font-style: italic;
        position: relative;
    }

    .bg-light.p-3.rounded::before {
        content: '"';
        font-size: 4rem;
        color: #2a5298;
        position: absolute;
        top: -10px;
        left: 15px;
        opacity: 0.3;
    }

    /* Badge Styles */
    .badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .badge-success {
        background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
        color: white;
        box-shadow: 0 3px 10px rgba(39, 174, 96, 0.3);
    }

    .badge-danger {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
        box-shadow: 0 3px 10px rgba(231, 76, 60, 0.3);
    }

    .badge-lg {
        font-size: 1rem;
        padding: 10px 20px;
    }

    /* Product/User Info */
    .d-flex.align-items-center {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .rounded {
        border-radius: 15px !important;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        transition: transform 0.3s ease;
    }

    .rounded:hover {
        transform: scale(1.05);
    }

    .font-weight-bold {
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .text-muted {
        color: #7f8c8d !important;
        font-size: 0.9rem;
    }

    /* Grid Layout */
    .row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        margin: 0;
    }

    .col-lg-8, .col-lg-4 {
        padding: 0;
    }

    /* Statistics */
    .text-center {
        text-align: center;
        padding: 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        margin-bottom: 20px;
        border: 2px solid #ecf0f1;
        transition: all 0.3s ease;
    }

    .text-center:hover {
        border-color: #2a5298;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .h4 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2a5298;
        display: block;
        margin-bottom: 5px;
    }

    .small {
        background: white;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .d-flex.justify-content-between {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #ecf0f1;
    }

    .d-flex.justify-content-between:last-child {
        border-bottom: none;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 15px;
        }

        .page-header {
            padding: 20px;
        }

        .page-header h1 {
            font-size: 1.8rem;
        }

        .d-sm-flex {
            flex-direction: column;
            align-items: stretch;
        }

        .row {
            grid-template-columns: 1fr;
        }

        .row.mb-3 {
            flex-direction: column;
            gap: 10px;
        }

        .col-sm-3 {
            flex: none;
        }

        .d-flex.align-items-center {
            flex-direction: column;
            text-align: center;
        }
    }

    /* Scrollbar Styling */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
    }
</style>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="page-header">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Chi tiết đánh giá #{{ $review->id }}</h1>
            <div>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary mr-2">
                    <i class="fas fa-arrow-left"></i> Quay lại danh sách
                </a>
                @if($review->jewelry)
                <a href="{{ route('admin.reviews.by-product', $review->jewelry->id) }}" class="btn btn-info">
                    <i class="fas fa-list"></i> Xem tất cả đánh giá sản phẩm
                </a>
                @endif
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row">
        <!-- Review Details -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin đánh giá</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>ID:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $review->id }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Người đánh giá:</strong>
                        </div>
                        <div class="col-sm-9">
                            <div class="d-flex align-items-center">
                                <div>
                                    <div class="font-weight-bold">{{ $review->user->name }}</div>
                                    <small class="text-muted">{{ $review->user->email }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Sản phẩm:</strong>
                        </div>
                        <div class="col-sm-9">
                            @if($review->jewelry)
                            <div class="d-flex align-items-center">
                                @if($review->jewelry->jewelryFiles->count() > 0)
                                <img src="{{$review->image}}"
                                    alt="{{ $review->jewelry->name }}"
                                    class="rounded mr-3"
                                    style="width: 60px; height: 60px; object-fit: cover;">
                                @endif
                                <div>
                                    <div class="font-weight-bold">{{ $review->jewelry->name }}</div>
                                    <small class="text-muted">Mã: {{ $review->jewelry->code }}</small><br>
                                    <small class="text-muted">Giá: {{ number_format($review->jewelry->price) }} VND</small>
                                </div>
                            </div>
                            @else
                            <span class="text-muted">Sản phẩm đã bị xóa</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Đánh giá:</strong>
                        </div>
                        <div class="col-sm-9">
                            <div class="text-warning mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <=$review->rating)
                                    <i class="fas fa-star fa-lg"></i>
                                    @else
                                    <i class="far fa-star fa-lg"></i>
                                    @endif
                                    @endfor
                                    <span class="ml-2 text-dark">({{ $review->rating }}/5)</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Nội dung:</strong>
                        </div>
                        <div class="col-sm-9">
                            <div class="bg-light p-3 rounded">
                                {{ $review->content }}
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Ngày tạo:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $review->created_at->format('d/m/Y H:i:s') }}
                            <small class="text-muted">({{ $review->created_at->diffForHumans() }})</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Cập nhật lần cuối:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $review->updated_at->format('d/m/Y H:i:s') }}
                            <small class="text-muted">({{ $review->updated_at->diffForHumans() }})</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Trạng thái:</strong>
                        </div>
                        <div class="col-sm-9">
                            @if($review->is_deleted)
                            <span class="badge badge-danger badge-lg">Đã xóa</span>
                            @else
                            <span class="badge badge-success badge-lg">Hoạt động</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Hành động</h6>
                </div>
                <div class="card-body">
                    @if(!$review->is_deleted)
                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="mb-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning btn-block"
                            onclick="return confirm('Bạn có chắc muốn xóa đánh giá này?')">
                            <i class="fas fa-trash"></i> Xóa đánh giá
                        </button>
                    </form>
                    @else
                    <form action="{{ route('admin.reviews.restore', $review->id) }}" method="POST" class="mb-3">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-undo"></i> Khôi phục đánh giá
                        </button>
                    </form>

                    <form action="{{ route('admin.reviews.force-delete', $review->id) }}" method="POST" class="mb-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block"
                            onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn đánh giá này? Hành động này không thể hoàn tác!')">
                            <i class="fas fa-times"></i> Xóa vĩnh viễn
                        </button>
                    </form>
                    @endif

                    <hr>

                    @if($review->jewelry)
                    <a href="{{ route('admin.reviews.by-product', $review->jewelry->id) }}"
                        class="btn btn-info btn-block mb-2">
                        <i class="fas fa-list"></i> Tất cả đánh giá sản phẩm
                    </a>
                    @endif

                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary btn-block">
                        <i class="fas fa-list"></i> Danh sách tất cả đánh giá
                    </a>
                </div>
            </div>

            <!-- Review Statistics (if jewelry exists) -->
            @if($review->jewelry)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thống kê sản phẩm</h6>
                </div>
                <div class="card-body">
                    @php
                    $stats = App\Models\Review::where('jewelries_id', $review->jewelry->id)
                    ->selectRaw('
                    COUNT(*) as total_reviews,
                    AVG(rating) as average_rating,
                    SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) as five_star,
                    SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) as four_star,
                    SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as three_star,
                    SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) as two_star,
                    SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) as one_star
                    ')
                    ->first();
                    @endphp

                    <div class="text-center mb-3">
                        <div class="h4 mb-0">{{ $stats->total_reviews ?? 0 }}</div>
                        <small class="text-muted">Tổng đánh giá</small>
                    </div>

                    <div class="text-center mb-3">
                        <div class="h4 mb-0">{{ $stats->average_rating ? number_format($stats->average_rating, 1) : 0 }}</div>
                        <small class="text-muted">Điểm trung bình</small>
                    </div>

                    @if($stats && $stats->total_reviews > 0)
                    <hr>
                    <div class="small">
                        <div class="d-flex justify-content-between mb-1">
                            <span>5 sao:</span>
                            <span>{{ $stats->five_star }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>4 sao:</span>
                            <span>{{ $stats->four_star }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>3 sao:</span>
                            <span>{{ $stats->three_star }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>2 sao:</span>
                            <span>{{ $stats->two_star }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>1 sao:</span>
                            <span>{{ $stats->one_star }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
