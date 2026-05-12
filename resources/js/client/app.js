import '../bootstrap';

// ─── User Dropdown Toggle ───
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('userDropdownBtn');
    const dropdown = document.getElementById('userDropdown');
    const bookNowBtn = document.getElementById('headerBookNowBtn');

    const formatLocalDate = (date) => {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    };

    if (btn && dropdown) {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('open');
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
            }
        });
    }

    if (bookNowBtn) {
        bookNowBtn.addEventListener('click', (e) => {
            e.preventDefault();

            const baseUrl = bookNowBtn.dataset.searchUrl || bookNowBtn.getAttribute('href') || '/search';
            const checkinDate = new Date();
            const checkoutDate = new Date(checkinDate);
            checkoutDate.setDate(checkoutDate.getDate() + 1);

            const url = new URL(baseUrl, window.location.origin);
            url.searchParams.set('checkin', formatLocalDate(checkinDate));
            url.searchParams.set('checkout', formatLocalDate(checkoutDate));
            url.searchParams.set('guests', '2');

            window.location.assign(url.toString());
        });
    }
});
