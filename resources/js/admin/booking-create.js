/**
 * Booking Creation Logic
 * Handle customer verification and UI updates
 */

window.verifyCustomer = function() {
    const emailInput = document.getElementById('customerEmail');
    const email = emailInput.value.trim();
    const resultContainer = document.getElementById('verifyResult');
    const existingPanel = document.getElementById('existingCustomer');
    const newPanel = document.getElementById('newCustomer');
    const nameSpan = document.getElementById('customerName');

    if (!email) {
        alert('Vui lòng nhập email để xác thực!');
        emailInput.focus();
        return;
    }

    // Logic mô phỏng: Nếu email có chữ "quan" hoặc "admin" thì coi như khách cũ
    const isExisting = email.toLowerCase().includes('quan') || email.toLowerCase().includes('admin');

    // Hiển thị vùng kết quả
    resultContainer.style.display = 'block';
    resultContainer.style.animation = 'fadeIn 0.3s ease';

    if (isExisting) {
        // Trường hợp 1: Khách hàng thân thiết
        existingPanel.style.display = 'block';
        newPanel.style.display = 'none';
        nameSpan.innerText = 'Lê Minh Quân';
    } else {
        // Trường hợp 2: Khách hàng mới
        existingPanel.style.display = 'none';
        newPanel.style.display = 'block';
    }
}

// Modal Toggle Functions
window.openRoomModal = function() {
    const modal = document.getElementById('roomModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden'; // Ngăn cuộn trang khi mở modal
}

window.closeRoomModal = function() {
    const modal = document.getElementById('roomModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('roomModal');
    if (event.target == modal) {
        closeRoomModal();
    }
}

// Add simple fade in animation via JS if needed or just use CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(style);
