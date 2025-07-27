@extends('user.layout')
@section('content')

<link rel="stylesheet" href="../css/chi_tiet_sp.css">

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
            <div class="product-gallery">
                <div class="gallery-container">
                    @if($images)
                    <img id="mainImage" src="{{ $images[0] }}" alt="{{ $jewelry->name }}">
                    <div class="new-badge">NEW</div>
                </div>
                <div class="thumbnail-list">
                    @foreach($images as $index => $image)
                    <img src="{{ $image }}" alt="{{ $image->name ?? 'Thumbnail ' . ($index + 1) }}" class="thumbnail {{ $index === 0 ? 'active' : '' }}" data-main="{{ $image }}">
                    @endforeach
                    @for($i = count($images); $i < 4; $i++)
                        <img src="{{ $images[0] }}" alt="{{ $jewelry->name }}" class="thumbnail" data-main="{{ $images[0] }}">
                        @endfor
                        @else
                        <img src="../images/default-product.jpg" alt="{{ $jewelry->name }}" class="main-image" id="mainImage">
                        <div class="new-badge">NEW</div>
                        @endif
                </div>
            </div>

            <div class="product-info">
                <h1 class="product-title">{{ $jewelry->name }}</h1>
                <div class="product-code">Mã: {{ $jewelry->id }}</div>

                <div class="rating">
                    <div class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            {!! $i <=$averageRating ? '★' : '☆' !!}
                            @endfor
                            </div>
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
                            <input type="number" class="quantity" name="quantity" min="1" max="{{ $jewelry->stock }}" value="1">
                        </div>
                        <div style="font-size: 14px; color: #666;">
                            Ưu đãi dành riêng cho bạn - Tư vấn ngay tại <span style="color: #e74c3c;">FREE</span>
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
                        <button class="btn btn-primary buy-now" data-id="{{ $jewelry->id }}" @if($jewelry->stock == 0) disabled @endif>
                            {{ $jewelry->stock == 0 ? 'Hết hàng' : 'Mua ngay' }}
                        </button>
                        <button class="btn btn-outline add-to-cart" data-id="{{ $jewelry->id }}" @if($jewelry->stock == 0) disabled @endif>
                            {{ $jewelry->stock == 0 ? 'Hết hàng' : 'Thêm vào giỏ hàng' }}
                        </button>
                        <button class="btn btn-secondary">Đặt ngay (miễn phí)</button>
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

            <!-- Phần tabs -->
            <div class="tabs">
                <div class="tab-list">
                    <button class="tab active" data-tab="description">Mô tả sản phẩm</button>
                    <button class="tab" data-tab="specifications">Chính sách hậu mãi</button>
                    <button class="tab" data-tab="reviews">Đánh giá sản phẩm</button>
                    <button class="tab" data-tab="faq">Câu hỏi thường gặp</button>
                </div>
            </div>

            <div class="tab-content active" id="description">
                <div style="padding: 20px;">
                    <h3>Mô tả sản phẩm</h3>

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
            <div class="tab-content" id="reviews">
                <div class="review-section">
                    <!-- Tổng quan đánh giá -->
                    <div class="review-summary">
                        <div class="rating-overview">
                            <div class="rating-score"><?php echo $averageRating ?></div>
                            <div class="rating-stars">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $averageRating) {
                                        echo '★';
                                    } else {
                                        echo '☆';
                                    }
                                }
                                ?>
                            </div>
                            <div class="total-reviews"><?php echo $totalReviews ?> đánh giá</div>
                        </div>

                        <div class="rating-breakdown">
                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                <div class="rating-bar">
                                    <div class="rating-label"><?php echo $i ?> Sao</div>
                                    <div class="rating-progress">
                                        <div class="rating-fill"
                                            style="width: <?php echo $totalReviews > 0 ? ($ratingCounts[$i] / $totalReviews * 100) : 0 ?>%">
                                        </div>
                                    </div>
                                    <div class="rating-count"><?php echo $ratingCounts[$i] ?></div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <!-- Form thêm đánh giá -->
                    @if(session('user_id'))
                    <div class="add-review-section">
                        <h4>Viết đánh giá của bạn</h4>
                        <form class="review-form" id="reviewForm">
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
                                <label for="reviewContent">Nhận xét:</label>
                                <textarea id="reviewContent" name="content" placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này..." rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                        </form>
                    </div>
                    @else
                    <div class="login-prompt">
                    </div>
                    @endif

                    <!-- Bộ lọc đánh giá -->
                    <div class="review-filters">
                        <button class="filter-btn active" data-rating="all">Tất cả</button>
                        <button class="filter-btn" data-rating="5">5 Sao (<?php echo $ratingCounts[5] ?>)</button>
                        <button class="filter-btn" data-rating="4">4 Sao (<?php echo $ratingCounts[4] ?>)</button>
                        <button class="filter-btn" data-rating="3">3 Sao (<?php echo $ratingCounts[3] ?>)</button>
                        <button class="filter-btn" data-rating="2">2 Sao (<?php echo $ratingCounts[2] ?>)</button>
                        <button class="filter-btn" data-rating="1">1 Sao (<?php echo $ratingCounts[1] ?>)</button>
                    </div>

                    <!-- Danh sách đánh giá -->
                    <div class="reviews-list">
                        @if($reviews->count())
                        @foreach($reviews as $review)
                        <div class="review-item" data-rating="{{ $review->rating }}">
                            <div class="review-header">
                                <div class="reviewer-avatar">
                                    {{ strtoupper(substr($review->user->username ?? 'Ẩn danh', 0, 1)) }}
                                </div>
                                <div class="reviewer-info">
                                    <div class="reviewer-name">{{ $review->user->username ?? 'Ẩn danh' }}</div>
                                    <div class="review-date">{{ $review->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                                <div class="review-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        {!! $i <=$review->rating ? '★' : '☆' !!}
                                        @endfor
                                </div>
                            </div>
                            <div class="review-content">
                                <p>{{ $review->content }}</p>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="no-reviews">
                            <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                            <p>Hãy là người đầu tiên đánh giá sản phẩm!</p>
                        </div>
                        @endif
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
                            <p>{{ !empty($jewelry->after_sales_policy) ? $jewelry->after_sales_policy : 'Sản phẩm được bảo hành theo chính sách của cửa hàng.' }}</p>
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
    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.addEventListener('click', function() {
            // Remove active class from all thumbnails
            document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
            // Add active class to clicked thumbnail
            this.classList.add('active');
            // Update main image
            document.getElementById('mainImage').src = this.dataset.main;
        });
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
            const filter = this.dataset.filter;

            // Show/hide reviews based on filter
            document.querySelectorAll('.review-item').forEach(item => {
                if (rating === 'all') {
                    item.style.display = 'block';
                } else if (rating) {
                    if (item.dataset.rating === rating) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                }
            });
        });
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
    });
</script>
    

@endsection