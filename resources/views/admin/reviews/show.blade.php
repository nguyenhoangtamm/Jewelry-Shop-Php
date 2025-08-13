@extends('admin.layouts.app')

@section('title', 'Chi tiết đánh giá #' . $review->id)

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
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