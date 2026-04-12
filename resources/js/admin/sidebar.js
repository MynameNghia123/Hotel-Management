// File này chỉ giữ nhiệm vụ LUƯ vị trí cuộn
document.addEventListener("DOMContentLoaded", function() {
    const sidebarNav = document.querySelector('.sb-nav');
    
    if (sidebarNav) {
        // Lưu vị trí cuộn mỗi khi người dùng scroll
        sidebarNav.addEventListener('scroll', function() {
            localStorage.setItem('sidebar-scroll', sidebarNav.scrollTop);
        }, { passive: true });

        // Lưu khi click link
        sidebarNav.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                localStorage.setItem('sidebar-scroll', sidebarNav.scrollTop);
            });
        });
    }
});
