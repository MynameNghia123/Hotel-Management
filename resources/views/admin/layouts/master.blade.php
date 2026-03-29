<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Tiêu đề trang động (nếu có yield), mặc định là Admin Dashboard -->
    <title>@yield('title', 'Admin Dashboard - Urban Luxe Management')</title>
    
    <!-- Cấu hình Vite/Tailwind 4.x -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Thêm CSS động bổ sung nếu cần -->
    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen">
    
    <!-- Nội dung chính của các file blade khác sẽ được gắn vào đây -->
    <main class="w-full flex items-center justify-center min-h-screen">
        @yield('content')
    </main>

    <!-- Thêm JS động bổ sung nếu cần -->
    @stack('scripts')
</body>
</html>
