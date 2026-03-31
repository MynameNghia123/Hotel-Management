<footer class="admin-footer">
    <div class="admin-footer__inner">

        {{-- LEFT: Branding --}}
        <div class="admin-footer__brand">
            <div class="admin-footer__logo">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 21h16M7 21V7a2 2 0 012-2h6a2 2 0 012 2v14M10 12v.01M14 12v.01M10 16v.01M14 16v.01"/>
                </svg>
            </div>
            <span class="admin-footer__name">Urban Luxe <span>Management</span></span>
        </div>

        {{-- CENTER: Copyright --}}
        <div class="admin-footer__copy">
            &copy; {{ date('Y') }} Urban Luxe Hotel. Hệ thống quản trị nội bộ &mdash; Phiên bản 1.0.0 
        </div>

        {{-- RIGHT: Status & Info --}}
        <div class="admin-footer__meta">
            <div class="admin-footer__status">
                <span class="admin-footer__dot"></span>
                <span>Hệ thống hoạt động bình thường</span>
            </div>
            <div class="admin-footer__divider"></div>
            <span class="admin-footer__time" id="admin-footer-time"></span>
        </div>

    </div>
</footer>

<script>
    function updateFooterTime() {
        const el = document.getElementById('admin-footer-time');
        if (!el) return;
        const now = new Date();
        el.textContent = now.toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    updateFooterTime();
    setInterval(updateFooterTime, 1000);
</script>