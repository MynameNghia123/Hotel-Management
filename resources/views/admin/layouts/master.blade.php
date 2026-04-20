<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Urban Luxe Hotel')</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <!-- Cấu hình Vite -->
    @vite(['resources/css/admin/app.css', 'resources/css/admin/sidebar.css', 'resources/css/admin/footer.css', 'resources/js/admin/app.js', 'resources/js/admin/sidebar.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 font-['Inter']">

    @yield('content')

    <x-confirm-delete />

    @stack('scripts')

</body>
</html>
