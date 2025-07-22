@extends('user.layout')

@push('styles')
<style>
    .dashboard-container {
        max-width: 800px;
        margin: 20px auto;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .dashboard-user-info {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .logout-btn {
        background: #dc3545;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
    }

    .logout-btn:hover {
        background: #c82333;
    }

    .admin-badge {
        background: #28a745;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
    }

    .customer-badge {
        background: #007bff;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Chào mừng đến với Jewelry App</h1>
        <a href="{{ url('logout') }}" class="logout-btn">Đăng xuất</a>
    </div>
    <div class="dashboard-user-info">
        <h3>Thông tin người dùng:</h3>
        <p><strong>Tên đầy đủ:</strong> {{ Auth::user()->fullname ?? '' }}</p>
        <p><strong>Tên đăng nhập:</strong> {{ Auth::user()->username ?? '' }}</p>
        <p><strong>Email:</strong> {{ Auth::user()->email ?? '' }}</p>
        <p><strong>Vai trò:</strong>
           
        </p>
    </div>
    <div class="actions">
        <h3>Chức năng:</h3>
        <ul>
            <li><a href="{{ url('admin') }}">Trang quản trị</a></li>
            <li><a href="{{ url('admin/users') }}">Quản lý người dùng</a></li>
            <li><a href="{{ url('admin/jewelries') }}">Quản lý trang sức</a></li>
            <li><a href="{{ url('admin/orders') }}">Quản lý đơn hàng</a></li>
           
        </ul>
    </div>
</div>
@endsection