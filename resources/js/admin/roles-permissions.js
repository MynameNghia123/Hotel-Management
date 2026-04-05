document.addEventListener('DOMContentLoaded', function() {
    // Select All checkboxes trong table
    const selectAllBtn = document.getElementById('selectAllPermissions');
    const allCheckboxes = document.querySelectorAll('input[name="permissions[]"]');
    
    // Nút Select All
    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', function() {
            const isChecked = selectAllBtn.checked;
            allCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
        });
    }
    
    // Select theo category/section
    const categorySelectors = document.querySelectorAll('[data-category-select]');
    categorySelectors.forEach(selector => {
        selector.addEventListener('click', function() {
            const categoryName = this.dataset.categorySelect;
            const categoryCheckboxes = document.querySelectorAll(
                `input[name="permissions[]"][data-category="${categoryName}"]`
            );
            const isChecked = this.checked;
            categoryCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
        });
    });
    
    // Cập nhật "Select All" khi tất cả checkboxes được checked
    allCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(allCheckboxes).every(cb => cb.checked);
            if (selectAllBtn) {
                selectAllBtn.checked = allChecked;
            }
        });
    });
});
