@extends('user.layout')

@section('title', 'Điểm thưởng')

@section('content')
<div class="container" style="min-height:60vh;padding:32px 0;">
    <h2 style="font-weight:700;margin-bottom:16px;">Điểm thưởng</h2>
    <p>Tính năng điểm thưởng sẽ sớm có mặt. Vui lòng quay lại sau.</p>
    <a href="{{ route('profile.show', auth()->id()) }}" class="btn btn-outline-secondary">Về hồ sơ</a>
</div>
@endsection
