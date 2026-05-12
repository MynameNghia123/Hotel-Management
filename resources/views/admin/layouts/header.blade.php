<header class="admin-header"
    style="height:64px; background:#fff; border-bottom:1px solid #f1f3f7; padding:0 32px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0; box-shadow:0 1px 4px rgba(0,0,0,.04);">
    <div class="admin-header__left" style="display:flex; align-items:center; gap:10px; min-width:0;">
        <button type="button" id="adminSidebarToggle" class="admin-header__menu-btn"
            aria-label="Mở menu quản trị" aria-controls="adminSidebar" aria-expanded="false">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="6" x2="21" y2="6" />
                <line x1="3" y1="12" x2="21" y2="12" />
                <line x1="3" y1="18" x2="21" y2="18" />
            </svg>
        </button>

        <div class="admin-header__workspace"
            style="display:flex; align-items:center; gap:8px; font-size:14px; font-weight:600; color:#1e293b; cursor:pointer; min-width:0;">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6" />
            </svg>
            <span class="admin-header__workspace-label">16819 · Urban Luxe Hotel</span>
            <svg class="admin-header__workspace-chevron" width="13" height="13" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5">
                <polyline points="6 9 12 15 18 9" />
            </svg>
        </div>
    </div>

    <div class="admin-header__actions" style="display:flex; align-items:center; gap:18px;">
        <button type="button" id="adminClientQuickToggle" class="admin-header__client-menu-btn"
            aria-label="Mở menu nhanh website" aria-controls="adminClientQuickNav" aria-expanded="false">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1"
                stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="9" />
                <path d="M3 12h18M12 3c2.2 2.4 3.4 5.6 3.4 9s-1.2 6.6-3.4 9c-2.2-2.4-3.4-5.6-3.4-9s1.2-6.6 3.4-9z" />
            </svg>
        </button>

        <div class="admin-header__workday" style="text-align: right;">
            <span
                style="font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase;">Ngày làm việc</span>
            <div style="font-size:13px; font-weight:700; color:#1e293b;">{{ now()->format('d \T\h\á\n\g m, Y') }}</div>
        </div>
        <button
            style="position:relative; width:36px; height:36px; border:none; background:#f1f5f9; cursor:pointer; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#64748b;">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0" />
            </svg>
            <span
                style="position:absolute; top:8px; right:8px; width:6px; height:6px; background:#ef4444; border-radius:50%;"></span>
        </button>

        {{-- Admin Profile Dropdown --}}
        <div style="position:relative;">
            <button id="adminProfileBtn"
                style="width:36px; height:36px; border-radius:10px; background:#dcfce7; display:flex; align-items:center; justify-content:center; overflow:hidden; border:none; cursor:pointer; padding:0;">
                <img src="https://ui-avatars.com/api/?name={{ Auth::guard('admin')->user()->first_name }}&background=dcfce7&color=16a34a&size=80"
                    style="width:100%; height:100%; object-fit:cover;" alt="Admin User">
            </button>

            {{-- Dropdown Menu --}}
            <div id="adminDropdown"
                style="position:absolute; top:calc(100% + 8px); right:0; background:#ffffff; border:1px solid #e2e8f0; border-radius:8px; box-shadow:0 10px 20px rgba(0,0,0,0.1); min-width:200px; z-index:1000; overflow:hidden; display:none; margin-top:0;">

                {{-- User Info --}}
                <div style="padding:12px 16px; border-bottom:1px solid #f1f5f9; background:#f8fafc;">
                    <div style="font-size:13px; font-weight:600; color:#1e293b;">{{ Auth::guard('admin')->user()->first_name }}
                        {{ Auth::guard('admin')->user()->last_name }}</div>
                    <div style="font-size:12px; color:#94a3b8; margin-top:2px;">
                        {{ Auth::guard('admin')->user()->role->name ?? 'Admin' }}</div>
                </div>

                {{-- Menu Items --}}
                <div style="padding:8px 0;">
                    <a href="#"
                        style="display:flex; align-items:center; gap:10px; padding:10px 16px; color:#64748b; text-decoration:none; font-size:13px; font-weight:500; transition:all 0.2s;"
                        onmouseover="this.style.background='#f8fafc'; this.style.color='#1e293b'"
                        onmouseout="this.style.background='transparent'; this.style.color='#64748b'">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        Hồ sơ cá nhân
                    </a>

                    <a href="#"
                        style="display:flex; align-items:center; gap:10px; padding:10px 16px; color:#64748b; text-decoration:none; font-size:13px; font-weight:500; transition:all 0.2s;"
                        onmouseover="this.style.background='#f8fafc'; this.style.color='#1e293b'"
                        onmouseout="this.style.background='transparent'; this.style.color='#64748b'">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="1" />
                            <circle cx="19" cy="12" r="1" />
                            <circle cx="5" cy="12" r="1" />
                        </svg>
                        Cài đặt
                    </a>
                </div>

                {{-- Divider --}}
                <div style="height:1px; background:#f1f5f9;"></div>

                {{-- Logout --}}
                <form action="{{ route('admin.logout') }}" method="POST" style="padding:0;">
                    @csrf
                    <button type="submit"
                        style="width:100%; display:flex; align-items:center; gap:10px; padding:10px 16px; color:#ef4444; text-decoration:none; font-size:13px; font-weight:500; border:none; background:transparent; cursor:pointer; transition:all 0.2s; text-align:left;"
                        onmouseover="this.style.background='#fee2e2'; this.style.color='#dc2626'"
                        onmouseout="this.style.background='transparent'; this.style.color='#ef4444'">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                        Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<button type="button" id="adminSidebarBackdrop" class="admin-sidebar-backdrop" aria-label="Đóng menu"></button>

<nav id="adminClientQuickNav" class="admin-client-quick-nav" aria-label="Menu nhanh website">
    <a href="{{ route('room') }}" class="admin-client-quick-nav__link">Phòng nghỉ</a>
    <a href="{{ route('amenities') }}" class="admin-client-quick-nav__link">Tiện ích</a>
    <a href="{{ route('dining') }}" class="admin-client-quick-nav__link">Ẩm thực</a>
    <a href="{{ route('gallery') }}" class="admin-client-quick-nav__link">Bộ sưu tập</a>
</nav>

<script>
    (function() {
        const body = document.body;
        const profileBtn = document.getElementById('adminProfileBtn');
        const dropdown = document.getElementById('adminDropdown');
        const sidebarToggle = document.getElementById('adminSidebarToggle');
        const sidebarBackdrop = document.getElementById('adminSidebarBackdrop');
        const clientQuickToggle = document.getElementById('adminClientQuickToggle');
        const clientQuickNav = document.getElementById('adminClientQuickNav');
        const mobileMedia = window.matchMedia('(max-width: 1024px)');

        const setSidebarState = (isOpen) => {
            body.classList.toggle('admin-sidebar-open', isOpen);
            if (sidebarToggle) {
                sidebarToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            }
        };

        const setClientQuickState = (isOpen) => {
            body.classList.toggle('admin-client-quick-nav-open', isOpen);
            if (clientQuickToggle) {
                clientQuickToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            }
        };

        const closeSidebar = () => setSidebarState(false);
        const closeClientQuickNav = () => setClientQuickState(false);
        const closeAllMobilePanels = () => {
            closeSidebar();
            closeClientQuickNav();
        };

        if (sidebarToggle && sidebarBackdrop) {
            sidebarToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const openNext = !body.classList.contains('admin-sidebar-open');
                setSidebarState(openNext);
                if (openNext) {
                    closeClientQuickNav();
                }
            });

            sidebarBackdrop.addEventListener('click', closeAllMobilePanels);

            document.querySelectorAll('.sb .sb-item, .sb .sb-back-web').forEach((link) => {
                link.addEventListener('click', function() {
                    if (mobileMedia.matches) {
                        closeAllMobilePanels();
                    }
                });
            });

            if (clientQuickToggle && clientQuickNav) {
                clientQuickToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const openNext = !body.classList.contains('admin-client-quick-nav-open');
                    setClientQuickState(openNext);
                    if (openNext) {
                        closeSidebar();
                    }
                });

                clientQuickNav.querySelectorAll('a').forEach((link) => {
                    link.addEventListener('click', function() {
                        closeClientQuickNav();
                    });
                });
            }

            if (mobileMedia.addEventListener) {
                mobileMedia.addEventListener('change', function(event) {
                    if (!event.matches) {
                        closeAllMobilePanels();
                    }
                });
            } else if (mobileMedia.addListener) {
                mobileMedia.addListener(function(event) {
                    if (!event.matches) {
                        closeAllMobilePanels();
                    }
                });
            }
        }

        if (profileBtn && dropdown) {
            profileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const isHidden = dropdown.style.display === 'none' || dropdown.style.display === '';
                dropdown.style.display = isHidden ? 'block' : 'none';
            });

            document.addEventListener('click', function(e) {
                if (!profileBtn.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeAllMobilePanels();
                if (dropdown) {
                    dropdown.style.display = 'none';
                }
            }
        });
    })();
</script>
