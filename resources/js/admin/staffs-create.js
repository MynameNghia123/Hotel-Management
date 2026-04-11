/* resources/js/admin/staffs-create.js */

/**
 * Toggle Password Visibility
 * @param {string} fieldId - The ID of the password input field
 */
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    if (!field) return;
    
    const currentType = field.getAttribute('type');
    const newType = currentType === 'password' ? 'text' : 'password';
    field.setAttribute('type', newType);
}

/**
 * Initialize form validation
 */
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (!form) return;

    // Add visual feedback for required fields
    const requiredFields = form.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        field.addEventListener('invalid', function(e) {
            e.preventDefault();
            this.style.borderColor = '#ef4444';
        });

        field.addEventListener('input', function() {
            if (this.validity.valid) {
                this.style.borderColor = '';
            }
        });
    });
});
