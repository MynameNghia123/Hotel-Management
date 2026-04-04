{{-- CONFIG SECTION 1 --}}
<div class="config-card">
    <div class="config-card-header">
        <label class="config-card-label">
            <div class="config-toggle">
                <input type="checkbox" checked>
                <span class="toggle-slider"></span>
            </div>
            Phí check-in sớm (Early Check-in)
            <svg class="config-info-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
        </label>
    </div>

    <div class="rule-row">
        <div class="rule-input-group">
            <label>Check-in trước (Thời gian)</label>
            <input type="text" class="rule-input" value="01:00">
        </div>
        <div class="rule-input-group">
            <label>Đơn vị</label>
            <select class="rule-input">
                <option>Giờ</option>
                <option>Phút</option>
            </select>
        </div>
        <div class="rule-input-group">
            <label>Số tiền Phụ phí (VND)</label>
            <input type="text" class="rule-input" value="50,000">
        </div>
        <button class="btn-del-rule">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
        </button>
    </div>
    
    <button style="background:transparent; border:none; color:#3b82f6; font-size:13px; font-weight:700; cursor:pointer; margin-top:20px; display:flex; align-items:center; gap:6px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Thêm khung giờ mới
    </button>
</div>

{{-- CONFIG SECTION 2 (Disabled Example) --}}
<div class="config-card" style="opacity: 0.6;">
    <div class="config-card-header">
        <label class="config-card-label">
            <div class="config-toggle">
                <input type="checkbox">
                <span class="toggle-slider"></span>
            </div>
            Phí gửi thêm khách (Extra Guest)
            <svg class="config-info-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color:#94a3b8;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
        </label>
    </div>
    <p style="font-size:12px; color:#94a3b8; margin:0;">Chưa thiết lập quy định cho phần này.</p>
</div>
