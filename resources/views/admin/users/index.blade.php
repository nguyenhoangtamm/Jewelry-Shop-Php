@extends('admin.layouts.app')
@section('title', 'Quản lý khách hàng')
@section('content')
<style>
    .icon-change {
        background: none;
        border: none;
        color: #007bff;
        cursor: pointer;
        padding: 5px;
        margin-right: 10px;
    }

    .icon-change:hover {
        color: #0056b3;
    }
</style>
<div class="table-wrapper">
    <div class="table-header table-header-customer">
        <h3 class="main-title">Thông tin khách hàng</h3>
        <form method="GET" action="" class="customer-search" style="display:inline-block;">
            <input type="text" name="search" value="{{ request('search') }}" class="customer-text-search" placeholder="Tìm kiếm...">
            <button type="submit" class="fa-solid fa-magnifying-glass" style="border:none;background:none;"></button>
        </form>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Ngày sinh</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td class="customer-id">{{ $user->id }}</td>
                    <td class="customer-name">{{ $user->username }}</td>
                    <td class="customer-birthday">{{ $user->date_of_birth }}</td>
                    <td class="customer-address">{{ $user->address }}</td>
                    <td class="customer-phone">{{ $user->phone_number }}</td>
                    <td class="customer-email">{{ $user->email }}</td>
                    <td>
                        <button type="button" class="fa-solid fa-pen icon-change edit-customer-btn" data-customer-id="{{ $user->id }}" data-username="{{ $user->username }}" data-date_of_birth="{{ $user->date_of_birth }}" data-email="{{ $user->email }}" data-phone_number="{{ $user->phone_number }}" data-address="{{ $user->address }}"></button>
                        <button type="button" class="fas fa-trash icon-delete delete-customer-btn" data-customer-id="{{ $user->id }}"></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination" style="justify-content:center;">
            @php
            $currentPage = $users->currentPage();
            $lastPage = $users->lastPage();
            $search = request('search');
            @endphp
            <a href="{{ $users->url(max($currentPage-1,1)) }}{{ $search ? '&search=' . urlencode($search) : '' }}" class="prev">Trước</a>
            @for ($i = 1; $i <= $lastPage; $i++)
                <a href="{{ $users->url($i) }}{{ $search ? '&search=' . urlencode($search) : '' }}" class="{{ $currentPage == $i ? 'page-current' : '' }}">{{ $i }}</a>
                @endfor
                <a href="{{ $users->url(min($currentPage+1,$lastPage)) }}{{ $search ? '&search=' . urlencode($search) : '' }}" class="next">Sau</a>
        </div>
    </div>
</div>
<!-- Edit Customer Modal -->
<div id="editCustomerModal" class="modal js-modal-customer modal-change-customer" style="display: none;">
    <form id="editCustomerForm" class="modal-container js-modalCustomer-container modal-container-customer" method="POST" action="">
        @csrf
        @method('PUT')
        <div class="modal-close js-modalCustomer-close">
            <i class="fa-solid fa-xmark"></i>
        </div>
        <header class="modal-header">
            <i class="modal-heading-icon fa-solid fa-user"></i>
            Chỉnh sửa thông tin khách hàng
        </header>
        <div class="modal-content">
            <input type="hidden" id="editCustomerId" name="id">
            <div class="modal-twoCol">
                <label for="editCustomerName" class="modal-label">
                    Họ tên
                    <input name="username" id="editCustomerName" type="text" class="modal-input modal-input-customer" placeholder="Họ tên..." required>
                    <span class="name-changeCustomer-error check-error"></span>
                </label>
                <label for="editCustomerBirthday" class="modal-label">
                    Ngày sinh
                    <input name="date_of_birth" id="editCustomerBirthday" type="date" class="modal-input modal-input-customer" required>
                    <span class="birthday-changeCustomer-error check-error"></span>
                </label>
                <label for="editCustomerEmail" class="modal-label">
                    Email
                    <input name="email" id="editCustomerEmail" type="email" class="modal-input modal-input-customer" placeholder="Email..." required>
                    <span class="email-changeCustomer-error check-error"></span>
                </label>
                <label for="editCustomerPhone" class="modal-label">
                    Số điện thoại
                    <input name="phone_number" id="editCustomerPhone" type="text" class="modal-input modal-input-customer" placeholder="Số điện thoại..." required>
                    <span class="phone-changeCustomer-error check-error"></span>
                </label>
            </div>
            <div class="modal-col">
                <label for="editCustomerAddress" class="modal-label">
                    Địa chỉ
                    <input name="address" id="editCustomerAddress" type="text" class="modal-input modal-input-customer" placeholder="Địa chỉ..." required>
                    <span class="address-changeCustomer-error check-error"></span>
                </label>
            </div>
            <div class="action-form">
                <div class="cancel-book js-cancel-customer">Hủy</div>
                <button type="submit" class="submit-book js-change-customer">Lưu</button>
            </div>
        </div>
    </form>
</div>
<!-- Delete Customer Modal -->
<div id="deleteCustomerModal" class="modal-delete js-modal-deleteCustomer" style="display: none;">
    <form class="modal-delete-container js-modal-deleteCustomer-container" method="POST" action="">
        @csrf
        @method('DELETE')
        <div class="modal-delete-close js-modal-deleteCustomer-close">
            <i class="fa-solid fa-xmark"></i>
        </div>
        <div class="modal-delete-body">
            <p>Bạn có chắc chắn muốn xóa khách hàng này không?</p>
            <div class="btn-delete-choose">
                <button type="submit" id="confirmDeleteCustomer" class="btn-yes js-customer-btn-yes">Có</button>
                <div class="btn-no js-customer-btn-no">Không</div>
            </div>
        </div>
    </form>
</div>
<!-- Toast Messages -->
<div id="toast-customer-success" class="toast-message toast-success" style="display: none;">
    <i class="fa-solid fa-circle-check"></i>
    <span class="toast-text"></span>
</div>
<div id="toast-customer-error" class="toast-message toast-error" style="display: none;">
    <i class="fa-solid fa-circle-xmark"></i>
    <span class="toast-text"></span>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentCustomerId = null;
        // Edit customer
        document.querySelectorAll('.edit-customer-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                currentCustomerId = btn.getAttribute('data-customer-id');
                document.getElementById('editCustomerId').value = currentCustomerId;
                document.getElementById('editCustomerName').value = btn.getAttribute('data-username');
                document.getElementById('editCustomerBirthday').value = btn.getAttribute('data-date_of_birth');
                document.getElementById('editCustomerEmail').value = btn.getAttribute('data-email');
                document.getElementById('editCustomerPhone').value = btn.getAttribute('data-phone_number');
                document.getElementById('editCustomerAddress').value = btn.getAttribute('data-address');
                document.getElementById('editCustomerModal').style.display = 'flex';
                document.getElementById('editCustomerForm').action = '/admin/users/' + currentCustomerId;
            });
        });
        // Delete customer
        document.querySelectorAll('.delete-customer-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                currentCustomerId = btn.getAttribute('data-customer-id');
                document.getElementById('deleteCustomerModal').style.display = 'flex';
                document.querySelector('.js-modal-deleteCustomer-container').action = '/admin/users/' + currentCustomerId;
            });
        });
        // Close modals
        document.querySelectorAll('.js-modalCustomer-close, .js-cancel-customer').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.getElementById('editCustomerModal').style.display = 'none';
            });
        });
        document.querySelectorAll('.js-modal-deleteCustomer-close, .js-customer-btn-no').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.getElementById('deleteCustomerModal').style.display = 'none';
            });
        });
        // Close modal when clicking outside
        document.querySelectorAll('.modal, .modal-delete').forEach(function(modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
