<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Urban Luxe - Khách sạn sang trọng giữa lòng thành phố')</title>
    <meta name="description" content="@yield('meta_description', 'Chào mừng bạn đến với Urban Luxe, nơi cung cấp trải nghiệm nghỉ dưỡng đẳng cấp với phòng nghỉ sang trọng, ẩm thực tinh hoa và tiện ích hiện đại.')">
    <meta name="keywords" content="khách sạn, nghỉ dưỡng, sang trọng, Urban Luxe, đặt phòng khách sạn">
    <link rel="canonical" href="{{ url()->current() }}">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@1,600&display=swap" rel="stylesheet">
    
    <!-- Sử dụng Vite để quản lý CSS và JS cho Client -->
    @vite(['resources/css/client/app.css', 'resources/js/client/app.js', 'resources/css/client/chat-ai.css', 'resources/css/client/animations.css', 'resources/js/client/animations.js'])
    @stack('styles')
    
</head>
<body>  
    @include('client.layouts.header')

    <main>
        @yield('content')
    </main>

    @include('client.layouts.footer')
    
    <!-- AI Chat Box Widget -->
    @include('client.layouts.chat-ai')

    @stack('scripts')
</body>
</html>
