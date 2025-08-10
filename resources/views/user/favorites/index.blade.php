@extends('user.layout')

@section('title', 'Sản phẩm yêu thích')

@section('content')
<div class="container" style="min-height:60vh;padding:32px 0;">
    <h2 style="font-weight:700;margin-bottom:16px;">Sản phẩm yêu thích</h2>
    <p>Trang này đang được phát triển. Hiện chưa có sản phẩm yêu thích để hiển thị.</p>
    <a href="{{ route('products.all') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
</div>
@endsection
