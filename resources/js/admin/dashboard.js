document.addEventListener('DOMContentLoaded', () => {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabTitle = document.getElementById('tab-title');
    const tabDesc = document.getElementById('tab-desc');
    const tableBody = document.getElementById('dashboard-table-body');

    // Lưu lại style của nút
    const activeBg = '#2a3f8a';
    const activeColor = '#fff';
    const inactiveBg = 'transparent';
    const inactiveColor = '#64748b';

    const activeIcon = `<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>`;

    // --- Dữ liệu MOCK để test Giao Diện ---
    const mockData = {
        incoming: {
            title: "Danh Sách Khách Sẽ Đến",
            desc: "Danh sách khách hàng dự kiến nhận phòng hôm nay",
            html: `
                <tr style="border-bottom:1px solid #f8f9fb;">
                    <td style="padding:14px 28px;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:34px; height:34px; border-radius:9px; background:#eff6ff; border:1px solid #bfdbfe; display:flex; align-items:center; justify-content:center; color:#3b82f6;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                            </div>
                            <span style="font-size:14px; font-weight:700; color:#0f172a;">301 (Deluxe)</span>
                        </div>
                    </td>
                    <td style="padding:14px 16px; font-size:13px; color:#64748b; font-weight:500;">#BK-8821</td>
                    <td style="padding:14px 16px;">
                        <div style="display:flex; align-items:center; gap:7px;">
                            <span>🇻🇳</span>
                            <span style="font-size:13.5px; font-weight:700; color:#0f172a;">Nguyễn Anh Tuấn</span>
                        </div>
                    </td>
                    <td style="padding:14px 16px; font-size:13px; color:#64748b;">14:00 · Hôm nay</td>
                    <td style="padding:14px 16px;"><span style="padding:3px 10px; background:#eff6ff; color:#2563eb; border-radius:99px; font-size:11px; font-weight:700;">2 NL / 1 TE</span></td>
                    <td style="padding:14px 28px; text-align:right;">
                        <button style="padding:5px 14px; background:#eff6ff; color:#2a3f8a; border:none; border-radius:8px; font-size:12px; font-weight:700; cursor:pointer;">Xem</button>
                    </td>
                </tr>
            `
        },
        outgoing: {
            title: "Danh Sách Khách Sẽ Đi",
            desc: "Danh sách khách hàng dự kiến trả phòng hôm nay",
            html: `
                <tr style="border-bottom:1px solid #f8f9fb;">
                    <td style="padding:14px 28px;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:34px; height:34px; border-radius:9px; background:#fdf4ff; border:1px solid #fbcfe8; display:flex; align-items:center; justify-content:center; color:#ec4899;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                            </div>
                            <span style="font-size:14px; font-weight:700; color:#0f172a;">205 (Standard)</span>
                        </div>
                    </td>
                    <td style="padding:14px 16px; font-size:13px; color:#64748b; font-weight:500;">#BK-7742</td>
                    <td style="padding:14px 16px;">
                        <div style="display:flex; align-items:center; gap:7px;">
                            <span>🇰🇷</span>
                            <span style="font-size:13.5px; font-weight:700; color:#0f172a;">Kim Ji Won</span>
                        </div>
                    </td>
                    <td style="padding:14px 16px; font-size:13px; color:#64748b;">12:00 · Hôm nay</td>
                    <td style="padding:14px 16px;"><span style="padding:3px 10px; background:#f0fdf4; color:#16a34a; border-radius:99px; font-size:11px; font-weight:700;">Đã Thanh Toán</span></td>
                    <td style="padding:14px 28px; text-align:right;">
                        <button style="padding:5px 14px; background:#eff6ff; color:#2a3f8a; border:none; border-radius:8px; font-size:12px; font-weight:700; cursor:pointer;">Thủ Tục</button>
                    </td>
                </tr>
            `
        },
        staying: {
            title: "Danh Sách Khách Đang Ở",
            desc: "Khách đang lưu trú tại khách sạn",
            html: `
                <tr style="border-bottom:1px solid #f8f9fb;">
                    <td style="padding:14px 28px;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:34px; height:34px; border-radius:9px; background:#f0fdf4; border:1px solid #bbf7d0; display:flex; align-items:center; justify-content:center; color:#22c55e;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                            </div>
                            <span style="font-size:14px; font-weight:700; color:#0f172a;">402 (V.I.P)</span>
                        </div>
                    </td>
                    <td style="padding:14px 16px; font-size:13px; color:#64748b; font-weight:500;">#BK-5521</td>
                    <td style="padding:14px 16px;">
                        <div style="display:flex; align-items:center; gap:7px;">
                            <span>🇬🇧</span>
                            <span style="font-size:13.5px; font-weight:700; color:#0f172a;">Michael Smith</span>
                        </div>
                    </td>
                    <td style="padding:14px 16px; font-size:13px; color:#64748b;">Còn 2 ngày</td>
                    <td style="padding:14px 16px;"><span style="padding:3px 10px; background:#fff7ed; color:#ea580c; border-radius:99px; font-size:11px; font-weight:700;">Đang dùng d.vụ</span></td>
                    <td style="padding:14px 28px; text-align:right;">
                        <button style="padding:5px 14px; background:#eff6ff; color:#2a3f8a; border:none; border-radius:8px; font-size:12px; font-weight:700; cursor:pointer;">Chi Tiết</button>
                    </td>
                </tr>
            `
        }
    };

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.classList.contains('active')) return;

            const tab = this.getAttribute('data-tab');

            // Reset CSS cho tất cả nút
            tabBtns.forEach(b => {
                b.classList.remove('active');
                b.style.background = inactiveBg;
                b.style.color = inactiveColor;
                b.style.fontWeight = '600';
                
                const text = b.querySelector('span').innerText;
                b.innerHTML = '<span>' + text + '</span>';
            });

            // Set CSS cho nút được bấm
            this.classList.add('active');
            this.style.background = activeBg;
            this.style.color = activeColor;
            this.style.fontWeight = '700';

            const text = this.querySelector('span').innerText;
            this.innerHTML = activeIcon + ' <span>' + text + '</span>';

            // Đổi Nội dung & Title
            const data = mockData[tab];
            tabTitle.innerText = data.title;
            tabDesc.innerText = data.desc;

            // Hiệu ứng mờ khi Load
            tableBody.style.opacity = '0';
            setTimeout(() => {
                tableBody.innerHTML = data.html;
                tableBody.style.opacity = '1';
            }, 100);
        });
    });
});
