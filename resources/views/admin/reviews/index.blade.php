@extends('admin.layouts.app')

@section('title', 'Quản lý đánh giá')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý đánh giá</h1>
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

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Danh sách đánh giá</h6>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" action="{{ route('admin.reviews.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="search" placeholder="Tìm kiếm nội dung..." value="{{ $search }}">
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" name="jewelry_id">
                                    <option value="">-- Tất cả sản phẩm --</option>
                                    @foreach($jewelries as $jewelry)
                                    <option value="{{ $jewelry->id }}" {{ $jewelry_id == $jewelry->id ? 'selected' : '' }}>
                                        {{ $jewelry->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
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
                            <div class="col-md-2">
                                <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Reset</a>
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
                                    <th>Sản phẩm</th>
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
                                        <div class="d-flex align-items-center">
                                            @if($review->jewelry && $review->jewelry->jewelryFiles->count() > 0)
                                            <img src="{{$review->image}}"
                                                alt="{{ $review->jewelry->name }}"
                                                class="rounded mr-2"
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <div class="font-weight-bold">{{ $review->jewelry->name ?? 'Sản phẩm đã bị xóa' }}</div>
                                                @if($review->jewelry)
                                                <small class="text-muted">
                                                    <a href="{{ route('admin.reviews.by-product', $review->jewelry->id) }}" class="text-decoration-none">
                                                        Xem tất cả đánh giá
                                                    </a>
                                                </small>
                                                @endif
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
                                        <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
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
                                    <td colspan="8" class="text-center">Không có đánh giá nào.</td>
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