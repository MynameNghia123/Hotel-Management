document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.js-home-booking-form');

    if (!form) {
        return;
    }

    const checkinPicker = document.getElementById('homeCheckinPicker');
    const checkoutPicker = document.getElementById('homeCheckoutPicker');
    const checkinDisplay = document.getElementById('homeCheckinDisplay');
    const checkoutDisplay = document.getElementById('homeCheckoutDisplay');
    const checkinTrigger = form.querySelector('[data-picker="checkin"]');
    const checkoutTrigger = form.querySelector('[data-picker="checkout"]');

    const guestGroup = form.querySelector('.guest-group');
    const guestTrigger = form.querySelector('.js-guest-trigger');
    const guestDropdown = document.getElementById('homeGuestDropdown');
    const guestsDisplay = document.getElementById('homeGuestsDisplay');
    const adultsInput = document.getElementById('homeAdults');
    const childrenInput = document.getElementById('homeChildren');
    const roomsInput = document.getElementById('homeRooms');

    if (!checkinPicker || !checkoutPicker || !checkinDisplay || !checkoutDisplay || !guestGroup || !guestTrigger || !guestDropdown || !guestsDisplay || !adultsInput || !childrenInput || !roomsInput) {
        return;
    }

    const state = {
        adults: Number(adultsInput.value) || 2,
        children: Number(childrenInput.value) || 0,
        rooms: Number(roomsInput.value) || 1,
    };

    const limits = {
        adults: { min: 1, max: 12 },
        children: { min: 0, max: 8 },
        rooms: { min: 1, max: 6 },
    };

    const toIsoDate = (date) => {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    };

    const formatDate = (value) => {
        if (!value) {
            return '';
        }

        const date = new Date(value);
        return Number.isNaN(date.getTime())
            ? ''
            : date.toLocaleDateString('vi-VN');
    };

    const renderGuestState = () => {
        adultsInput.value = String(state.adults);
        childrenInput.value = String(state.children);
        roomsInput.value = String(state.rooms);

        const adultsCount = guestDropdown.querySelector('[data-count-for="adults"]');
        const childrenCount = guestDropdown.querySelector('[data-count-for="children"]');
        const roomsCount = guestDropdown.querySelector('[data-count-for="rooms"]');

        if (adultsCount) adultsCount.textContent = String(state.adults);
        if (childrenCount) childrenCount.textContent = String(state.children);
        if (roomsCount) roomsCount.textContent = String(state.rooms);

        guestsDisplay.value = `${state.adults} Người lớn, ${state.children} Trẻ em, ${state.rooms} Phòng`;
    };

    const syncCheckoutMinDate = () => {
        if (!checkinPicker.value) {
            return;
        }

        const checkinDate = new Date(checkinPicker.value);

        if (Number.isNaN(checkinDate.getTime())) {
            return;
        }

        checkinDate.setDate(checkinDate.getDate() + 1);
        const minCheckoutDate = toIsoDate(checkinDate);
        checkoutPicker.min = minCheckoutDate;

        if (!checkoutPicker.value || checkoutPicker.value < minCheckoutDate) {
            checkoutPicker.value = minCheckoutDate;
        }
    };

    const openNativePicker = (picker) => {
        if (typeof picker.showPicker === 'function') {
            picker.showPicker();
            return;
        }

        picker.focus();
        picker.click();
    };

    const openGuestDropdown = () => {
        guestDropdown.hidden = false;
        guestGroup.classList.add('is-open');
    };

    const closeGuestDropdown = () => {
        guestDropdown.hidden = true;
        guestGroup.classList.remove('is-open');
    };

    const initializeDates = () => {
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(today.getDate() + 1);

        checkinPicker.min = toIsoDate(today);

        if (!checkinPicker.value) {
            checkinPicker.value = toIsoDate(today);
        }

        syncCheckoutMinDate();

        if (!checkoutPicker.value) {
            checkoutPicker.value = toIsoDate(tomorrow);
        }

        checkinDisplay.value = formatDate(checkinPicker.value);
        checkoutDisplay.value = formatDate(checkoutPicker.value);
    };

    checkinTrigger.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();
        openNativePicker(checkinPicker);
    });

    checkoutTrigger.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();
        openNativePicker(checkoutPicker);
    });

    checkinPicker.addEventListener('change', () => {
        syncCheckoutMinDate();
        checkinDisplay.value = formatDate(checkinPicker.value);
        checkoutDisplay.value = formatDate(checkoutPicker.value);
    });

    checkoutPicker.addEventListener('change', () => {
        checkoutDisplay.value = formatDate(checkoutPicker.value);
    });

    guestTrigger.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();

        if (guestDropdown.hidden) {
            openGuestDropdown();
            return;
        }

        closeGuestDropdown();
    });

    guestDropdown.addEventListener('click', (event) => {
        const target = event.target;

        if (!(target instanceof HTMLButtonElement)) {
            return;
        }

        const key = target.dataset.guestTarget;
        const action = target.dataset.action;

        if (!key || !action || !(key in state) || !(key in limits)) {
            return;
        }

        const rule = limits[key];
        const delta = action === 'increase' ? 1 : -1;
        const nextValue = state[key] + delta;

        state[key] = Math.max(rule.min, Math.min(rule.max, nextValue));

        if (key === 'rooms' && state.adults < state.rooms) {
            state.adults = state.rooms;
        }

        renderGuestState();
    });

    document.addEventListener('click', (event) => {
        if (guestGroup.contains(event.target)) {
            return;
        }

        closeGuestDropdown();
    });

    form.addEventListener('submit', (event) => {
        if (!checkinPicker.value || !checkoutPicker.value) {
            event.preventDefault();
            window.alert('Vui lòng chọn đầy đủ ngày nhận và trả phòng.');
            return;
        }

        if (checkoutPicker.value <= checkinPicker.value) {
            event.preventDefault();
            window.alert('Ngày trả phòng phải sau ngày nhận phòng.');
            return;
        }

        if (state.adults < state.rooms) {
            event.preventDefault();
            window.alert('Số người lớn phải lớn hơn hoặc bằng số phòng.');
        }
    });

    initializeDates();
    renderGuestState();
});
