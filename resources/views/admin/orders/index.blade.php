@extends('admin.layouts.app')
@section('title', 'Quản lý đơn hàng')
@section('content')
<div class="table-wrapper">
    <h3 class="main-title">Đơn hàng đang chờ xử lý</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Ngày đặt</th>
                    <th>Khách hàng</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ghi chú</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td class="order-id">{{ $order->id }}</td>
                    <td class="order-date">{{ $order->created_at }}</td>
                    <td class="order-name">{{ $order->user->fullname ?? '' }}</td>
                    <td class="order-address">{{ $order->user->address ?? '' }}</td>
                    <td class="order-phone_number">{{ $order->user->phone_number ?? '' }}</td>
                    <td class="order-price">{{ number_format($order->total_price, 0, ',', '.') }} VND</td>
                    <td class="order-status {{ $order->status }}">{{ $order->status }}</td>
                    <td class="order-notes">{{ $order->notes }}</td>
                    <td>
                        <button type="button" class="fas fa-trash icon-delete js-delete-order" data-order-id="{{ $order->id }}" data-status="{{ $order->status }}"></button>
                        <button type="button" class="fa-regular fa-eye icon-detail js-detail-order" data-order-id="{{ $order->id }}" data-status="{{ $order->status }}"></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination" style="justify-content:center;">
            @php
            $currentPage = $orders->currentPage();
            $lastPage = $orders->lastPage();
            @endphp
            <a href="{{ $orders->url(max($currentPage-1,1)) }}" class="prev">Trang trước</a>
            @for ($i = 1; $i <= $lastPage; $i++)
                <a href="{{ $orders->url($i) }}" class="{{ $currentPage == $i ? 'page-current' : '' }}">{{ $i }}</a>
            @endfor
            <a href="{{ $orders->url(min($currentPage+1,$lastPage)) }}" class="next">Trang sau</a>
        </div>
    </div>
</div>
<!-- Modal xem chi tiết, xoá, lỗi... (bạn có thể copy từ file modal cũ nếu đã có) -->
@endsection
