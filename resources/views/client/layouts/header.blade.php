<!-- --- Header / Navbar --- -->
<header class="navbar">
    <div class="nav-container">
        <!-- Logo -->
        <a href="/" class="logo">
            <div class="logo-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Icon giống Urban Luxe -->
                    <rect x="3" y="10" width="8" height="12" fill="white" rx="1" />
                    <rect x="13" y="4" width="8" height="18" fill="white" rx="1" />
                </svg>
            </div>
            <span>Urban Luxe</span>
        </a>

        <!-- Links -->
        <ul class="nav-links">
            <li><a href="{{ route('room') }}">Phòng Nghỉ</a></li>
            <li><a href="{{ route('amenities') }}">Tiện Ích</a></li>
            <li><a href="{{ route('dining') }}">Ẩm Thực</a></li>
            <li><a href="{{ route('gallery') }}">Bộ Sưu Tập</a></li>
        </ul>

        <!-- Right actions -->
        <div class="nav-actions">
            <a href="{{ route('login') }}" class="sign-in-link">Đăng Nhập</a>
            <span style="color: rgba(255,255,255,0.2)">/</span>
            <a href="{{ route('register') }}" class="sign-in-link">Đăng Ký</a>
            <a href="#" class="btn btn-primary" style="margin-left: 10px;">Đặt Phòng Ngay</a>
        </div>
    </div>
</header>
