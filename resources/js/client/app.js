import '../bootstrap';

// ─── User Dropdown Toggle ───
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('userDropdownBtn');
    const dropdown = document.getElementById('userDropdown');

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
});
