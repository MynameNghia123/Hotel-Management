document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.js-results-container');

    if (!container) {
        return;
    }

    const qtyInputs = Array.from(container.querySelectorAll('.js-room-qty'));
    const totalNode = container.querySelector('.js-summary-total');
    const selectionNode = container.querySelector('.js-summary-selection');
    const actionNode = container.querySelector('.js-summary-action');

    if (qtyInputs.length === 0 || !totalNode || !selectionNode || !actionNode) {
        return;
    }

    const nights = Math.max(1, Number(container.dataset.nights || 1));
    const criteria = {
        checkin: container.dataset.checkin || '',
        checkout: container.dataset.checkout || '',
        adults: container.dataset.adults || '1',
        children: container.dataset.children || '0',
        rooms: container.dataset.requestedRooms || '1',
    };

    const formatCurrency = (value) => {
        return `${Number(value).toLocaleString('vi-VN')} d`;
    };

    const clampInputValue = (input) => {
        const min = Number(input.min || 0);
        const max = Number(input.max || 0);
        let value = Number(input.value || 0);

        if (!Number.isFinite(value)) {
            value = 0;
        }

        value = Math.max(min, Math.min(max, Math.floor(value)));
        input.value = String(value);
    };

    const getSelectedRows = () => {
        return qtyInputs
            .map((input) => {
                const row = input.closest('.js-room-row');

                if (!row) {
                    return null;
                }

                const quantity = Number(input.value || 0);
                const unitPrice = Number(row.dataset.price || 0);
                const roomId = row.dataset.roomId || '';
                const roomName = row.dataset.roomName || 'Phong';

                if (!roomId || quantity <= 0) {
                    return null;
                }

                return {
                    roomId,
                    roomName,
                    quantity,
                    unitPrice,
                    subtotal: quantity * unitPrice * nights,
                };
            })
            .filter(Boolean);
    };

    const buildCheckoutUrl = (selectedRows) => {
        const params = new URLSearchParams({
            checkin: criteria.checkin,
            checkout: criteria.checkout,
            adults: criteria.adults,
            children: criteria.children,
            rooms: criteria.rooms,
        });

        selectedRows.forEach((item) => {
            params.append(`room_quantities[${item.roomId}]`, String(item.quantity));
        });

        return `${actionNode.href.split('?')[0]}?${params.toString()}`;
    };

    const updateSummary = () => {
        qtyInputs.forEach(clampInputValue);

        const selectedRows = getSelectedRows();
        const totalAmount = selectedRows.reduce((sum, item) => sum + item.subtotal, 0);
        const totalRooms = selectedRows.reduce((sum, item) => sum + item.quantity, 0);

        totalNode.textContent = formatCurrency(totalAmount);

        if (totalRooms === 0) {
            selectionNode.textContent = 'Chua chon phong';
            actionNode.classList.add('is-disabled');
            actionNode.setAttribute('aria-disabled', 'true');
            return;
        }

        const topItems = selectedRows.slice(0, 2).map((item) => `${item.roomName} x${item.quantity}`);
        const moreLabel = selectedRows.length > 2 ? ` +${selectedRows.length - 2} loai` : '';
        selectionNode.textContent = `${totalRooms} phong • ${topItems.join(', ')}${moreLabel}`;

        actionNode.classList.remove('is-disabled');
        actionNode.removeAttribute('aria-disabled');
        actionNode.href = buildCheckoutUrl(selectedRows);
    };

    qtyInputs.forEach((input) => {
        input.addEventListener('input', updateSummary);
        input.addEventListener('change', updateSummary);
    });

    actionNode.addEventListener('click', (event) => {
        if (actionNode.classList.contains('is-disabled')) {
            event.preventDefault();
        }
    });

    updateSummary();
});
