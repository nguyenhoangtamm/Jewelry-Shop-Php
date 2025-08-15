@extends('user.layout')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/chi_tiet_sp_new.css') }}">


<!-- SCROLL PAGE START -->
<div class="scroll__page">
    <a href="#header">
        <i class="bi bi-chevron-up"></i>
    </a>
</div>
<!-- DETAILS START -->
<section class="details">
    <div class="container">
        {{-- Hiển thị chi tiết sản phẩm --}}
        <div class="product-section">
            <div class="product-layout">
                <div class="product-main-column">
                    <div class="images-row">
                        <!-- Left column: Thumbnails -->
                        <div class="product-thumbnails">
                            @if($images && count($images) > 0)
                            <button class="thumbnail-nav up" onclick="scrollThumbnails('up')">
                                <i class="bi bi-chevron-up"></i>
                            </button>
                            <div class="thumbnail-list">
                                @foreach($images as $index => $img)
                                <img src="{{ $img['path'] }}" alt="Ảnh sản phẩm {{ $index + 1 }}"
                                    class="thumbnail {{ $index === 0 ? 'active' : '' }}" data-main="{{ $img['path'] }}"
                                    onclick="changeMainImage('{{ $img['path'] }}', this)">
                                @endforeach
                            </div>
                            <button class="thumbnail-nav down" onclick="scrollThumbnails('down')">
                                <i class="bi bi-chevron-down"></i>
                            </button>
                            @endif
                        </div>

                        <!-- Middle column: Main image -->
                        <div class="product-main-image">
                            @if($main_image)
                            <div class="main-image-container">
                                <img id="mainImage" src="{{ $main_image['path'] }}" alt="{{ $jewelry->name }}">
                                <div class="new-badge">NEW</div>
                            </div>
                            @else
                            <div class="main-image-container">
                                <img src="../images/default-product.jpg" alt="{{ $jewelry->name }}" class="main-image"
                                    id="mainImage">
                                <div class="new-badge">NEW</div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Second row: descriptions and policies -->
                    <div class="details-row">
                        <div class="product-description-section">
                            <div class="container">
                                <div class="description-policy-wrapper">

                                    <!-- Mô tả sản phẩm -->
                                    <div class="description-block">
                                        <h3 class="section-title">Mô tả sản phẩm</h3>
                                        <div class="description-content">
                                            @if($jewelry->description)
                                            <div class="product-description">
                                                {!! $jewelry->description !!}
                                            </div>
                                            @else
                                            <div class="product__features">
                                                <h4>Đặc điểm nổi bật:</h4>
                                                <ul>
                                                    <li>Chất liệu cao cấp với thiết kế tinh tế</li>
                                                    <li>Thiết kế tinh tế, sang trọng</li>
                                                    <li>Phù hợp với nhiều dịp khác nhau</li>
                                                    <li>Được chế tác bởi thợ kim hoàn có tay nghề cao</li>
                                                    <li>Bảo hành chính hãng</li>
                                                </ul>
                                            </div>
                                            @endif

                                            <div class="care__instructions">
                                                <h4>Hướng dẫn bảo quản:</h4>
                                                <ul>
                                                    <li>Tránh tiếp xúc với nước và hóa chất</li>
                                                    <li>Bảo quản trong hộp riêng biệt</li>
                                                    <li>Vệ sinh nhẹ nhàng bằng khăn mềm</li>
                                                    <li>Tránh va đập mạnh</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Chính sách hậu mãi -->
                                    <div class="policy-block">
                                        <h3 class="section-title">Thông tin sản phẩm</h3>
                                        <div class="product-specs">
                                            <div class="spec-item">
                                                <span class="spec-label">Trọng lượng:</span>
                                                <span class="spec-value">{{ $jewelry->weight }}g</span>
                                            </div>
                                            <div class="spec-item">
                                                <span class="spec-label">Loại đá chính:</span>
                                                <span class="spec-value">{{ $jewelry->main_stone }}</span>
                                            </div>
                                            <div class="spec-item">
                                                <span class="spec-label">Loại đá phụ:</span>
                                                <span class="spec-value">{{ $jewelry->sub_stone }}</span>
                                            </div>
                                            <div class="spec-item">
                                                <span class="spec-label">Trang sức dành cho: </span>
                                                <span class="spec-value">
                                                    @if($jewelry->gender == 'male') Nam
                                                    @elseif($jewelry->gender == 'female') Nữ
                                                    @else Unisex
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="spec-item">
                                                <span class="spec-label">Thương hiệu:</span>
                                                <span class="spec-value">{{ $jewelry->brand }}</span>
                                            </div>
                                            <div class="spec-item">
                                                <span class="spec-label">Còn lại:</span>
                                                <span
                                                    class="spec-value {{ $jewelry->stock == 0 ? 'out-of-stock' : 'in-stock' }}">
                                                    {{ $jewelry->stock == 0 ? 'Hết hàng' : $jewelry->stock . ' sản phẩm' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- End product layout -->
                <!-- Right column: Product info -->
                <div class="product-info">
                    <h1 class="product-title">{{ $jewelry->name }}</h1>
                    <div class="product-code">Mã: {{ $jewelry->id }}</div>

                    <div class="rating">
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++) {!! $i <=$averageRating ? '★' : '☆' !!} @endfor </div>
                                <span>({{ $averageRating }}) {{ $totalReviews }} đánh giá</span>
                        </div>

                        <div class="price-section">
                            <div class="current-price">{{ number_format($jewelry->price, 0, ',', '.') }} ₫</div>
                            <div class="installment-info">
                                Chỉ cần trả {{ number_format($jewelry->price / 12, 0, ',', '.') }} ₫/tháng
                                <br>(Giá sản phẩm có thể thay đổi tùy trọng lượng vàng và đá)
                            </div>
                        </div>

                        <div class="promotion-tags">
                            <div class="tag">Chọn kích cỡ</div>
                            <div class="tag">Nhận ưu đãi khuyến mãi</div>
                        </div>

                        <div class="size-selection">
                            <label class="size-label">Vui lòng chọn số lượng *</label>
                            <div class="size-options">
                                <input type="number" class="quantity" name="quantity" min="1"
                                    max="{{ $jewelry->stock }}" value="1">
                            </div>
                            <div class="size-guide-section" style="margin-top: 10px;">
                                <button type="button" class="size-guide-btn" onclick="openSizeGuideModal()">
                                    <i class="fas fa-ruler"></i> Cách đo size nhẫn
                                </button>
                            </div>
                            <div style="font-size: 14px; color: #666;">
                                Ưu đãi dành riêng cho bạn - Tư vấn ngay tại <span style="color: #e74c3c;">FREE</span>
                            </div>
                        </div>
                        <div id="sizeGuideModal" class="size-guide-modal" style="display: none;">
                            <div class="size-guide-overlay" onclick="closeSizeGuideModal()"></div>
                            <div class="size-guide-content">
                                <!-- Header -->
                                <div class="size-guide-header">
                                    <h3>Cách đo size nhẫn</h3>
                                    <button type="button" class="close-btn" onclick="closeSizeGuideModal()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>

                                <!-- Content -->
                                <div class="size-guide-body">
                                    <!-- Bước 1 -->
                                    <div class="guide-step">
                                        <div class="step-number">1.</div>
                                        <div class="step-content">
                                            <h4>Dùng chỉ hoặc giấy bấn nhỏ đo quanh quan khớp tay, đánh dấu vị trí cắt
                                                nhau</h4>
                                            <div class="step-image">
                                                <div class="hand-illustration">
                                                    <div class="hand-shape"></div>
                                                    <div class="thread-wrap"></div>
                                                </div>
                                                <div class="coin-icon">
                                                    <div class="coin"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bước 2 -->
                                    <div class="guide-step">
                                        <div class="step-number">2.</div>
                                        <div class="step-content">
                                            <h4>Dùng thước đo chiều dài đoạn dây vừa đo được (đơn vị cm)</h4>
                                            <div class="step-image">
                                                <div class="ruler-illustration">
                                                    <div class="ruler"></div>
                                                    <div class="measurement-line"></div>
                                                </div>
                                                <div class="coin-icon">
                                                    <div class="coin"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Kết quả -->
                                    <div class="size-result">
                                        <h4>Kết quả bạn đo được là:</h4>
                                        <div class="size-options-modal">
                                            <div class="size-option">
                                                <input type="radio" name="measured_size" id="size_46" value="4.6">
                                                <label for="size_46">4.6</label>
                                            </div>
                                            <div class="size-option">
                                                <input type="radio" name="measured_size" id="size_47" value="4.7">
                                                <label for="size_47">4.7</label>
                                            </div>
                                            <div class="size-option">
                                                <input type="radio" name="measured_size" id="size_49" value="4.9">
                                                <label for="size_49">4.9</label>
                                            </div>
                                        </div>

                                        <!-- Size chart -->
                                        <div class="size-chart">
                                            <div class="chart-ruler">
                                                <div class="ruler-marks">
                                                    <span>9</span><span>10</span><span>11</span><span>12</span><span>13</span><span>14</span><span>15</span><span>16</span><span>17</span><span>18</span><span>19</span><span>20</span>
                                                </div>
                                                <div class="ruler-labels">
                                                    <span>XS</span><span>S</span><span>M</span><span>L</span><span>XL</span><span>Nem</span>
                                                </div>
                                            </div>
                                            <div class="size-recommendation">
                                                <strong>Size nhẫn của bạn là: <span
                                                        id="recommended-size">6</span></strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="size-guide-footer">
                                    <button type="button" class="btn-confirm" onclick="applySizeGuide()">
                                        Xác nhận
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="benefits">
                            <div class="benefit-item">
                                <div class="benefit-icon">✓</div>
                                <span>Ưu đãi thêm lên đến 300K khi thanh toán qua VNPAY-QR</span>
                            </div>
                            <div class="benefit-item">
                                <div class="benefit-icon">✓</div>
                                <span>Ưu đãi thêm 1.000.000đ khi thanh toán bằng thẻ TECHCOMBANK</span>
                            </div>
                            <div class="benefit-item">
                                <div class="benefit-icon">✓</div>
                                <span>Ưu đãi thêm lên đến 500.000đ khi thanh toán bằng thẻ NCB</span>
                            </div>
                        </div>

                        <div class="service-icons">
                            <div class="service-icon">
                                <span>🚚</span>
                                <span>Miễn phí giao hàng</span>
                            </div>
                            <div class="service-icon">
                                <span>🔄</span>
                                <span>Phục vụ 24/7</span>
                            </div>
                            <div class="service-icon">
                                <span>⏰</span>
                                <span>Thu đổi 48h</span>
                            </div>
                        </div>

                        <div class="buttons">
                            <button class="btn btn-primary buy-now" data-id="{{ $jewelry->id }}" @if($jewelry->stock ==
                                0) disabled @endif>
                                {{ $jewelry->stock == 0 ? 'Hết hàng' : 'Mua ngay' }}
                            </button>
                            <button class="btn btn-outline add-to-cart" data-id="{{ $jewelry->id }}" @if($jewelry->stock
                                == 0) disabled @endif>
                                {{ $jewelry->stock == 0 ? 'Hết hàng' : 'Thêm vào giỏ hàng' }}
                            </button>
                            <!-- <button class="btn btn-secondary">Đặt ngay (miễn phí)</button> -->
                        </div>



                        <div class="store-info">
                            <div class="store-title">Cửa hàng Trang sức HV-DK</div>
                            <div class="store-location">
                                <span>📍</span>
                                <span>Mở cửa: 08h00, Đóng cửa: 22h00</span>
                            </div>
                            <div class="store-location">
                                <span>📍</span>
                                <span>Thành phố Cao Lãnh, tỉnh Đồng Tháp, Việt Nam</span>
                            </div>
                            <div style="margin-top: 10px;">
                                <button class="btn btn-outline" style="width: 100%;">📞 Đặt đơn tại cửa hàng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Tabs section below the product layout -->
    <div class="product-tabs-section">
        <!-- Phần tabs -->
        <div class="tabs">
            <div class="tab-list">
                <button class="tab" data-tab="reviews">Đánh giá sản phẩm</button>
                <button class="tab" data-tab="faq">Câu hỏi thường gặp</button>
            </div>
        </div>

        <div class="tab-content" id="description">
            <div style="padding: 20px;">
                <h3>Mô tả sản phẩm</h3>

                @if($jewelry->description)
                <div class="product-description">
                    {!! $jewelry->description !!}
                </div>
                @else
                <div class="product__features">
                    <h4>Đặc điểm nổi bật:</h4>
                    <ul>
                        <li>Chất liệu cao cấp với thiết kế tinh tế</li>
                        <li>Thiết kế tinh tế, sang trọng</li>
                        <li>Phù hợp với nhiều dịp khác nhau</li>
                        <li>Được chế tác bởi thợ kim hoàn có tay nghề cao</li>
                        <li>Bảo hành chính hãng</li>
                    </ul>
                </div>
                @endif

                <div class="care__instructions">
                    <h4>Hướng dẫn bảo quản:</h4>
                    <ul>
                        <li>Tránh tiếp xúc với nước và hóa chất</li>
                        <li>Bảo quản trong hộp riêng biệt</li>
                        <li>Vệ sinh nhẹ nhàng bằng khăn mềm</li>
                        <li>Tránh va đập mạnh</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tab-content" id="specifications">
            <div class="product-specs">
                <div class="spec-item">
                    <span class="spec-label">Trọng lượng:</span>
                    <span class="spec-value">{{ $jewelry->weight }}g</span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">Loại đá chính:</span>
                    <span class="spec-value">{{ $jewelry->main_stone }}</span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">Loại đá phụ:</span>
                    <span class="spec-value">{{ $jewelry->sub_stone }}</span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">Giới tính:</span>
                    <span class="spec-value">
                        @if($jewelry->gender == 'male') Nam
                        @elseif($jewelry->gender == 'female') Nữ
                        @else Unisex
                        @endif
                    </span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">Thương hiệu:</span>
                    <span class="spec-value">{{ $jewelry->brand }}</span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">Còn lại:</span>
                    <span class="spec-value {{ $jewelry->stock == 0 ? 'out-of-stock' : 'in-stock' }}">
                        {{ $jewelry->stock == 0 ? 'Hết hàng' : $jewelry->stock . ' sản phẩm' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Tab đánh giá sản phẩm -->
        <div class="tab-content active" id="reviews">
            <div class="review-section">
                <!-- Header -->
                <div class="review-header">
                    <h2 class="review-title">Đánh giá sản phẩm</h2>
                    <p class="review-subtitle">Chia sẻ trải nghiệm của bạn với cộng đồng</p>
                </div>

                <!-- Summary -->
                <div class="review-summary">
                    <div class="rating-overview">
                        <div class="rating-score" id="average-rating">{{ $averageRating }}</div>
                        <div class="rating-stars" id="average-stars">
                            @for($i = 1; $i <= 5; $i++) {!! $i <=$averageRating ? '★' : '☆' !!} @endfor </div>
                                <div class="total-reviews" id="total-reviews">{{ $totalReviews }} đánh giá</div>
                        </div>

                        <div class="rating-breakdown">
                            @for($rating = 5; $rating >= 1; $rating--)
                            <div class="rating-bar">
                                <div class="rating-label">
                                    <i class="fas fa-star"></i> {{ $rating }}
                                </div>
                                <div class="rating-progress">
                                    <div class="rating-fill"
                                        style="width: {{ $totalReviews > 0 ? ($ratingCounts[$rating] / $totalReviews * 100) : 0 }}%"
                                        data-rating="{{ $rating }}"></div>
                                </div>
                                <div class="rating-count" data-rating="{{ $rating }}">{{ $ratingCounts[$rating] }}</div>
                            </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Add Review Form -->
                    @auth
                    <div class="add-review-section">
                        <h3 class="add-review-title">
                            <i class="fas fa-edit"></i> Viết đánh giá của bạn
                        </h3>
                        <form class="review-form" id="review-form">
                            @csrf
                            <input type="hidden" name="jewelry_id" value="{{ $jewelry->id }}">
                            <div class="rating-input">
                                <label>Đánh giá của bạn:</label>
                                <div class="star-rating">
                                    <input type="radio" name="rating" value="5" id="star5">
                                    <label for="star5" title="5 sao">★</label>
                                    <input type="radio" name="rating" value="4" id="star4">
                                    <label for="star4" title="4 sao">★</label>
                                    <input type="radio" name="rating" value="3" id="star3">
                                    <label for="star3" title="3 sao">★</label>
                                    <input type="radio" name="rating" value="2" id="star2">
                                    <label for="star2" title="2 sao">★</label>
                                    <input type="radio" name="rating" value="1" id="star1">
                                    <label for="star1" title="1 sao">★</label>
                                </div>
                            </div>
                            <div class="comment-input">
                                <label for="reviewContent">
                                    <i class="fas fa-comment"></i> Nhận xét của bạn:
                                </label>
                                <textarea id="reviewContent" name="content"
                                    placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này. Điều gì làm bạn hài lòng? Có điều gì cần cải thiện không?"
                                    rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-paper-plane"></i> Gửi đánh giá
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="add-review-section">
                        <h3 class="add-review-title">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập để viết đánh giá
                        </h3>
                        <p style="text-align: center; margin: 0;">
                            <a href="{{ route('login') }}" class="btn-submit"
                                style="display: inline-block; text-decoration: none;">
                                <i class="fas fa-sign-in-alt"></i> Đăng nhập ngay
                            </a>
                        </p>
                    </div>
                    @endauth

                    <!-- Filters -->
                    <div class="review-filters">
                        <div class="filter-buttons">
                            <button class="filter-btn active" data-rating="all">
                                <i class="fas fa-list"></i> Tất cả (<span
                                    id="filter-all-count">{{ $totalReviews }}</span>)
                            </button>
                            @for($rating = 5; $rating >= 1; $rating--)
                            <button class="filter-btn" data-rating="{{ $rating }}">
                                <i class="fas fa-star"></i> {{ $rating }} Sao (<span
                                    id="filter-{{ $rating }}-count">{{ $ratingCounts[$rating] }}</span>)
                            </button>
                            @endfor
                        </div>
                    </div>

                    <!-- Reviews List -->
                    <div class="reviews-list" id="reviews-list">
                        <!-- Reviews will be loaded here via JavaScript -->
                    </div>

                    <!-- Loading indicator -->
                    <div id="review-loading" style="text-align: center; padding: 40px; display: none;">
                        <div style="font-size: 2rem; color: #cbd5e1; margin-bottom: 10px;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                        <p style="color: #64748b;">Đang tải đánh giá...</p>
                    </div>

                    <!-- No reviews message -->
                    <div id="no-reviews" class="no-reviews" style="display: none;">
                        <div class="no-reviews-icon">
                            <i class="fas fa-comment-slash"></i>
                        </div>
                        <h3>Chưa có đánh giá nào</h3>
                        <p>Hãy trở thành người đầu tiên đánh giá sản phẩm này!</p>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="faq">
                <div class="faq-container">
                    <h3>Câu hỏi thường gặp</h3>

                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Sản phẩm có bảo hành không?</span>
                            <span class="faq-icon">⌄</span>
                        </button>
                        <div class="faq-answer">
                            <p>{{ !empty($jewelry->after_sales_policy) ? $jewelry->after_sales_policy : 'Sản phẩm được bảo hành theo chính sách của cửa hàng.' }}
                            </p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Có thể đổi trả sản phẩm không?</span>
                            <span class="faq-icon">⌄</span>
                        </button>
                        <div class="faq-answer">
                            <p>Khách hàng có thể đổi trả sản phẩm trong vòng 7 ngày kể từ ngày mua hàng với điều kiện
                                sản phẩm còn nguyên vẹn.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Thời gian giao hàng?</span>
                            <span class="faq-icon">⌄</span>
                        </button>
                        <div class="faq-answer">
                            <p>Thời gian giao hàng từ 1-3 ngày làm việc đối với nội thành và 3-7 ngày đối với các tỉnh
                                thành khác.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Mua Online có ưu đãi gì đặc biệt cho tôi?</span>
                            <span class="faq-icon">⌄</span>
                        </button>
                        <div class="faq-answer">
                            <p>PNJ mang đến nhiều trải nghiệm mua sắm hiện đại khi mua Online: Ưu đãi độc quyền Online
                                với hình thức thanh toán đa dạng, đặt giữ hàng Online nhận tại cửa hàng, miễn phí giao
                                hàng từ 1-7 ngày trên toàn quốc và giao hàng trong 3 giờ tại một số khu vực trung tâm.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- end chi tiết sản phẩm --}}

        </div>
</section>
<!-- DETAILS END -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script type="module" src="./js/details.js"></script>
<script>
    // Gallery functionality
    function changeMainImage(imagePath, thumbnailElement) {
        const mainImage = document.getElementById('mainImage');

        // Add fade effect
        mainImage.style.opacity = '0.7';

        setTimeout(() => {
            // Update main image
            mainImage.src = imagePath;
            mainImage.style.opacity = '1';
            mainImage.classList.add('fade-in');

            // Remove active class from all thumbnails
            document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));

            // Add active class to clicked thumbnail
            thumbnailElement.classList.add('active');

            // Remove animation class after animation completes
            setTimeout(() => {
                mainImage.classList.remove('fade-in');
            }, 300);
        }, 150);
    }

    // Thumbnail scroll functionality
    function scrollThumbnails(direction) {
        const thumbnailList = document.querySelector('.thumbnail-list');
        const scrollAmount = 90; // Thumbnail height + gap

        if (direction === 'up') {
            thumbnailList.scrollTop -= scrollAmount;
        } else {
            thumbnailList.scrollTop += scrollAmount;
        }

        // Update navigation button states
        updateNavigationButtons();
    }

    // Update navigation button states based on scroll position
    function updateNavigationButtons() {
        const thumbnailList = document.querySelector('.thumbnail-list');
        const upBtn = document.querySelector('.thumbnail-nav.up');
        const downBtn = document.querySelector('.thumbnail-nav.down');

        if (thumbnailList && upBtn && downBtn) {
            const isAtTop = thumbnailList.scrollTop <= 0;
            const isAtBottom = thumbnailList.scrollTop >= thumbnailList.scrollHeight - thumbnailList.clientHeight;

            upBtn.style.opacity = isAtTop ? '0.5' : '1';
            downBtn.style.opacity = isAtBottom ? '0.5' : '1';
            upBtn.style.pointerEvents = isAtTop ? 'none' : 'auto';
            downBtn.style.pointerEvents = isAtBottom ? 'none' : 'auto';
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateNavigationButtons();

        // Add scroll listener to thumbnail list
        const thumbnailList = document.querySelector('.thumbnail-list');
        if (thumbnailList) {
            thumbnailList.addEventListener('scroll', updateNavigationButtons);
        }
    });

    // Tab functionality
    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', function() {
            const tabName = this.dataset.tab;

            // Remove active class from all tabs
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            // Add active class to clicked tab
            this.classList.add('active');

            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });

            // Show corresponding tab content
            document.getElementById(tabName).classList.add('active');
        });
    });

    // Review filter functionality
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all filter buttons
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');

            const rating = this.dataset.rating;
            loadReviews(rating);
        });
    });

    // Load reviews function
    function loadReviews(rating = 'all') {
        const reviewsList = document.getElementById('reviews-list');
        const loading = document.getElementById('review-loading');
        const noReviews = document.getElementById('no-reviews');

        // Show loading
        loading.style.display = 'block';
        reviewsList.style.display = 'none';
        noReviews.style.display = 'none';

        // AJAX request to load reviews
        $.ajax({
            url: '/api/reviews/{{ $jewelry->id }}',
            method: 'GET',
            data: {
                rating: rating
            },
            success: function(response) {
                loading.style.display = 'none';
                if (response.reviews && response.reviews.length > 0) {
                    reviewsList.innerHTML = '';
                    response.reviews.forEach(review => {
                        const reviewHtml = createReviewHTML(review);
                        reviewsList.innerHTML += reviewHtml;
                    });
                    reviewsList.style.display = 'flex';
                } else {
                    reviewsList.innerHTML = '';
                    noReviews.style.display = 'block';
                }
            },
            error: function() {
                loading.style.display = 'none';
                reviewsList.innerHTML = '';
                noReviews.style.display = 'block';
                showNotification('Có lỗi khi tải đánh giá!', 'error');
            }
        });
    }

    // Create review HTML
    function createReviewHTML(review) {
        const stars = '★'.repeat(review.rating) + '☆'.repeat(5 - review.rating);
        const avatar = review.user_name ? review.user_name.charAt(0).toUpperCase() : '?';
        let date = '';
        if (review.created_at) {
            try {
                const d = new Date(review.created_at);
                if (!isNaN(d.getTime())) {
                    date = d.toLocaleDateString('vi-VN', {
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }
            } catch (e) {
                date = '';
            }
        }
        return `
            <div class="review-item" data-rating="${review.rating}">
                <div class="reviewer-header">
                    <div class="reviewer-avatar">${avatar}</div>
                    <div class="reviewer-info">
                        <div class="reviewer-name">${review.user_name || 'Ẩn danh'}</div>
                        <div class="review-date">
                            <i class="far fa-calendar"></i> ${date}
                        </div>
                    </div>
                    <div class="review-rating">
                        <div class="review-stars">${stars}</div>
                    </div>
                </div>
                <div class="review-content">
                    ${review.content}
                </div>
            </div>
        `;
    }

    // Submit review form
    $('#review-form').on('submit', function(e) {
        e.preventDefault();

        const formData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            jewelry_id: $('input[name="jewelry_id"]').val(),
            rating: $('input[name="rating"]:checked').val(),
            content: $('#reviewContent').val()
        };

        if (!formData.rating) {
            showNotification('Vui lòng chọn số sao đánh giá!', 'warning');
            return;
        }

        if (!formData.content.trim()) {
            showNotification('Vui lòng nhập nội dung đánh giá!', 'warning');
            return;
        }

        const submitBtn = $('.btn-submit');
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang gửi...');

        $.ajax({
            url: '/api/reviews',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');

                    // Reset form
                    $('#review-form')[0].reset();
                    $('input[name="rating"]').prop('checked', false);

                    // Reload reviews and update summary
                    loadReviews();
                    updateReviewSummary(response.summary);
                } else {
                    showNotification(response.message, 'error');
                }

                submitBtn.prop('disabled', false).html(
                    '<i class="fas fa-paper-plane"></i> Gửi đánh giá');
            },
            error: function(xhr) {
                let message = 'Có lỗi xảy ra, vui lòng thử lại!';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = Object.values(xhr.responseJSON.errors).flat();
                    message = errors.join(', ');
                }

                showNotification(message, 'error');
                submitBtn.prop('disabled', false).html(
                    '<i class="fas fa-paper-plane"></i> Gửi đánh giá');
            }
        });
    });

    // Update review summary
    function updateReviewSummary(summary) {
        $('#average-rating').text(summary.averageRating);
        $('#total-reviews').text(summary.totalReviews + ' đánh giá');
        $('#filter-all-count').text(summary.totalReviews);

        // Update stars display
        const stars = '★'.repeat(Math.floor(summary.averageRating)) + '☆'.repeat(5 - Math.floor(summary.averageRating));
        $('#average-stars').html(stars);

        // Update breakdown
        for (let rating = 1; rating <= 5; rating++) {
            const count = summary.ratingCounts[rating] || 0;
            const percentage = summary.totalReviews > 0 ? (count / summary.totalReviews * 100) : 0;

            $(`.rating-fill[data-rating="${rating}"]`).css('width', percentage + '%');
            $(`.rating-count[data-rating="${rating}"]`).text(count);
            $(`#filter-${rating}-count`).text(count);
        }
    }

    // Load reviews when page loads
    $(document).ready(function() {
        loadReviews();
    });

    //cau hoi thuong gap
    // FAQ Accordion functionality
    document.addEventListener('DOMContentLoaded', function() {
        const faqQuestions = document.querySelectorAll('.faq-question');

        faqQuestions.forEach(question => {
            question.addEventListener('click', function() {
                const answer = this.nextElementSibling;
                const isActive = this.classList.contains('active');

                // Đóng tất cả các FAQ khác
                faqQuestions.forEach(q => {
                    q.classList.remove('active');
                    q.nextElementSibling.classList.remove('active');
                });

                // Nếu câu hỏi hiện tại chưa được mở, mở nó
                if (!isActive) {
                    this.classList.add('active');
                    answer.classList.add('active');
                }
            });
        });

        // Sự kiện chuyển trang khi bấm 'Mua ngay'
        const buyNowBtn = document.querySelector('.btn.buy-now');
        if (buyNowBtn) {
            buyNowBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = '/checkout?jewelry={{ $jewelry->id }}&quantity=' + (document
                    .querySelector('.quantity')?.value || 1);
            });
        }
    });
    //Thêm vao giỏ hàng và mua ngay
    // Xử lý thêm vào giỏ hàng
    $('.add-to-cart').on('click', function(e) {
        e.preventDefault();

        const jewelryId = $(this).data('id');
        const quantity = parseInt($('.quantity').val()) || 1;
        const button = $(this);

        // Hiển thị loading
        button.prop('disabled', true).text('Đang thêm...');

        $.ajax({
            url: '/cart/add',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                jewelry_id: jewelryId,
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    // Hiển thị thông báo thành công
                    showNotification(response.message, 'success');

                    // Cập nhật số lượng giỏ hàng trên header
                    updateCartBadge(response.cart_count);

                    // Reset button
                    button.prop('disabled', false).html(
                        '<i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng');

                    // Reset quantity về 1
                    $('.quantity').val(1);
                } else {
                    showNotification(response.message, 'error');
                    button.prop('disabled', false).html(
                        '<i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng');
                }
            },
            error: function(xhr) {
                let message = 'Có lỗi xảy ra, vui lòng thử lại!';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                showNotification(message, 'error');
                button.prop('disabled', false).html(
                    '<i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng');
            }
        });
    });

    // Tăng/giảm số lượng
    $('.quantity-btn').on('click', function() {
        const action = $(this).data('action');
        const quantityInput = $('.quantity');
        let currentQuantity = parseInt(quantityInput.val()) || 1;
        const maxStock = parseInt(quantityInput.attr('max')) || 999;

        if (action === 'increase' && currentQuantity < maxStock) {
            quantityInput.val(currentQuantity + 1);
        } else if (action === 'decrease' && currentQuantity > 1) {
            quantityInput.val(currentQuantity - 1);
        }
    });

    // Kiểm tra số lượng nhập vào
    $('.quantity').on('change', function() {
        const maxStock = parseInt($(this).attr('max')) || 999;
        let quantity = parseInt($(this).val()) || 1;

        if (quantity < 1) {
            $(this).val(1);
        } else if (quantity > maxStock) {
            $(this).val(maxStock);
            showNotification('Số lượng không được vượt quá ' + maxStock, 'warning');
        }
    });

    // Mua ngay
    $('.buy-now').on('click', function(e) {
        e.preventDefault();

        const jewelryId = $(this).data('id');
        const quantity = parseInt($('.quantity').val()) || 1;
        const button = $(this);

        button.prop('disabled', true).text('Đang xử lý...');

        // Thêm vào giỏ hàng trước
        $.ajax({
            url: '/cart/add',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                jewelry_id: jewelryId,
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    // Chuyển đến trang giỏ hàng
                    window.location.href = '/cart';
                } else {
                    showNotification(response.message, 'error');
                    button.prop('disabled', false).html('<i class="fas fa-bolt"></i> Mua ngay');
                }
            },
            error: function() {
                showNotification('Có lỗi xảy ra, vui lòng thử lại!', 'error');
                button.prop('disabled', false).html('<i class="fas fa-bolt"></i> Mua ngay');
            }
        });
    });

    // Hàm hiển thị thông báo đơn giản (không cần Bootstrap JS)
    function showNotification(message, type = 'info') {
        // Xóa thông báo cũ nếu có
        $('.custom-notification').remove();

        // Xác định màu sắc và icon theo loại thông báo
        let bgColor, textColor, icon;
        switch (type) {
            case 'success':
                bgColor = '#28a745';
                textColor = '#fff';
                icon = '✓';
                break;
            case 'error':
                bgColor = '#dc3545';
                textColor = '#fff';
                icon = '✗';
                break;
            case 'warning':
                bgColor = '#ffc107';
                textColor = '#000';
                icon = '⚠';
                break;
            default:
                bgColor = '#17a2b8';
                textColor = '#fff';
                icon = 'ℹ';
        }

        // Tạo HTML thông báo
        const notificationHtml = `
        <div class="custom-notification" style="
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: ${bgColor};
            color: ${textColor};
            padding: 15px 20px;
            border-radius: 5px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 9999;
            max-width: 350px;
            animation: slideInRight 0.3s ease-out;
        ">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 18px; font-weight: bold;">${icon}</span>
                <span style="flex: 1;">${message}</span>
                <button onclick="$(this).parent().parent().fadeOut()" style="
                    background: none;
                    border: none;
                    color: ${textColor};
                    font-size: 20px;
                    cursor: pointer;
                    padding: 0;
                    margin-left: 10px;
                ">×</button>
            </div>
        </div>
    `;

        // Thêm CSS animation nếu chưa có
        if ($('#notification-styles').length === 0) {
            $('head').append(`
            <style id="notification-styles">
                @keyframes slideInRight {
                    from {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
                
                @keyframes slideOutRight {
                    from {
                        transform: translateX(0);
                        opacity: 1;
                    }
                    to {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                }
            </style>
        `);
        }

        // Thêm thông báo vào DOM
        $('body').append(notificationHtml);

        // Tự động ẩn sau 4 giây
        setTimeout(function() {
            $('.custom-notification').fadeOut(300, function() {
                $(this).remove();
            });
        }, 4000);
    }

    // Cập nhật badge số lượng giỏ hàng
    function updateCartBadge(count) {
        const badge = $('.cart-badge');
        if (badge.length > 0) {
            badge.text(count).show();
        }
    }

    // Load số lượng giỏ hàng khi tải trang
    $(document).ready(function() {
        $.ajax({
            url: '/cart/count',
            method: 'GET',
            success: function(response) {
                updateCartBadge(response.cart_count);
            }
        });
    });
    // Thêm sự kiện click cho nút "Đặt đơn tại cửa hàng"
    function openSizeGuideModal() {
        document.getElementById('sizeGuideModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeSizeGuideModal() {
        document.getElementById('sizeGuideModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function applySizeGuide() {
        const selectedSize = document.querySelector('input[name="measured_size"]:checked');
        if (selectedSize) {
            // Có thể thêm logic để áp dụng size đã chọn
            showNotification('Đã chọn size: ' + selectedSize.value, 'success');
        }
        closeSizeGuideModal();
    }

    // Đóng modal khi nhấn ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeSizeGuideModal();
        }
    });

    // Xử lý khi chọn size trong modal
    document.querySelectorAll('input[name="measured_size"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const sizeMap = {
                '4.6': '6',
                '4.7': '7',
                '4.9': '8'
            };
            document.getElementById('recommended-size').textContent = sizeMap[this.value] || '6';
        });
    });
</script>

@endsection