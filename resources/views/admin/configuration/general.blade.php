{{-- CARD 1: Standard Timing --}}
<div class="config-card">
    <div class="config-card-header">
        <label class="config-card-label">
            <div style="width:32px; height:32px; background:#eff6ff; color:#3b82f6; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            Cài đặt thời gian chuẩn
        </label>
    </div>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px;">
        <div class="rule-input-group">
            <label>Giờ nhận phòng (Check-in)</label>
            <input type="time" class="rule-input" value="14:00">
        </div>
        <div class="rule-input-group">
            <label>Giờ trả phòng (Check-out)</label>
            <input type="time" class="rule-input" value="12:00">
        </div>
        <div class="rule-input-group">
            <label>Thời gian trễ cho phép (Phút)</label>
            <input type="number" class="rule-input" value="15">
            <p style="font-size:11px; color:#94a3b8; margin-top:4px;">Khách trả sau mốc này sẽ bắt đầu tính phụ phí.</p>
        </div>
        <div class="rule-input-group">
            <label>Làm tròn thời gian</label>
            <select class="rule-input">
                <option>Làm tròn lên (15p)</option>
                <option>Làm tròn xuống (15p)</option>
                <option>Theo thực tế</option>
            </select>
        </div>
    </div>
</div>

{{-- CARD 2: Automation --}}
<div class="config-card">
    <div class="config-card-header">
        <label class="config-card-label">
            <div style="width:32px; height:32px; background:#ecfdf5; color:#10b981; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 11-7.778 7.778 5.5 5.5 0 017.777-7.777zm0 0L22 22m-2-2l2 2"/></svg>
            </div>
            Tự động hóa & Vận hành
        </label>
    </div>

    <div style="display:flex; flex-direction:column; gap:20px;">
        <div style="display:flex; justify-content:space-between; align-items:center; padding:12px; background:#f8fafc; border-radius:12px;">
            <div>
                <div style="font-size:13px; font-weight:700; color:#1e293b;">Tự động hủy đặt phòng chưa thanh toán</div>
                <div style="font-size:11px; color:#94a3b8;">Hủy sau 120 phút nếu khách không đến hoặc chưa đặt cọc.</div>
            </div>
            <div class="config-toggle">
                <input type="checkbox" checked>
                <span class="toggle-slider"></span>
            </div>
        </div>

        <div style="display:flex; justify-content:space-between; align-items:center; padding:12px; background:#f8fafc; border-radius:12px;">
            <div>
                <div style="font-size:13px; font-weight:700; color:#1e293b;">Chốt doanh thu tự động (Night Audit)</div>
                <div style="font-size:11px; color:#94a3b8;">Hệ thống tự động chốt số liệu vào 02:00 sáng hàng ngày.</div>
            </div>
            <div class="config-toggle">
                <input type="checkbox" checked>
                <span class="toggle-slider"></span>
            </div>
        </div>
    </div>
</div>

{{-- CARD 3: Currency --}}
<div class="config-card">
    <div class="config-card-header">
        <label class="config-card-label">
            <div style="width:32px; height:32px; background:#fff7ed; color:#f59e0b; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/></svg>
            </div>
            Thanh toán & Tiền tệ
        </label>
    </div>
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px;">
        <div class="rule-input-group">
            <label>Đơn vị tiền tệ chính</label>
            <select class="rule-input">
                <option>VNĐ (Việt Nam Đồng)</option>
                <option>USD (Đô la Mỹ)</option>
            </select>
        </div>
        <div class="rule-input-group">
            <label>Định giá lẻ (Decimal)</label>
            <select class="rule-input">
                <option>Không làm tròn (0.00)</option>
                <option selected>Làm tròn nguyên (VNĐ)</option>
            </select>
        </div>
    </div>
</div>
