@extends('admin.layouts.app')

@section('title', 'Đánh giá sản phẩm: ' . $jewelry->name)

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Đánh giá sản phẩm: {{ $jewelry->name }}</h1>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
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

    <!-- Product Info -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            @if($jewelry->jewelryFiles->count() > 0)
                            <img src="{{$jewelry->image}}"
                                alt="{{ $jewelry->name }}"
                                class="img-fluid rounded">
                            @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 100px;">
                                <span class="text-muted">Không có ảnh</span>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h4>{{ $jewelry->name }}</h4>
                            <p class="text-muted mb-1">Mã: {{ $jewelry->code }}</p>
                            <p class="text-muted mb-1">Giá: {{ number_format($jewelry->price) }} VND</p>
                            <p class="text-muted">Danh mục: {{ $jewelry->category->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Thống kê đánh giá</h6>
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <div class="h4 mb-0">{{ $reviewStats->total_reviews ?? 0 }}</div>
                                            <small class="text-muted">Tổng đánh giá</small>
                                        </div>
                                        <div class="col-6">
                                            <div class="h4 mb-0">{{ $reviewStats->average_rating ? number_format($reviewStats->average_rating, 1) : 0 }}</div>
                                            <small class="text-muted">Điểm trung bình</small>
                                        </div>
                                    </div>
                                    @if($reviewStats && $reviewStats->total_reviews > 0)
                                    <hr>
                                    <div class="small">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>5 sao:</span>
                                            <span>{{ $reviewStats->five_star }} ({{ round(($reviewStats->five_star / $reviewStats->total_reviews) * 100) }}%)</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>4 sao:</span>
                                            <span>{{ $reviewStats->four_star }} ({{ round(($reviewStats->four_star / $reviewStats->total_reviews) * 100) }}%)</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>3 sao:</span>
                                            <span>{{ $reviewStats->three_star }} ({{ round(($reviewStats->three_star / $reviewStats->total_reviews) * 100) }}%)</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>2 sao:</span>
                                            <span>{{ $reviewStats->two_star }} ({{ round(($reviewStats->two_star / $reviewStats->total_reviews) * 100) }}%)</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>1 sao:</span>
                                            <span>{{ $reviewStats->one_star }} ({{ round(($reviewStats->one_star / $reviewStats->total_reviews) * 100) }}%)</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews List -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Danh sách đánh giá</h6>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" action="{{ route('admin.reviews.by-product', $jewelry->id) }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="search" placeholder="Tìm kiếm nội dung..." value="{{ $search }}">
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" name="rating">
                                    <option value="">-- Tất cả rating --</option>
                                    <option value="5" {{ $rating == 5 ? 'selected' : '' }}>5 sao</option>
                                    <option value="4" {{ $rating == 4 ? 'selected' : '' }}>4 sao</option>
                                    <option value="3" {{ $rating == 3 ? 'selected' : '' }}>3 sao</option>
                                    <option value="2" {{ $rating == 2 ? 'selected' : '' }}>2 sao</option>
                                    <option value="1" {{ $rating == 1 ? 'selected' : '' }}>1 sao</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Lọc</button>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.reviews.by-product', $jewelry->id) }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>

                    <!-- Reviews Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Người dùng</th>
                                    <th>Rating</th>
                                    <th>Nội dung</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $review)
                                <tr class="{{ $review->is_deleted ? 'table-secondary' : '' }}">
                                    <td>{{ $review->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="font-weight-bold">{{ $review->user->name }}</div>
                                                <small class="text-muted">{{ $review->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <=$review->rating)
                                                <i class="fas fa-star"></i>
                                                @else
                                                <i class="far fa-star"></i>
                                                @endif
                                                @endfor
                                                <small class="text-muted">({{ $review->rating }}/5)</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="max-width: 300px;">
                                            {{ $review->content }}
                                        </div>
                                    </td>
                                    <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($review->is_deleted)
                                        <span class="badge badge-danger">Đã xóa</span>
                                        @else
                                        <span class="badge badge-success">Hoạt động</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.reviews.show', $review->id) }}"
                                                class="btn btn-info btn-sm" title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if(!$review->is_deleted)
                                            <form action="{{ route('admin.reviews.destroy', $review->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-warning btn-sm"
                                                    onclick="return confirm('Bạn có chắc muốn xóa đánh giá này?')"
                                                    title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @else
                                            <form action="{{ route('admin.reviews.restore', $review->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm"
                                                    title="Khôi phục">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.reviews.force-delete', $review->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn đánh giá này? Hành động này không thể hoàn tác!')"
                                                    title="Xóa vĩnh viễn">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Sản phẩm này chưa có đánh giá nào.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $reviews->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection