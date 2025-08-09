@extends('user.layout')

@section('title', request('search') ? 'Tìm kiếm: ' . request('search') : 'Tất Cả Sản Phẩm')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-r from-blue-900 via-indigo-800 to-cyan-700 text-white">

        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative container mx-auto px-4 py-16">
            <!-- Header -->
            <div class="text-center">
                <h1 class="text-5xl font-bold mb-4 bg-gradient-to-r from-blue-200 to-pink-200 bg-clip-text text-transparent">
                    @if(request('search'))
                    Kết quả tìm kiếm: "{{ request('search') }}"
                    @else
                    Bộ Sưu Tập Trang Sức
                    @endif
                </h1>
                <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                    @if(request('search'))
                    Tìm thấy {{ $products->total() }} sản phẩm cho từ khóa "{{ request('search') }}"
                    @else
                    Khám phá những món trang sức tinh tế, được chế tác tỉ mỉ với chất lượng hoàn hảo
                    @endif
                </p>
            </div>
        </div>

        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-pink-400 to-red-500 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse delay-1000"></div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <div class="lg:w-80">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden sticky top-6">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6">
                        <h3 class="font-bold text-white text-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Bộ Lọc Sản Phẩm
                        </h3>
                    </div>

                    <div class="p-6 space-y-8">
                        <!-- Search Form -->
                        <div>

                            <!-- Reset Filters Button -->
                            <div>
                                <button type="button"
                                    onclick="resetAllFilters()"
                                    class="w-full inline-flex items-center justify-center px-4 py-3 rounded-xl font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors duration-200 border border-gray-200 mb-6">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582M20 20l-4-4m2-5a7 7 0 10-14 0 7 7 0 0014 0z" />
                                    </svg>
                                    Đặt lại bộ lọc
                                </button>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                Tìm Kiếm
                            </h4>

                            <form method="GET" action="{{ route('products.all') }}" class="space-y-3">
                                <!-- Preserve other filters -->
                                @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                @if(request('price_range'))
                                @foreach((array)request('price_range') as $range)
                                <input type="hidden" name="price_range[]" value="{{ $range }}">
                                @endforeach
                                @endif
                                @if(request('brand'))
                                @foreach((array)request('brand') as $brand)
                                <input type="hidden" name="brand[]" value="{{ $brand }}">
                                @endforeach
                                @endif
                                @if(request('gender'))
                                @foreach((array)request('gender') as $gender)
                                <input type="hidden" name="gender[]" value="{{ $gender }}">
                                @endforeach
                                @endif
                                @if(request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                                @endif

                                <div class="relative">
                                    <input type="text"
                                        name="search"
                                        value="{{ request('search') }}"
                                        placeholder="Nhập tên sản phẩm..."
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                    <button type="submit"
                                        class="absolute right-2 top-1/2 transform -translate-y-1/2 p-2 text-gray-400 hover:text-indigo-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </button>
                                </div>

                                @if(request('search'))
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">
                                        Đang tìm: "<strong>{{ request('search') }}</strong>"
                                    </span>
                                    <a href="{{ route('products.all', request()->except('search')) }}"
                                        class="text-sm text-red-500 hover:text-red-700 transition-colors">
                                        Xóa
                                    </a>
                                </div>
                                @endif
                            </form>
                        </div>

                        <!-- Categories -->
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2"></span>
                                Danh Mục
                            </h4>
                            <div class="space-y-2">
                                <a href="{{ route('products.all') }}"
                                    class="flex items-center justify-between p-3 rounded-xl hover:bg-indigo-50 transition-all duration-200 group {{ !request('category') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600' }}">
                                    <span class="font-medium">Tất cả sản phẩm</span>
                                    <svg class="w-4 h-4 text-indigo-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                                @foreach($categories as $category)
                                <a href="{{ route('products.all', ['category' => $category->id]) }}"
                                    class="flex items-center justify-between p-3 rounded-xl hover:bg-indigo-50 transition-all duration-200 group {{ request('category') == $category->id ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600' }}">
                                    <span class="font-medium">{{ $category->name }}</span>
                                    <svg class="w-4 h-4 text-indigo-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Filter -->
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></span>
                                Khoảng Giá
                            </h4>
                            <div class="space-y-3">
                                @foreach($priceRanges as $range)
                                <label class="flex items-center space-x-3 group cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" name="price_range"
                                            value="{{ $range['min'] }}-{{ $range['max'] ?? 'max' }}"
                                            class="w-5 h-5 rounded border-2 border-gray-300 text-indigo-600 focus:ring-indigo-500 focus:ring-2 transition-all duration-200">
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition-colors">{{ $range['label'] }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Gender Filter -->
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                <span class="w-2 h-2 bg-pink-500 rounded-full mr-2"></span>
                                Giới Tính
                            </h4>
                            <div class="space-y-3">
                                <label class="flex items-center space-x-3 group cursor-pointer">
                                    <input type="checkbox" name="gender" value="F"
                                        class="w-5 h-5 rounded border-2 border-gray-300 text-pink-600 focus:ring-pink-500 focus:ring-2">
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-pink-600 transition-colors">Nữ</span>
                                </label>
                                <label class="flex items-center space-x-3 group cursor-pointer">
                                    <input type="checkbox" name="gender" value="M"
                                        class="w-5 h-5 rounded border-2 border-gray-300 text-blue-600 focus:ring-blue-500 focus:ring-2">
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600 transition-colors">Nam</span>
                                </label>
                                <label class="flex items-center space-x-3 group cursor-pointer">
                                    <input type="checkbox" name="gender" value="U"
                                        class="w-5 h-5 rounded border-2 border-gray-300 text-purple-600 focus:ring-purple-500 focus:ring-2">
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-purple-600 transition-colors">Unisex</span>
                                </label>
                            </div>
                        </div>

                        <!-- Material Filter -->
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                                Chất Liệu
                            </h4>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach(['Vàng', 'Bạc', 'Titan', 'Thép', 'Kim cương', 'Ngọc trai'] as $material)
                                <button class="p-2 text-xs font-medium text-center rounded-lg border-2 border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 focus:ring-2 focus:ring-indigo-500">
                                    {{ $material }}
                                </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1">
                <!-- Filter Bar -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-8 overflow-hidden">
                    <div class="flex flex-col lg:flex-row items-center justify-between p-6 space-y-4 lg:space-y-0">
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="flex items-center space-x-3">
                                <span class="text-gray-600 font-medium">Sắp xếp theo:</span>
                                <select name="sort" class="bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                    <option value="created_at">Mới nhất</option>
                                    <option value="price">Giá tăng dần</option>
                                    <option value="price_desc">Giá giảm dần</option>
                                    <option value="sold">Bán chạy nhất</option>
                                    <option value="name">Tên A-Z</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <span class="text-gray-600 font-medium">Hiển thị:</span>
                            <div class="flex items-center space-x-2 bg-gray-100 rounded-xl p-1">
                                <button class="p-2 rounded-lg bg-white shadow-sm text-indigo-600 border-2 border-indigo-200">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                </button>
                                <button class="p-2 rounded-lg text-gray-500 hover:text-indigo-600 hover:bg-white transition-all duration-200">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 16a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search Results Info -->
                @if(request('search'))
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-6 p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Kết quả tìm kiếm cho: "<span class="text-blue-600">{{ request('search') }}</span>"</h3>
                                <p class="text-sm text-gray-600">Tìm thấy {{ $products->total() }} sản phẩm</p>
                            </div>
                        </div>
                        <a href="{{ route('products.all', request()->except('search')) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Xóa tìm kiếm
                        </a>
                    </div>
                </div>
                @endif

                <!-- Products Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse($products as $product)
                    <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                        <!-- Sale Badges -->
                        <div class="absolute top-4 left-4 z-20 flex flex-col space-y-2">
                            @if($product->stock < 10 && $product->stock > 0)
                                <span class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-3 py-1 text-xs font-bold rounded-full shadow-lg">
                                    Sắp hết
                                </span>
                                @endif

                                @if($product->sold > 100)
                                <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-3 py-1 text-xs font-bold rounded-full shadow-lg">
                                    Bán chạy
                                </span>
                                @elseif($product->sold > 50)
                                <span class="bg-gradient-to-r from-green-400 to-emerald-500 text-white px-3 py-1 text-xs font-bold rounded-full shadow-lg">
                                    Hàng mới
                                </span>
                                @endif
                        </div>

                        <!-- Product Image -->
                        <div class="relative overflow-hidden aspect-square bg-gradient-to-br from-gray-50 to-gray-100">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                            <!-- Gradient overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                            <!-- Quick Action Buttons -->
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <div class="flex space-x-3">
                                    <a href="{{ route('product.detail', $product->id) }}"
                                        class="bg-white/90 backdrop-blur-sm text-indigo-600 p-3 rounded-full hover:bg-white hover:scale-110 transition-all duration-200 shadow-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <button class="bg-white/90 backdrop-blur-sm text-pink-600 p-3 rounded-full hover:bg-white hover:scale-110 transition-all duration-200 shadow-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Material indicators -->
                            <div class="absolute bottom-4 left-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="flex space-x-2">
                                    <div class="w-4 h-4 rounded-full bg-gradient-to-br from-yellow-300 to-yellow-600 border-2 border-white shadow-sm"></div>
                                    <div class="w-4 h-4 rounded-full bg-gradient-to-br from-gray-300 to-gray-500 border-2 border-white shadow-sm"></div>
                                    <div class="w-4 h-4 rounded-full bg-gradient-to-br from-blue-300 to-blue-600 border-2 border-white shadow-sm"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-semibold text-indigo-600 uppercase tracking-wider bg-indigo-50 px-2 py-1 rounded-full">
                                    {{ $product->brand ?: $product->category->name ?? 'Trang sức' }}
                                </span>
                                <div class="flex items-center text-yellow-400">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        @endfor
                                </div>
                            </div>

                            <h3 class="font-bold text-gray-900 mb-3 line-clamp-2 text-lg group-hover:text-indigo-700 transition-colors duration-200">
                                {{ $product->name }}
                            </h3>

                            <div class="flex items-center justify-between mb-4">
                                <div class="flex flex-col">
                                    <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                        {{ number_format($product->price * 0.8, 0, ',', '.') }}₫
                                    </span>
                                    <span class="text-sm text-gray-400 line-through">
                                        {{ number_format($product->price, 0, ',', '.') }}₫
                                    </span>
                                </div>

                                <form action="{{ route('cart.add') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="jewelry_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit"
                                        class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-3 rounded-xl hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 {{ $product->stock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $product->stock == 0 ? 'disabled' : '' }}>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 1.5M7 13l-1.5-1.5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            <!-- Stock Status -->
                            @if($product->stock == 0)
                            <div class="flex items-center text-red-500">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm font-medium">Hết hàng</span>
                            </div>
                            @elseif($product->stock < 10)
                                <div class="flex items-center text-orange-500">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm font-medium">Chỉ còn {{ $product->stock }} sản phẩm</span>
                        </div>
                        @else
                        <div class="flex items-center text-green-500">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-medium">Còn hàng</span>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-span-full">
                    <div class="text-center py-16 bg-white rounded-2xl shadow-lg border border-gray-100">
                        <div class="max-w-md mx-auto">
                            <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center">
                                @if(request('search'))
                                <svg class="w-12 h-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                @else
                                <svg class="w-12 h-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                @endif
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">
                                @if(request('search'))
                                Không tìm thấy sản phẩm cho "{{ request('search') }}"
                                @else
                                Không tìm thấy sản phẩm
                                @endif
                            </h3>
                            <p class="text-gray-600 mb-6">
                                @if(request('search'))
                                Thử tìm kiếm với từ khóa khác hoặc thay đổi bộ lọc để khám phá những món trang sức tuyệt vời.
                                @else
                                Thử thay đổi bộ lọc hoặc tìm kiếm với từ khóa khác để khám phá những món trang sức tuyệt vời.
                                @endif
                            </p>
                            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                @if(request()->hasAny(['search', 'category', 'price_range', 'brand', 'gender']))
                                <a href="{{ route('products.all') }}"
                                    class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                    Xem tất cả sản phẩm
                                </a>
                                @endif
                                @if(request('search'))
                                <a href="{{ route('products.all', request()->except('search')) }}"
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-all duration-200">
                                    Xóa tìm kiếm
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Custom Pagination Component -->
            @if($products->hasPages())
            <div class="mt-12">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <!-- Pagination Info -->
                    <div class="flex flex-col sm:flex-row items-center justify-between mb-8">
                        <div class="text-sm text-gray-600 mb-4 sm:mb-0 bg-gray-50 px-4 py-2 rounded-lg">
                            Hiển thị <span class="font-bold text-indigo-600">{{ $products->firstItem() }}</span>
                            đến <span class="font-bold text-indigo-600">{{ $products->lastItem() }}</span>
                            của <span class="font-bold text-indigo-600">{{ $products->total() }}</span> sản phẩm
                        </div>

                        <!-- Items per page selector -->
                        <div class="flex items-center space-x-3">
                            <span class="text-sm font-medium text-gray-700">Hiển thị:</span>
                            <select onchange="changePerPage(this.value)"
                                class="bg-gray-50 border-2 border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                <option value="16" {{ request('per_page', 16) == 16 ? 'selected' : '' }}>16</option>
                                <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24</option>
                                <option value="32" {{ request('per_page') == 32 ? 'selected' : '' }}>32</option>
                                <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48</option>
                            </select>
                        </div>
                    </div>

                    <!-- Pagination Navigation -->
                    <nav class="flex items-center justify-center">
                        <div class="flex items-center space-x-2 bg-gray-50 rounded-2xl p-2">

                            <!-- First Page Button -->
                            @if($products->onFirstPage())
                            <span class="px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed rounded-xl">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M15.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 010 1.414zm-6 0a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L5.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            @else
                            <a href="{{ $products->url(1) }}"
                                class="px-4 py-2 text-sm font-medium text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-xl transition-all duration-200 shadow-sm hover:shadow-lg">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M15.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 010 1.414zm-6 0a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L5.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            @endif

                            <!-- Previous Button -->
                            @if($products->onFirstPage())
                            <span class="flex items-center px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed rounded-xl">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Trước
                            </span>
                            @else
                            <a href="{{ $products->previousPageUrl() }}"
                                class="flex items-center px-4 py-2 text-sm font-medium text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-xl transition-all duration-200 shadow-sm hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Trước
                            </a>
                            @endif

                            <!-- Page Numbers -->
                            @php
                            $currentPage = $products->currentPage();
                            $lastPage = $products->lastPage();
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($lastPage, $currentPage + 2);
                            @endphp

                            @if($startPage > 1)
                            <a href="{{ $products->url(1) }}"
                                class="px-4 py-2 text-sm font-medium text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-xl transition-all duration-200 shadow-sm hover:shadow-lg">
                                1
                            </a>
                            @if($startPage > 2)
                            <span class="px-3 py-2 text-sm font-medium text-gray-500">...</span>
                            @endif
                            @endif

                            @for($page = $startPage; $page <= $endPage; $page++)
                                @if($page==$currentPage)
                                <span class="px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl shadow-lg">
                                {{ $page }}
                                </span>
                                @else
                                <a href="{{ $products->url($page) }}"
                                    class="px-4 py-2 text-sm font-medium text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-xl transition-all duration-200 shadow-sm hover:shadow-lg">
                                    {{ $page }}
                                </a>
                                @endif
                                @endfor

                                @if($endPage < $lastPage)
                                    @if($endPage < $lastPage - 1)
                                    <span class="px-3 py-2 text-sm font-medium text-gray-500">...</span>
                                    @endif
                                    <a href="{{ $products->url($lastPage) }}"
                                        class="px-4 py-2 text-sm font-medium text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-xl transition-all duration-200 shadow-sm hover:shadow-lg">
                                        {{ $lastPage }}
                                    </a>
                                    @endif

                                    <!-- Next Button -->
                                    @if($products->hasMorePages())
                                    <a href="{{ $products->nextPageUrl() }}"
                                        class="flex items-center px-4 py-2 text-sm font-medium text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-xl transition-all duration-200 shadow-sm hover:shadow-lg">
                                        Tiếp
                                        <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    @else
                                    <span class="flex items-center px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed rounded-xl">
                                        Tiếp
                                        <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    @endif

                                    <!-- Last Page Button -->
                                    @if($products->hasMorePages())
                                    <a href="{{ $products->url($products->lastPage()) }}"
                                        class="px-4 py-2 text-sm font-medium text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-xl transition-all duration-200 shadow-sm hover:shadow-lg">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                            <path fill-rule="evenodd" d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    @else
                                    <span class="px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed rounded-xl">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                            <path fill-rule="evenodd" d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    @endif

                        </div>
                    </nav>
                </div>
            </div>

            <script>
                function changePerPage(value) {
                    const url = new URL(window.location.href);
                    url.searchParams.set('per_page', value);
                    url.searchParams.delete('page');
                    window.location.href = url.toString();
                }
            </script>
            @endif
        </div>
    </div>
</div>
</div>

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Custom scrollbar for sidebar */
    .sidebar-scroll {
        scrollbar-width: thin;
        scrollbar-color: #e2e8f0 transparent;
    }

    .sidebar-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar-scroll::-webkit-scrollbar-thumb {
        background-color: #e2e8f0;
        border-radius: 3px;
    }

    .sidebar-scroll::-webkit-scrollbar-thumb:hover {
        background-color: #cbd5e0;
    }

    /* Gradient animation for hero */
    @keyframes gradient-shift {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .gradient-animate {
        background-size: 200% 200%;
        animation: gradient-shift 8s ease infinite;
    }

    /* Hover effects for product cards */
    .product-card {
        position: relative;
        overflow: hidden;
    }

    .product-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
        z-index: 1;
    }

    .product-card:hover::before {
        left: 100%;
    }

    /* Custom checkbox styles */
    input[type="checkbox"]:checked {
        background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='m13.854 3.646-7.5 7.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6 10.293l7.146-7.147a.5.5 0 0 1 .708.708z'/%3e%3c/svg%3e");
    }

    /* Badge animations */
    .badge-pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: .5;
        }
    }

    /* Material indicator hover effects */
    .material-dot {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .material-dot:hover {
        transform: scale(1.2);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }
</style>
@endpush

@push('scripts')
<script>
    // Enhanced filter functionality with animations
    document.addEventListener('DOMContentLoaded', function() {
        // Handle checkbox filters with smooth transitions
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Add visual feedback
                this.closest('label').classList.add('scale-105');
                setTimeout(() => {
                    this.closest('label').classList.remove('scale-105');
                }, 200);

                // Apply filters with debounce
                clearTimeout(window.filterTimeout);
                window.filterTimeout = setTimeout(applyFilters, 500);
            });
        });

        // Handle sort dropdown
        const sortSelect = document.querySelector('select[name="sort"]');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                applyFilters();
            });
        }

        // Initialize tooltips and lazy loading
        initializeEnhancements();
    });

    function applyFilters() {
        const url = new URL(window.location.href);
        const checkedFilters = document.querySelectorAll('input[type="checkbox"]:checked');

        // Clear existing filter parameters
        ['brand', 'gender', 'price_range', 'brand_type'].forEach(param => {
            url.searchParams.delete(param);
        });

        // Add new filter parameters
        checkedFilters.forEach(checkbox => {
            url.searchParams.append(checkbox.name, checkbox.value);
        });

        // Add sort parameter
        const sortSelect = document.querySelector('select[name="sort"]');
        if (sortSelect) {
            url.searchParams.set('sort', sortSelect.value);
        }

        // Show loading indicator
        showLoadingIndicator();

        // Redirect to new URL
        window.location.href = url.toString();
    }

    // Enhanced add to cart with better UX
    document.querySelectorAll('form[action*="cart/add"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const button = this.querySelector('button[type="submit"]');
            const originalHtml = button.innerHTML;

            // Show loading state
            button.innerHTML = `
            <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
        `;
            button.disabled = true;

            fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showEnhancedNotification('Đã thêm vào giỏ hàng!', 'success');
                        // Add cart animation
                        animateAddToCart(button);
                    } else {
                        showEnhancedNotification('Có lỗi xảy ra!', 'error');
                    }
                })
                .catch(error => {
                    showEnhancedNotification('Có lỗi xảy ra!', 'error');
                })
                .finally(() => {
                    // Restore button
                    setTimeout(() => {
                        button.innerHTML = originalHtml;
                        button.disabled = false;
                    }, 1000);
                });
        });
    });

    function showEnhancedNotification(message, type) {
        const notification = document.createElement('div');
        const bgColor = type === 'success' ? 'from-green-500 to-emerald-600' : 'from-red-500 to-pink-600';

        notification.className = `fixed top-4 right-4 p-6 rounded-2xl text-white z-50 bg-gradient-to-r ${bgColor} shadow-2xl transform translate-x-full transition-transform duration-300 max-w-md`;

        notification.innerHTML = `
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
                ${type === 'success' ? 
                    `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>` :
                    `<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>`
                }
            </div>
            <div>
                <p class="font-semibold">${message}</p>
            </div>
        </div>
    `;

        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        // Animate out
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    function animateAddToCart(button) {
        // Create flying cart animation
        const cart = document.createElement('div');
        cart.innerHTML = `
        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 1.5M7 13l-1.5-1.5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"/>
        </svg>
    `;
        cart.className = 'fixed pointer-events-none z-50 transition-all duration-1000 ease-in-out';

        const buttonRect = button.getBoundingClientRect();
        cart.style.left = buttonRect.left + 'px';
        cart.style.top = buttonRect.top + 'px';

        document.body.appendChild(cart);

        // Animate to top right (cart location)
        setTimeout(() => {
            cart.style.transform = 'translate(50vw, -50vh) scale(0.5)';
            cart.style.opacity = '0';
        }, 100);

        setTimeout(() => cart.remove(), 1100);
    }

    function showLoadingIndicator() {
        const loader = document.createElement('div');
        loader.id = 'page-loader';
        loader.className = 'fixed inset-0 bg-white/80 backdrop-blur-sm z-50 flex items-center justify-center';
        loader.innerHTML = `
        <div class="text-center">
            <div class="w-16 h-16 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-indigo-600 font-semibold">Đang tải sản phẩm...</p>
        </div>
    `;
        document.body.appendChild(loader);
    }

    function initializeEnhancements() {
        // Lazy loading for images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.classList.add('fade-in');
                        observer.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img').forEach(img => {
                imageObserver.observe(img);
            });
        }

        // Add parallax effect to hero section
        const hero = document.querySelector('.bg-gradient-to-r');
        if (hero) {
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const rate = scrolled * -0.5;
                hero.style.transform = `translateY(${rate}px)`;
            });
        }
    }

    // Add CSS classes for animations
    const style = document.createElement('style');
    style.textContent = `
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .scale-105 {
        transform: scale(1.05);
    }
`;
    document.head.appendChild(style);

    // Reset all filters and search
    window.resetAllFilters = function() {
        window.location.href = "{{ route('products.all') }}";
    }
</script>
@endpush
@endsection