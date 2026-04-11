/* resources/js/admin/staffs-index.js */

/**
 * Toggle Staff Active Status via AJAX
 */
document.addEventListener('DOMContentLoaded', function() {
    const switches = document.querySelectorAll('.sf-switch input[type="checkbox"]');
    
    switches.forEach(switchEl => {
        switchEl.addEventListener('change', function() {
            const staffId = this.getAttribute('data-staff-id');
            const isActive = this.checked ? 1 : 0;
            
            // Disable checkbox while processing
            this.disabled = true;
            const slider = this.nextElementSibling;
            slider.style.opacity = '0.5';
            
            // Send AJAX request
            fetch(`/admin/staffs/${staffId}/toggle-status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    is_active: isActive
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update status display
                    const statusCell = this.closest('tr').querySelector('.sf-status-flex');
                    if (statusCell) {
                        if (isActive) {
                            statusCell.className = 'sf-status-flex sf-dot-green';
                            statusCell.innerHTML = '<svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>Đang hoạt động';
                        } else {
                            statusCell.className = 'sf-status-flex sf-dot-red';
                            statusCell.innerHTML = '<svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>Ngừng hoạt động';
                        }
                    }
                    
                    // Show success message
                    showNotification(data.message || 'Cập nhật thành công!', 'success');
                } else {
                    // Revert checkbox
                    this.checked = !isActive;
                    showNotification(data.message || 'Cập nhật thất bại!', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revert checkbox
                this.checked = !isActive;
                showNotification('Lỗi kết nối với máy chủ!', 'error');
            })
            .finally(() => {
                // Re-enable checkbox
                this.disabled = false;
                slider.style.opacity = '1';
            });
        });
    });
});

/**
 * Show Notification Toast
 * @param {string} message - Message to display
 * @param {string} type - 'success' or 'error'
 */
function showNotification(message, type = 'success') {
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        z-index: 9999;
        animation: slideIn 0.3s ease;
        ${type === 'success' 
            ? 'background: #dcfce7; border: 1px solid #86efac; color: #166534;' 
            : 'background: #fecaca; border: 1px solid #fca5a5; color: #991b1b;'
        }
    `;
    
    toast.textContent = message;
    document.body.appendChild(toast);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Add CSS animations
if (!document.querySelector('style[data-toast-animations]')) {
    const style = document.createElement('style');
    style.setAttribute('data-toast-animations', 'true');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
}
