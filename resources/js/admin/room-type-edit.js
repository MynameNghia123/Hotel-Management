// Modal logic
window.openAmenityModal = function() {
    document.getElementById('amenityModal').classList.add('active');
};
window.openEquipModal = function() {
    document.getElementById('equipModal').classList.add('active');
};
window.closeModal = function(id) {
    document.getElementById(id).classList.remove('active');
};

window.uploadImage = async function(input, roomId) {
    if (!input.files || input.files.length === 0) return;
    
    const file = input.files[0];
    const formData = new FormData();
    formData.append('image', file);

    try {
        const response = await fetch(`/admin/rooms/${roomId}/images`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || csrfToken
            },
            body: formData
        });
        const result = await response.json();
        
        if (result.success) {
            // Append new image to list dynamically
            const list = document.getElementById('media-list');
            
            // Remove empty message if exists
            const emptyMsg = list.querySelector('.empty-msg');
            if (emptyMsg) emptyMsg.remove();

            const imgHtml = `
                <div class="media-item" id="media-${result.image.id}">
                    <img src="${result.image.image_url}" alt="Image">
                    <div class="media-info" style="flex:1;">
                        <strong>New Image</strong>
                        <span>Order: ${result.image.order}</span>
                    </div>
                    <button type="button" class="rte-media-del" onclick="deleteImage(${roomId}, ${result.image.id})">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                    </button>
                </div>
            `;
            list.insertAdjacentHTML('beforeend', imgHtml);
            input.value = ''; // Reset input
        } else {
            alert('Lỗi upload ảnh!');
        }
    } catch (err) {
        console.error(err);
        alert('Có lỗi xảy ra khi upload.');
    }
};

window.deleteImage = async function(roomId, imageId) {
    if(!confirm('Bạn có chắc muốn xóa ảnh này?')) return;

    try {
        const response = await fetch(`/admin/rooms/${roomId}/images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || csrfToken,
                'Content-Type': 'application/json'
            }
        });
        const result = await response.json();
        
        if (result.success) {
            document.getElementById(`media-${imageId}`).remove();
        }
    } catch (err) {
        console.error(err);
        alert('Có lỗi xảy ra khi xóa!');
    }
};

// ================= AMENITIES =================
window.saveAmenities = async function(roomId) {
    const checkboxes = document.querySelectorAll('.amenity-checkbox:checked');
    const amenityIds = Array.from(checkboxes).map(cb => cb.value);

    try {
        const response = await fetch(`/admin/rooms/${roomId}/amenities/sync`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || csrfToken
            },
            body: JSON.stringify({ amenity_ids: amenityIds })
        });
        
        const result = await response.json();
        if (result.success) {
            closeModal('amenityModal');
            // Basic UI Update without reloading mapping HTML string manually or reload page
            alert('Đã cập nhật tiện ích thành công! Tải lại trang để xem thay đổi.');
            location.reload();
        }
    } catch (err) {
        console.error(err);
        alert('Lỗi khi lưu tiện ích.');
    }
};

// ================= EQUIPMENTS =================
window.addEquipmentRow = function(roomId) {
    const select = document.getElementById('new-equip-id');
    const id = select.value;
    const name = select.options[select.selectedIndex].getAttribute('data-name');
    const qty = document.getElementById('new-equip-qty').value;

    if(!id || qty < 1) return;

    const tbody = document.querySelector('#equip-table tbody');
    
    // Check if empty exists
    const emptyMsg = tbody.querySelector('.empty-msg');
    if (emptyMsg) emptyMsg.remove();

    // Check if already in list
    const existingInput = tbody.querySelector(`input[name="equip_id[]"][value="${id}"]`);
    if(existingInput) {
        alert('Thiết bị này đã có trong danh sách!');
        return;
    }

    const rowHtml = `
        <tr>
            <td>${name}<input type="hidden" name="equip_id[]" value="${id}"></td>
            <td style="text-align:center;">
                <input type="number" name="equip_qty[]" class="rte-table-input rte-qty" value="${qty}" min="1" style="text-align:center;" onchange="syncEquipments(${roomId})">
            </td>
            <td style="text-align:right;">
                <button type="button" class="rte-del-row" onclick="removeEquipmentRow(this, ${roomId})">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                </button>
            </td>
        </tr>
    `;
    tbody.insertAdjacentHTML('beforeend', rowHtml);
    closeModal('equipModal');
    
    // Auto sync
    syncEquipments(roomId);
};

window.removeEquipmentRow = function(btn, roomId) {
    if(!confirm('Xóa thiết bị này khỏi phòng?')) return;
    btn.closest('tr').remove();
    syncEquipments(roomId); // auto sync after remove
};

window.syncEquipments = async function(roomId) {
    const ids = document.querySelectorAll('input[name="equip_id[]"]');
    const qtys = document.querySelectorAll('input[name="equip_qty[]"]');
    
    const equipments = [];
    for(let i=0; i<ids.length; i++) {
        equipments.push({
            id: ids[i].value,
            quantity: qtys[i].value
        });
    }

    try {
        const response = await fetch(`/admin/rooms/${roomId}/equipments/sync`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || csrfToken
            },
            body: JSON.stringify({ equipments: equipments })
        });
        
        await response.json();
    } catch (err) {
        console.error('Failed to sync equipments', err);
    }
};
