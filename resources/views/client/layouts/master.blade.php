<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urban Luxe - Sanctuary in the City</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Link file css tĩnh được lưu ở public/css/style.css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
    
</head>
<body>
    @include('client.layouts.header')

    <main>
        @yield('content')
    </main>

    @include('client.layouts.footer')

</body>
</html>
