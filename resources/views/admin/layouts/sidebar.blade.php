<ul class="menu">
    <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Bảng điều khiển</span>
        </a>
    </li>
    <li class="{{ request()->is('admin/jewelries*') ? 'active' : '' }}">
        <a href="{{ url('admin/jewelries') }}">
            <i class="fa-solid fa-gem"></i>
            <span>Trang sức</span>
        </a>
    </li>
    <li class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
        <a href="{{ url('admin/categories') }}">
            <i class="fa-solid fa-tags"></i>
            <span>Danh mục</span>
        </a>
    </li>
    <li class="{{ request()->is('admin/users*') ? 'active' : '' }}">
        <a href="{{ url('admin/users') }}">
            <i class="fa-solid fa-user"></i>
            <span>Khách hàng</span>
        </a>
    </li>
    <li class="{{ request()->is('admin/orders*') ? 'active' : '' }}">
        <a href="{{ url('admin/orders') }}">
            <i class="fa-solid fa-file-invoice-dollar"></i>
            <span>Đơn hàng</span>
        </a>
    </li>
    <li class="logout">
        <a href="{{ url('user/login-signup') }}">
            <i class="fas fa-sign-out-alt"></i>
            <span>Đăng xuất</span>
        </a>
    </li>
</ul>

<div class="header-wrapper">
    <div class="header-title">
        <h2>@yield('page_header', 'Trang quản trị')</h2>
    </div>
    <div class="user-info">
        <img src="{{ asset('images_web/avatar.png') }}" alt="avatar">
    </div>
</div>
