<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Urban Luxe Hotel')</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Cấu hình Vite -->
    @vite(['resources/css/admin/app.css', 'resources/css/admin/sidebar.css', 'resources/css/admin/footer.css', 'resources/js/admin/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 font-['Inter']">

    @yield('content')

    @stack('scripts')

</body>
</html>
