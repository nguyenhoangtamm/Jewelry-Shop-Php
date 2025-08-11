@extends('user.layout')
@section('content')
<div class="max-w-66xl mx-auto py-6">
    <h2 class="text-2xl font-bold mb-6 text-center text-pink-700">Sản phẩm yêu thích</h2>
    @if($favorites->isEmpty())
    <div class="text-center text-gray-500 py-8 bg-white rounded shadow">
        Bạn chưa có sản phẩm yêu thích nào.
    </div>
    @else
    <div class="flex flex-col gap-8">
        @foreach($favorites as $favorite)
        <div class="favorite-item bg-white rounded-lg shadow hover:shadow-lg transition p-8 flex flex-col md:flex-row items-start gap-8 relative">

            <div class="w-40 h-40 flex-shrink-0 rounded overflow-hidden bg-gray-100 flex items-center justify-center border">
                @if($favorite->main_image)
                <img src="{{ $favorite->main_image ? asset($favorite->main_image) : 'link-to-default.jpg' }}" alt="{{ $favorite->jewelry->name }}" class="object-cover w-full h-full">
                <span class="text-gray-400 text-2xl">?</span>
                @endif
            </div>
            <div class="flex-1 flex flex-col items-start w-full">
                <h4 class="text-2xl font-semibold text-pink-600 mb-2 truncate w-full">{{ $favorite->jewelry->name }}</h4>
                <p class="text-gray-700 mb-4 text-lg">Giá: <span class="font-bold text-pink-700">{{ number_format($favorite->jewelry->price, 0, ',', '.') }} ₫</span></p>
                <div class="flex gap-4 mt-auto">
                    <a href="{{ route('product.detail', $favorite->jewelry->id) }}" class="inline-flex items-center justify-center w-12 h-12 bg-pink-500 text-white rounded-full hover:bg-pink-600 transition" title="Xem chi tiết">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </a>
                    <form action="{{ route('user.favorites.remove', $favorite->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center w-12 h-12 bg-gray-300 text-gray-700 rounded-full hover:bg-red-500 hover:text-white transition" title="Xóa khỏi yêu thích">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection