{{-- ===== CARD: Check-in / Check-out Time ===== --}}
<div class="general-card">
    <div class="general-field">
        <label class="general-label">Thời gian nhận / trả phòng trong ngày</label>
        <div class="general-time-range">
            <input type="time" class="general-time-input" value="14:00" id="checkin-time">
            <div class="general-time-arrow">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </div>
            <input type="time" class="general-time-input" value="12:00" id="checkout-time">
        </div>
    </div>

    <div class="general-field">
        <label class="general-label">Số phút làm tròn 1 giờ</label>
        <input type="number" class="general-number-input" value="15" min="0" max="59" id="round-minutes">
    </div>
</div>
