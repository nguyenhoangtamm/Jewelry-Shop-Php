@if(Auth::check())
<script>
    function handleLogoutAjax() {
        fetch("{{ route('api.auth.logout') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                // Reload page or redirect to home/login
                window.location.reload();
            })
            .catch(() => {
                alert('Đăng xuất thất bại!');
            });
    }
    document.addEventListener('DOMContentLoaded', function() {
        var logoutBtn = document.getElementById('admin-logout-btn');
        if (logoutBtn) logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            handleLogoutAjax();
        });
    });
</script>
@endif

<div style="width: 100%; display: flex; flex-direction: column; align-items: center; margin-top: 18px; margin-bottom: 10px;">
    <div style="background: #fff; border-radius: 18px; box-shadow: 0 2px 12px rgba(26,35,126,0.08); padding: 18px 12px 10px 12px; display: flex; flex-direction: column; align-items: center; width: 90%; max-width: 180px;">
        <img src="{{ asset('img/logo_2.png') }}" alt="Logo" style="max-width: 90px; max-height: 60px; object-fit: contain; display: block; margin: 0 auto 6px auto;">
        <div style="font-size: 18px; color: #bfa76a; font-weight: 600; letter-spacing: 2px; text-align: center;">TVT</div>
    </div>
</div>
<div class="menu-wrapper d-flex flex-column justify-between">
    <ul class="menu" style="margin-top: 40px;">
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
        <li class="{{ request()->is('admin/orders') || (request()->is('admin/orders/*') && !request()->is('admin/orders/pending*')) ? 'active' : '' }}">
            <a href="{{ url('admin/orders') }}">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                <span>Đơn hàng</span>
            </a>
        </li>
        <li class="{{ request()->is('admin/orders/pending*') ? 'active' : '' }}">
            <a href="{{ route('admin.orders.pending') }}">
                <i class="fa-solid fa-check-circle"></i>
                <span>Duyệt đơn hàng</span>
            </a>
        </li>
        <li class="{{ request()->is('admin/reviews*') ? 'active' : '' }}">
            <a href="{{ route('admin.reviews.index') }}">
                <i class="fa-solid fa-star"></i>
                <span>Đánh giá</span>
            </a>
        </li>
        <li>
            <a href="#" id="admin-logout-btn" style="color: #fff;">
                <i class="fas fa-sign-out-alt"></i>
                <span>Đăng xuất</span>
            </a>
        </li>
    </ul>

</div>