document.addEventListener('DOMContentLoaded', () => {

    const modal = document.getElementById('addServiceModal');
    const btnOpenList = document.querySelectorAll('.rd-add-serv-btn');
    const btnClose = document.getElementById('closeServiceModal');
    const btnCancel = document.getElementById('cancelServiceModal');

    // Open Modal
    btnOpenList.forEach(btn => {
        btn.addEventListener('click', () => {
            if (modal) {
                modal.classList.add('active');
            }
        });
    });

    // Close Modal
    const closeModal = () => {
        if (modal) {
            modal.classList.remove('active');
        }
    };

    if (btnClose) btnClose.addEventListener('click', closeModal);
    if (btnCancel) btnCancel.addEventListener('click', closeModal);

    // Bấm ra ngoài (overlay) để tắt
    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
    }

    // Xử lý bộ đếm + / -
    const steppers = document.querySelectorAll('.rd-serv-stepper');
    steppers.forEach(stepper => {
        const btnDown = stepper.querySelector('.btn-down');
        const btnUp = stepper.querySelector('.btn-up');
        const spanVal = stepper.querySelector('.rd-serv-step-val');

        btnDown.addEventListener('click', () => {
            let val = parseInt(spanVal.innerText);
            if (val > 0) {
                val--;
                spanVal.innerText = val;
            }
        });

        btnUp.addEventListener('click', () => {
            let val = parseInt(spanVal.innerText);
            val++;
            spanVal.innerText = val;
        });
    });

    // ================= Xử lý Checkout Success ================= //
    const modalSuccess = document.getElementById('checkoutSuccessModal');

    if (modalSuccess) {
        if (modalSuccess.dataset.autoOpen === '1') {
            modalSuccess.classList.add('active');
        }

        modalSuccess.addEventListener('click', (e) => {
            if (e.target === modalSuccess) {
                modalSuccess.classList.remove('active');
            }
        });
    }

    // ================= Preview bill theo kiểu tính giờ/ngày ================= //
    const checkoutForm = document.getElementById('checkoutSelectedRoomsForm');
    const pricingModeSelect = document.getElementById('checkoutPricingMode');
    const checkoutRoomCheckboxes = document.querySelectorAll('.rd-checkout-room-checkbox');
    const billPanel = document.getElementById('checkoutBillPanel');
    let previewController = null;

    const formatMoney = (value) => `${Number(value || 0).toLocaleString('vi-VN')}đ`;
    const escapeHtml = (value) => String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');

    const setText = (selector, text) => {
        const element = document.querySelector(selector);
        if (element) {
            element.textContent = text;
        }
    };

    const renderBillPreview = (preview) => {
        const roomLines = document.querySelector('[data-bill-room-lines]');
        const rooms = Array.isArray(preview.rooms) ? preview.rooms : [];
        const totals = preview.totals || {};
        const unitLabel = preview.pricing_mode === 'daily' ? 'ngày' : 'giờ';

        if (roomLines) {
            if (rooms.length === 0) {
                roomLines.innerHTML = '<div class="rd-bill-row rd-bill-empty"><span>Chọn phòng để xem tạm tính</span><span>0đ</span></div>';
            } else {
                roomLines.innerHTML = rooms.map((room) => {
                    const roomName = escapeHtml(room.room_name || '--');
                    const roomTypeName = escapeHtml(room.room_type_name || 'N/A');
                    const pricingUnits = Number(room.pricing_units || 0);
                    const unitPrice = formatMoney(room.unit_price);
                    const roomAmount = formatMoney(room.room_amount);
                    const surchargeAmount = Number(room.early_checkout_surcharge || 0);
                    const surchargeRow = surchargeAmount > 0
                        ? `<div class="rd-bill-row rd-bill-sub-row"><span>+ Phụ thu checkout sớm (P.${roomName})</span><span>${formatMoney(surchargeAmount)}</span></div>`
                        : '';

                    return `
                        <div class="rd-bill-row">
                            <span>
                                - P.${roomName} (${roomTypeName})
                                <small class="rd-bill-line-note">${pricingUnits} ${unitLabel} x ${unitPrice}</small>
                            </span>
                            <span>${roomAmount}</span>
                        </div>
                        ${surchargeRow}
                    `;
                }).join('');
            }
        }

        setText('[data-bill-service-amount]', formatMoney(totals.service_amount));
        setText('[data-bill-surcharge-amount]', formatMoney(totals.surcharge_amount));
        setText('[data-bill-subtotal]', formatMoney(totals.subtotal));
        setText('[data-bill-vat-amount]', formatMoney(totals.vat_amount));
        setText('[data-bill-grand-total]', formatMoney(totals.grand_total));
        setText('[data-final-grand-total]', formatMoney(totals.grand_total));
    };

    const updateBillPreview = async () => {
        if (!checkoutForm || !pricingModeSelect || !billPanel) {
            return;
        }

        if (previewController) {
            previewController.abort();
        }

        previewController = new AbortController();
        const message = document.querySelector('[data-bill-message]');
        const formData = new FormData();
        const token = checkoutForm.querySelector('input[name="_token"]');

        if (token) {
            formData.append('_token', token.value);
        }

        formData.append('pricing_mode', pricingModeSelect.value);
        document.querySelectorAll('.rd-checkout-room-checkbox:checked').forEach((checkbox) => {
            formData.append('selected_room_ids[]', checkbox.value);
        });

        billPanel.classList.add('is-loading');
        if (message) {
            message.textContent = 'Đang cập nhật tạm tính...';
            message.classList.remove('is-error');
        }

        try {
            const response = await fetch(billPanel.dataset.previewUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData,
                signal: previewController.signal,
            });
            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Không thể cập nhật tạm tính.');
            }

            renderBillPreview(data);
            if (message) {
                const unitLabel = data.pricing_mode === 'daily' ? 'ngày' : 'giờ';
                message.textContent = data.rooms?.length
                    ? `Tạm tính theo ${unitLabel}, cập nhật lúc ${data.billing_end_at || '--'}.`
                    : 'Chọn phòng để xem tạm tính thanh toán.';
            }
        } catch (error) {
            if (error.name === 'AbortError') {
                return;
            }

            if (message) {
                message.textContent = error.message || 'Không thể cập nhật tạm tính.';
                message.classList.add('is-error');
            }
        } finally {
            billPanel.classList.remove('is-loading');
        }
    };

    if (checkoutForm && pricingModeSelect && billPanel) {
        pricingModeSelect.addEventListener('change', updateBillPreview);
        checkoutRoomCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', updateBillPreview);
        });
        updateBillPreview();
    }

});
