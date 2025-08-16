@extends('user.layout')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 py-6">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl mb-4 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-8 h-8 text-white">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Sản phẩm yêu thích</h2>
            <p class="text-gray-600">Bộ sưu tập những món trang sức đặc biệt của bạn</p>
        </div>

        @if($favorites->isEmpty())
        <div class="max-w-lg mx-auto">
            <div class="text-center bg-white rounded-2xl shadow-xl p-10 border border-blue-100">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-100 to-blue-200 rounded-full mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-blue-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Bạn chưa có sản phẩm yêu thích nào.</h3>
                <p class="text-gray-500 leading-relaxed">Hãy khám phá và thêm những sản phẩm bạn yêu thích!</p>
            </div>
        </div>
        @else
        <div class="flex flex-col gap-6">
            @foreach($favorites as $favorite)
            <div class="favorite-item bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 border border-blue-100 hover:border-blue-200 overflow-hidden group transform hover:-translate-y-1">
                <div class="p-6 md:p-8 flex flex-col md:flex-row items-start gap-6 md:gap-8 relative">
                    
                    <!-- Product Image Container -->
                    <div class="relative flex-shrink-0">
                        <div class="w-40 h-40 md:w-48 md:h-48 rounded-xl overflow-hidden bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-100 shadow-inner flex items-center justify-center">
                            @if($favorite->main_image)
                            <img src="{{ $favorite->main_image ? asset($favorite->main_image) : 'link-to-default.jpg' }}" 
                                 alt="{{ $favorite->jewelry->name }}" 
                                 class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-700">
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-12 h-12 text-blue-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                            <span class="text-gray-400 text-2xl">?</span>
                            @endif
                        </div>
                        <!-- Heart Badge -->
                        <div class="absolute -top-2 -right-2 w-7 h-7 bg-gradient-to-r from-red-500 to-pink-500 rounded-full flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-3.5 h-3.5 text-white">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="flex-1 flex flex-col items-start w-full min-w-0">
                        <h4 class="text-xl md:text-2xl font-bold text-gray-800 mb-3 truncate w-full group-hover:text-blue-700 transition-colors duration-300">
                            {{ $favorite->jewelry->name }}
                        </h4>
                        
                        <div class="flex items-center gap-2 mb-6">
                            <p class="text-gray-600 text-base">Giá:</p>
                            <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                                {{ number_format($favorite->jewelry->price, 0, ',', '.') }} ₫
                            </span>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex gap-3 mt-auto">
                            <!-- View Details Button -->
                            <a href="{{ route('product.detail', $favorite->jewelry->id) }}" 
                               class="group/btn inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5" 
                               title="Xem chi tiết">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-2 group-hover/btn:scale-110 transition-transform">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Chi tiết
                            </a>
                            
                            <!-- Remove Button -->
                            <form action="{{ route('user.favorites.remove', $favorite->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="group/btn inline-flex items-center justify-center px-4 py-3 bg-white text-gray-600 border-2 border-gray-200 font-semibold rounded-xl hover:bg-red-50 hover:border-red-200 hover:text-red-600 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5" 
                                        title="Xóa khỏi yêu thích">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 group-hover/btn:scale-110 transition-transform">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

<style>
/* Enhanced hover effects */
.favorite-item:hover {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) scale(1); }
    50% { transform: translateY(-5px) scale(1.02); }
}

/* Smooth transitions for all interactive elements */
.group/btn:hover {
    transform: translateY(-2px) scale(1.05);
}

/* Custom gradient text animation */
.bg-clip-text {
    background-size: 200% 200%;
    animation: gradient 3s ease infinite;
}

@keyframes gradient {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

/* Enhanced shadow effects */
.shadow-lg {
    box-shadow: 0 10px 25px -3px rgba(59, 130, 246, 0.1), 0 4px 6px -2px rgba(59, 130, 246, 0.05);
}

.shadow-2xl {
    box-shadow: 0 25px 50px -12px rgba(59, 130, 246, 0.25), 0 0 0 1px rgba(59, 130, 246, 0.05);
}
</style>
@endsection
