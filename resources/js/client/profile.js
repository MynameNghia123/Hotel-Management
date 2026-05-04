// ─── Profile Page JS ───

document.addEventListener('DOMContentLoaded', () => {

    // ── Tab Switching ──
    const tabs = {
        profile: {
            btn: document.getElementById('tab-profile'),
            panel: document.getElementById('section-profile'),
        },
        bookings: {
            btn: document.getElementById('tab-bookings'),
            panel: document.getElementById('section-bookings'),
        },
    };

    function switchTab(tabName) {
        Object.entries(tabs).forEach(([name, { btn, panel }]) => {
            if (!btn || !panel) return;
            const isActive = name === tabName;
            btn.classList.toggle('active', isActive);
            panel.style.display = isActive ? 'block' : 'none';
        });
    }

    // Bind sidebar nav clicks
    Object.entries(tabs).forEach(([name, { btn }]) => {
        btn?.addEventListener('click', (e) => {
            e.preventDefault();
            switchTab(name);
        });
    });

    // Default: show profile tab
    switchTab('profile');

    // ── Auto-dismiss Flash Message ──
    const flash = document.getElementById('flashMessage');
    if (flash) {
        setTimeout(() => {
            flash.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            flash.style.opacity = '0';
            flash.style.transform = 'translateY(-10px)';
            setTimeout(() => flash.remove(), 400);
        }, 4000);
    }

});
