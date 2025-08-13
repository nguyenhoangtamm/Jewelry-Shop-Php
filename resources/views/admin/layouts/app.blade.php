<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Jewelry Admin</title>
    <link rel="stylesheet" href="{{ asset('css/styleadmin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    @if (!empty($include_chart_js))
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    @endif
    @if (!empty($include_multi_select))
    <link rel="stylesheet" href="{{ asset('css/multi-select.css') }}">
    @endif
    @if (!empty($include_datatables))
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    @endif
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('head')
</head>

<body>
    <div class="sidebar">
        @include('admin.layouts.sidebar')
    </div>
    <div class="main-content">
        @yield('content')
    </div>
    @include('admin.layouts.footer')
    @stack('scripts')
</body>

</html>