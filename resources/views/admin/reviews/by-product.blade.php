@extends('admin.layouts.app')

@section('title', 'Đánh giá sản phẩm: ' . $jewelry->name)

@section('content')
<link rel="stylesheet" href="{{ asset('css/by_product.css') }}">

<div class="reviews-container">
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">Đánh giá sản phẩm: {{ $jewelry->name }}</h1>
            <a href="{{ route('admin.reviews.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                <span>Quay lại</span>
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
        <button type="button" class="alert-close">&times;</button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
        <button type="button" class="alert-close">&times;</button>
    </div>
    @endif

    <!-- Product Information Card -->
    <div class="product-info-card">
        <div class="product-details">
            <div class="product-image">
                @if($jewelry->jewelryFiles->count() > 0)
                <img src="{{$jewelry->image}}" alt="{{ $jewelry->name }}" class="product-img">
                @else
                <div class="no-image">
                    <i class="fas fa-image"></i>
                    <span>Không có ảnh</span>
                </div>
                @endif
            </div>

            <div class="product-meta">
                <h2 class="product-name">{{ $jewelry->name }}</h2>
                <div class="product-info-grid">
                    <div class="info-item">
                        <span class="info-label">Mã sản phẩm:</span>
                        <span class="info-value">{{ $jewelry->code }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Giá:</span>
                        <span class="info-value price">{{ number_format($jewelry->price) }} VND</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Danh mục:</span>
                        <span class="info-value">{{ $jewelry->category->name ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rating Statistics -->
        <div class="rating-stats">
            <h3 class="stats-title">Thống kê đánh giá</h3>
            <div class="stats-summary">
                <div class="stat-item">
                    <div class="stat-number">{{ $reviewStats->total_reviews ?? 0 }}</div>
                    <div class="stat-label">Tổng đánh giá</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">
                        {{ $reviewStats->average_rating ? number_format($reviewStats->average_rating, 1) : 0 }}
                    </div>
                    <div class="stat-label">Điểm trung bình</div>
                </div>
            </div>

            @if($reviewStats && $reviewStats->total_reviews > 0)
            <div class="rating-breakdown">
                <div class="breakdown-item">
                    <span class="stars">5 <i class="fas fa-star"></i></span>
                    <div class="progress-bar">
                        <div class="progress-fill"
                            style="width: {{ round(($reviewStats->five_star / $reviewStats->total_reviews) * 100) }}%">
                        </div>
                    </div>
                    <span class="count">{{ $reviewStats->five_star }}</span>
                </div>
                <div class="breakdown-item">
                    <span class="stars">4 <i class="fas fa-star"></i></span>
                    <div class="progress-bar">
                        <div class="progress-fill"
                            style="width: {{ round(($reviewStats->four_star / $reviewStats->total_reviews) * 100) }}%">
                        </div>
                    </div>
                    <span class="count">{{ $reviewStats->four_star }}</span>
                </div>
                <div class="breakdown-item">
                    <span class="stars">3 <i class="fas fa-star"></i></span>
                    <div class="progress-bar">
                        <div class="progress-fill"
                            style="width: {{ round(($reviewStats->three_star / $reviewStats->total_reviews) * 100) }}%">
                        </div>
                    </div>
                    <span class="count">{{ $reviewStats->three_star }}</span>
                </div>
                <div class="breakdown-item">
                    <span class="stars">2 <i class="fas fa-star"></i></span>
                    <div class="progress-bar">
                        <div class="progress-fill"
                            style="width: {{ round(($reviewStats->two_star / $reviewStats->total_reviews) * 100) }}%">
                        </div>
                    </div>
                    <span class="count">{{ $reviewStats->two_star }}</span>
                </div>
                <div class="breakdown-item">
                    <span class="stars">1 <i class="fas fa-star"></i></span>
                    <div class="progress-bar">
                        <div class="progress-fill"
                            style="width: {{ round(($reviewStats->one_star / $reviewStats->total_reviews) * 100) }}%">
                        </div>
                    </div>
                    <span class="count">{{ $reviewStats->one_star }}</span>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="reviews-section">
        <div class="reviews-header">
            <h3 class="section-title">
                <i class="fas fa-comments"></i>
                Danh sách đánh giá
            </h3>
        </div>

        <!-- Filters -->
        <div class="filters-container">
            <form method="GET" action="{{ route('admin.reviews.by-product', $jewelry->id) }}" class="filters-form">
                <div class="filter-group">
                    <div class="input-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-input" name="search" placeholder="Tìm kiếm nội dung..."
                            value="{{ $search }}">
                    </div>
                </div>

                <div class="filter-group">
                    <select class="form-select" name="rating">
                        <option value="">-- Tất cả rating --</option>
                        <option value="5" {{ $rating == 5 ? 'selected' : '' }}>5 sao</option>
                        <option value="4" {{ $rating == 4 ? 'selected' : '' }}>4 sao</option>
                        <option value="3" {{ $rating == 3 ? 'selected' : '' }}>3 sao</option>
                        <option value="2" {{ $rating == 2 ? 'selected' : '' }}>2 sao</option>
                        <option value="1" {{ $rating == 1 ? 'selected' : '' }}>1 sao</option>
                    </select>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i>
                        Lọc
                    </button>
                    <a href="{{ route('admin.reviews.by-product', $jewelry->id) }}" class="btn btn-secondary">
                        <i class="fas fa-refresh"></i>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Reviews Table -->
        <div class="reviews-table-container">
            <table class="reviews-table">
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
                    <tr class="review-row {{ $review->is_deleted ? 'deleted' : '' }}">
                        <td class="review-id">{{ $review->id }}</td>
                        <td class="user-info">
                            <div class="user-details">
                                <div class="user-name">{{ $review->user->name }}</div>
                                <div class="user-email">{{ $review->user->email }}</div>
                            </div>
                        </td>
                        <td class="rating-cell">
                            <div class="star-rating">
                                @for($i = 1; $i <= 5; $i++) @if($i <=$review->rating)
                                    <i class="fas fa-star filled"></i>
                                    @else
                                    <i class="fas fa-star"></i>
                                    @endif
                                    @endfor
                                    <span class="rating-text">({{ $review->rating }}/5)</span>
                            </div>
                        </td>
                        <td class="content-cell">
                            <div class="review-content">
                                {{ $review->content }}
                            </div>
                        </td>
                        <td class="date-cell">{{ $review->created_at->format('d/m/Y H:i') }}</td>
                        <td class="status-cell">
                            @if($review->is_deleted)
                            <span class="status-badge deleted">Đã xóa</span>
                            @else
                            <span class="status-badge active">Hoạt động</span>
                            @endif
                        </td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn-action view"
                                    title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if(!$review->is_deleted)
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST"
                                    class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete"
                                        onclick="return confirm('Bạn có chắc muốn xóa đánh giá này?')" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('admin.reviews.restore', $review->id) }}" method="POST"
                                    class="inline-form">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-action restore" title="Khôi phục">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.reviews.force-delete', $review->id) }}" method="POST"
                                    class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action force-delete"
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
                        <td colspan="7" class="empty-state">
                            <div class="empty-message">
                                <i class="fas fa-comments"></i>
                                <p>Sản phẩm này chưa có đánh giá nào.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($reviews->hasPages())
        <div class="pagination-container">
            {{ $reviews->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide alerts
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const closeBtn = alert.querySelector('.alert-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', () => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                });
            }

            // Auto-hide after 5 seconds
            setTimeout(() => {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        });
    });
</script>
@endsection