<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/styleadmin.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- SweetAlert2 CSS & JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    @include('admin.layouts.sidebar') {{-- nếu có --}}
    <div class="main-content">
        @yield('content')
    </div>
    @include('admin.layouts.footer') {{-- nếu có --}}
</body>

</html>
