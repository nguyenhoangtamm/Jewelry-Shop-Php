@extends('user.layout')
@section('title', 'Tìm kiếm' . (!empty($query) ? ' - ' . $query : ''))
@section('content')

<style>
    .search-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    }

    .search-header {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        color: white;
        padding: 2rem 0;
    }

    .search-filters {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .filter-group {
        margin-bottom: 1rem;
    }

    .filter-label {
        font-weight: 600;
        color: #1e40af;
        margin-bottom: 0.5rem;
        display: block;
    }

    .filter-input {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .filter-input:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .search-btn {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .search-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(30, 64, 175, 0.3);
    }

    .clear-btn {
        background: #6b7280;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .clear-btn:hover {
        background: #4b5563;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .product-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        text-decoration: none;
        color: inherit;
    }

    .product-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .product-info {
        padding: 1.5rem;
    }

    .product-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e40af;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .product-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: #dc2626;
        margin-bottom: 0.5rem;
    }

    .product-category {
        font-size: 0.9rem;
        color: #6b7280;
        background: #f3f4f6;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        display: inline-block;
    }

    .no-results {
        text-align: center;
        padding: 4rem 2rem;
        color: #6b7280;
    }

    .no-results i {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }

    .pagination-wrapper {
        margin-top: 3rem;
        display: flex;
        justify-content: center;
    }

    .results-info {
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .sort-controls {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .sort-select {
        padding: 0.5rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        background: white;
    }

    @media (max-width: 768px) {
        .search-filters {
            padding: 1rem;
        }

        .filter-row {
            flex-direction: column;
        }

        .filter-group {
            margin-bottom: 1.5rem;
        }

        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }

        .sort-controls {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>

<div class="search-page">
    <!-- Search Header -->
    <div class="search-header">
        <div class="container">
            <div class="text-center">
                <h1 class="text-3xl font-bold mb-2">
                    @if(!empty($query))
                    Kết quả tìm kiếm cho: "{{ $query }}"
                    @else
                    Tìm kiếm sản phẩm
                    @endif
                </h1>
                <p class="text-lg opacity-90">
                    @if(isset($totalResults))
                    Tìm thấy {{ $totalResults }} sản phẩm
                    @else
                    Khám phá bộ sưu tập trang sức của chúng tôi
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="container py-4">
        <!-- Search Filters -->
        <div class="search-filters">
            <form method="GET" action="{{ route('search') }}" id="searchForm">
                <div class="row">
                    <div class="col-md-3">
                        <div class="filter-group">
                            <label class="filter-label">Từ khóa</label>
                            <input type="text"
                                name="search"
                                class="filter-input"
                                placeholder="Nhập tên sản phẩm..."
                                value="{{ $query }}"
                                id="searchInput">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="filter-group">
                            <label class="filter-label">Danh mục</label>
                            <select name="category_id" class="filter-input">
                                <option value="">Tất cả danh mục</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $categoryId == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="filter-group">
                            <label class="filter-label">Giá từ</label>
                            <input type="number"
                                name="min_price"
                                class="filter-input"
                                placeholder="0"
                                value="{{ $minPrice }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="filter-group">
                            <label class="filter-label">Giá đến</label>
                            <input type="number"
                                name="max_price"
                                class="filter-input"
                                placeholder="10000000"
                                value="{{ $maxPrice }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="filter-group">
                            <label class="filter-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="search-btn flex-1">
                                    <i class="fa fa-search me-2"></i>Tìm kiếm
                                </button>
                                <button type="button" class="clear-btn" onclick="clearFilters()">
                                    <i class="fa fa-times me-1"></i>Xóa
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Info & Sort -->
        @if(isset($jewelries))
        <div class="results-info">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <strong>{{ $jewelries->total() }}</strong> sản phẩm
                    @if(!empty($query))
                    cho từ khóa "<strong>{{ $query }}</strong>"
                    @endif
                </div>

                <div class="sort-controls">
                    <label for="sortSelect" class="me-2">Sắp xếp:</label>
                    <select id="sortSelect" name="sort_by" class="sort-select" onchange="applySorting()">
                        <option value="name" {{ $sortBy == 'name' ? 'selected' : '' }}>Tên A-Z</option>
                        <option value="price_asc" {{ $sortBy == 'price_asc' ? 'selected' : '' }}>Giá thấp đến cao</option>
                        <option value="price_desc" {{ $sortBy == 'price_desc' ? 'selected' : '' }}>Giá cao đến thấp</option>
                        <option value="newest" {{ $sortBy == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        @if($jewelries->count() > 0)
        <div class="product-grid">
            @foreach($jewelries as $jewelry)
            <a href="{{ route('jewelry.detail', $jewelry->id) }}" class="product-card">
                <div class="position-relative">
                    <img src="{{ $jewelry->main_image ? asset($jewelry->main_image) : asset('img/default.png') }}"
                        alt="{{ $jewelry->name }}"
                        class="product-image">

                    @if($jewelry->created_at->diffInDays(now()) <= 7)
                        <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-success">Mới</span>
                </div>
                @endif
        </div>

        <div class="product-info">
            <h3 class="product-name">{{ $jewelry->name }}</h3>
            <div class="product-price">
                {{ number_format($jewelry->price, 0, ',', '.') }}đ
            </div>

            @if($jewelry->category)
            <span class="product-category">{{ $jewelry->category->name }}</span>
            @endif

            @if($jewelry->description)
            <p class="text-muted mt-2 small">
                {{ Str::limit($jewelry->description, 100) }}
            </p>
            @endif
        </div>
        </a>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $jewelries->links() }}
    </div>
    @else
    <div class="no-results">
        <i class="fa fa-search"></i>
        <h3>Không tìm thấy sản phẩm nào</h3>
        <p>Thử thay đổi từ khóa hoặc bộ lọc để tìm kiếm sản phẩm khác.</p>
        <button class="search-btn mt-3" onclick="clearFilters()">
            Xóa bộ lọc
        </button>
    </div>
    @endif
    @endif
</div>
</div>

<!-- Auto-complete suggestions -->
<div id="searchSuggestions" class="position-absolute bg-white border rounded shadow-lg" style="display: none; z-index: 1000; width: 100%; max-height: 300px; overflow-y: auto;"></div>

<script>
    function clearFilters() {
        document.querySelector('input[name="search"]').value = '';
        document.querySelector('select[name="category_id"]').value = '';
        document.querySelector('input[name="min_price"]').value = '';
        document.querySelector('input[name="max_price"]').value = '';
        document.querySelector('select[name="sort_by"]').value = 'name';

        // Submit form to clear results
        window.location.href = '{{ route("search") }}';
    }

    function applySorting() {
        const form = document.getElementById('searchForm');
        const sortSelect = document.getElementById('sortSelect');

        // Add sort value to form
        if (!form.querySelector('input[name="sort_by"]')) {
            const sortInput = document.createElement('input');
            sortInput.type = 'hidden';
            sortInput.name = 'sort_by';
            form.appendChild(sortInput);
        }

        form.querySelector('input[name="sort_by"]').value = sortSelect.value;
        form.submit();
    }

    // Auto-complete functionality
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    const suggestionsDiv = document.getElementById('searchSuggestions');

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();

        if (query.length < 2) {
            suggestionsDiv.style.display = 'none';
            return;
        }

        searchTimeout = setTimeout(() => {
            fetch(`{{ route('search.suggestions') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        let html = '';
                        data.forEach(item => {
                            html += `<div class="p-2 cursor-pointer border-bottom suggestion-item" onclick="selectSuggestion('${item.name}')">
                                   <i class="fa fa-search me-2 text-muted"></i>${item.name}
                                 </div>`;
                        });
                        suggestionsDiv.innerHTML = html;
                        suggestionsDiv.style.display = 'block';

                        // Position suggestions below input
                        const rect = searchInput.getBoundingClientRect();
                        suggestionsDiv.style.top = (rect.bottom + window.scrollY) + 'px';
                        suggestionsDiv.style.left = rect.left + 'px';
                        suggestionsDiv.style.width = rect.width + 'px';
                    } else {
                        suggestionsDiv.style.display = 'none';
                    }
                })
                .catch(() => {
                    suggestionsDiv.style.display = 'none';
                });
        }, 300);
    });

    function selectSuggestion(name) {
        searchInput.value = name;
        suggestionsDiv.style.display = 'none';
        document.getElementById('searchForm').submit();
    }

    // Hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
            suggestionsDiv.style.display = 'none';
        }
    });

    // Add hover effect to suggestions
    document.addEventListener('mouseover', function(e) {
        if (e.target.classList.contains('suggestion-item')) {
            e.target.style.backgroundColor = '#f8f9fa';
        }
    });

    document.addEventListener('mouseout', function(e) {
        if (e.target.classList.contains('suggestion-item')) {
            e.target.style.backgroundColor = '';
        }
    });
</script>

@endsection