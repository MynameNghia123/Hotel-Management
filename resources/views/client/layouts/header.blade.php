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
            @auth
                <!-- User Dropdown -->
                <div class="user-dropdown" id="userDropdown">
                    <button class="user-dropdown-trigger" id="userDropdownBtn" type="button">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->first_name ?: Auth::user()->email, 0, 1)) }}
                        </div>
                        <span class="user-name-label">{{ trim(Auth::user()->last_name . ' ' . Auth::user()->first_name) ?: 'Khách' }}</span>
                        <svg class="dropdown-chevron" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="user-dropdown-menu" id="userDropdownMenu">
                        <div class="dropdown-user-info">
                            <div class="dropdown-avatar-lg">
                                {{ strtoupper(substr(Auth::user()->first_name ?: Auth::user()->email, 0, 1)) }}
                            </div>
                            <div>
                                <div class="dropdown-full-name">{{ trim(Auth::user()->last_name . ' ' . Auth::user()->first_name) ?: 'Khách' }}</div>
                                <div class="dropdown-email">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('profile') }}" class="dropdown-item">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M12 11a4 4 0 100-8 4 4 0 000 8z"/>
                            </svg>
                            Hồ Sơ Cá Nhân
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-item-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Đăng Xuất
                        </a>
                        <form id="logout-form" action="{{ route('client.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="sign-in-link">Đăng Nhập</a>
                <span style="color: rgba(255,255,255,0.2)">/</span>
                <a href="{{ route('register') }}" class="sign-in-link">Đăng Ký</a>
            @endauth
            <a href="#" class="btn btn-primary" style="margin-left: 10px;">Đặt Phòng Ngay</a>
        </div>
    </div>
</header>
