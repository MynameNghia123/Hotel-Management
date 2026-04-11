<aside class="sb">

    <a href="#" class="sb-logo">
        <div class="sb-logo-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                stroke-linecap="round" stroke-linejoin="round">
                <path
                    d="M4 21h16M7 21V7a2 2 0 012-2h6a2 2 0 012 2v14M10 12v.01M14 12v.01M10 16v.01M14 16v.01M10 8v.01M14 8v.01" />
            </svg>
        </div>
        <div>
            <span class="sb-logo-title">URBAN LUXE</span>
            <span class="sb-logo-sub">Management</span>
        </div>
    </a>

    {{-- Navigation --}}
    <nav class="sb-nav">

        {{-- Tổng quan --}}
        <div class="sb-group">
            <ul>
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="sb-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7" rx="1.2" />
                            <rect x="14" y="3" width="7" height="7" rx="1.2" />
                            <rect x="14" y="14" width="7" height="7" rx="1.2" />
                            <rect x="3" y="14" width="7" height="7" rx="1.2" />
                        </svg>
                        Tổng quan
                    </a>
                </li>
            </ul>
        </div>

        {{-- Vận hành --}}
        <div class="sb-group">
            <span class="sb-label">Vận hành</span>
            <ul>
                <li>
                    <a href="{{ route('admin.room-map.index') }}"
                        class="sb-item {{ request()->routeIs('admin.room-map.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7" rx="1.2" />
                            <rect x="14" y="3" width="7" height="7" rx="1.2" />
                            <rect x="14" y="14" width="7" height="7" rx="1.2" />
                            <rect x="3" y="14" width="7" height="7" rx="1.2" />
                        </svg>
                        Sơ đồ phòng
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.room-map-edit.index') }}"
                        class="sb-item {{ request()->routeIs('admin.room-map-edit.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <line x1="3" y1="9" x2="21" y2="9" />
                            <line x1="9" y1="21" x2="9" y2="9" />
                        </svg>
                        Chỉnh sửa sơ đồ phòng
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.bookings.index') }}"
                        class="sb-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                        Quản lý đặt phòng
                        <span class="sb-badge sb-badge-blue">12</span>
                    </a>
                </li>
            </ul>
        </div>

        {{-- Phòng --}}
        <div class="sb-group">
            <span class="sb-label">Quản lý phòng</span>
            <ul>
                <li>
                    <a href="{{ route('admin.rooms.index') }}"
                        class="sb-item {{ request()->routeIs('admin.rooms.*') || request()->routeIs('admin.room-map.detail') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M3 21h18M3 10h18M5 10V7a2 2 0 012-2h10a2 2 0 012 2v3M7 21v-4a2 2 0 012-2h6a2 2 0 012 2v4" />
                        </svg>
                        Danh sách phòng
                    </a>
                </li>

            </ul>
        </div>

        {{-- Tài sản --}}
        <div class="sb-group">
            <span class="sb-label">Quản lý tài sản</span>
            <ul>
                <li>
                    <a href="{{ route('admin.equipment.index') }}"
                        class="sb-item {{ request()->routeIs('admin.equipment.index') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="4" width="16" height="16" rx="2" />
                            <line x1="4" y1="10" x2="20" y2="10" />
                        </svg>
                        Trang thiết bị
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.equipment-types.index') }}"
                        class="sb-item {{ request()->routeIs('admin.equipment-types.index') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z" />
                        </svg>
                        Nhóm thiết bị
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.repair-ticket.index') }}"
                        class="sb-item {{ request()->routeIs('admin.repair-ticket.index') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z" />
                        </svg>
                        Phiếu sửa chữa
                        <span class="sb-badge sb-badge-orange">2</span>
                    </a>
                </li>
            </ul>
        </div>

        {{-- Khách hàng --}}
        <div class="sb-group">
            <span class="sb-label">Khách hàng</span>
            <ul>
                <li>
                    <a href="{{ route('admin.customers.index') }}"
                        class="sb-item {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 00-3-3.87" />
                            <path d="M16 3.13a4 4 0 010 7.75" />
                        </svg>
                        Quản lý khách hàng
                    </a>
                </li>
            </ul>
        </div>

        {{-- Dịch vụ --}}
        <div class="sb-group">
            <span class="sb-label">Dịch vụ &amp; Tiện ích</span>
            <ul>
                <li>
                    <a href="{{ route('admin.services.index') }}"
                        class="sb-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" />
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                            <line x1="12" y1="22.08" x2="12" y2="12" />
                        </svg>
                        Quản lý dịch vụ
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.service-types.index') }}"
                        class="sb-item {{ request()->routeIs('admin.service-types.index') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <line x1="8" y1="6" x2="21" y2="6" />
                            <line x1="8" y1="12" x2="21" y2="12" />
                            <line x1="8" y1="18" x2="21" y2="18" />
                            <line x1="3" y1="6" x2="3.01" y2="6" />
                            <line x1="3" y1="12" x2="3.01" y2="12" />
                            <line x1="3" y1="18" x2="3.01" y2="18" />
                        </svg>
                        Loại dịch vụ
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.amenities.index') }}"
                        class="sb-item {{ request()->routeIs('admin.amenities.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z" />
                        </svg>
                        Quản lý tiện ích
                    </a>
                </li>
            </ul>
        </div>

        {{-- Hệ thống --}}
        <div class="sb-group">
            <span class="sb-label">Hệ thống</span>
            <ul>
                <li>
                    <a href="{{ route('admin.staffs.index') }}"
                        class="sb-item {{ request()->routeIs('admin.staffs.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                            <circle cx="8.5" cy="7" r="4" />
                            <line x1="20" y1="8" x2="20" y2="14" />
                            <line x1="23" y1="11" x2="17" y2="11" />
                        </svg>
                        Quản lý nhân viên
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.roles.index') }}"
                        class="sb-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                        Quản lý vai trò
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.configuration.index') }}"
                        class="sb-item {{ request()->routeIs('admin.configuration.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3" />
                            <path
                                d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.6 9a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 3a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.6a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z" />
                        </svg>
                        Cấu hình chung
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.statistical.index') }}"
                        class="sb-item {{ request()->routeIs('admin.statistical.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 20V10M12 20V4M6 20v-6" />
                        </svg>
                        Thống kê
                    </a>
                </li>
            </ul>
        </div>

        {{-- Bottom actions --}}
        <div class="sb-bottom">

            {{-- Nút quay lại trang web --}}
            <a href="{{ route('home') }}" class="sb-back-web" target="_blank">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20" />
                </svg>
                Xem trang web
                <svg class="sb-back-web__arrow" width="13" height="13" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6" />
                    <polyline points="15 3 21 3 21 9" />
                    <line x1="10" y1="14" x2="21" y2="3" />
                </svg>
            </a>

            {{-- Widget hỗ trợ --}}
            <div class="sb-footer">
                <div class="sb-footer-head">
                    <div class="sb-footer-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                        </svg>
                    </div>
                    <strong>Hỗ trợ kỹ thuật</strong>
                </div>
                <p>Giải đáp mọi thắc mắc qua trung tâm trợ giúp.</p>
                <button class="sb-footer-btn">Liên hệ ngay</button>
            </div>

        </div>

    </nav>

</aside>