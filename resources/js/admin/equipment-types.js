/**
 * Equipment Types Management
 * Handle modal for creating new equipment group
 */

document.addEventListener('DOMContentLoaded', function() {
    const addBtn = document.querySelector('.dg-btn-primary');
    const modal = document.getElementById('typeModal');
    const closeBtn = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelModal');
    const saveBtn = document.getElementById('saveType');

    // Function to open modal
    window.openTypeModal = function() {
        modal.classList.add('is-visible');
        document.body.style.overflow = 'hidden';
    }

    // Function to close modal
    window.closeTypeModal = function() {
        modal.classList.remove('is-visible');
        document.body.style.overflow = 'auto';
    }

    // Event Listeners
    if (addBtn) {
        addBtn.addEventListener('click', openTypeModal);
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeTypeModal);
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', closeTypeModal);
    }

    // Close on overlay click
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeTypeModal();
            }
        });
    }

    if (saveBtn) {
        saveBtn.addEventListener('click', function() {
            // Mock saving logic
            const name = document.getElementById('typeName').value;
            const code = document.getElementById('typeCode').value;

            if (!name || !code) {
                alert('Vui lòng nhập đầy đủ thông tin!');
                return;
            }

            console.log('Saving new equipment type:', { name, code });
            alert('Lưu thông tin thành công! (Mô phỏng)');
            closeTypeModal();
            
            // Pro Tip: In real implementation, you would send this to the server via Fetch/Axios API
        });
    }
});
