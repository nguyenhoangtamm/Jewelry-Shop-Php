@extends('user.layout')

@section('title', 'Thông báo của tôi')

@section('content')
<div class="container" style="min-height:60vh;padding:32px 0;">
    <h2 style="font-weight:700;margin-bottom:16px;">Thông báo</h2>
    <p>Hiện chưa có thông báo nào.</p>
    <a href="{{ route('profile.show', auth()->id()) }}" class="btn btn-outline-secondary">Về hồ sơ</a>
</div>
@endsection
