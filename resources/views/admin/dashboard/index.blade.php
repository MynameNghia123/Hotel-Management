@extends('admin.layouts.master')

@section('title', 'Bảng điều khiển | Urban Luxe Admin')

@section('content')
<div style="display:flex; height:100vh; background:#f5f6fa;">

    {{-- SIDEBAR --}}
    
    @include('admin.layouts.sidebar')

    {{-- CONTENT --}}
    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

        {{-- HEADER --}}
        <header style="height:64px; background:#fff; border-bottom:1px solid #f1f3f7; padding:0 32px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0; box-shadow:0 1px 4px rgba(0,0,0,.04);">
            <div style="display:flex; align-items:center; gap:8px; font-size:14px; font-weight:600; color:#1e293b; cursor:pointer;">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                16819 · Urban Luxe Hotel
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div style="display:flex; align-items:center; gap:18px;">
                <button style="position:relative; width:36px; height:36px; border:none; background:transparent; cursor:pointer; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#94a3b8;">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
                    <span style="position:absolute; top:6px; right:6px; width:8px; height:8px; background:#ef4444; border-radius:50%; border:2px solid #fff;"></span>
                </button>
                <div style="width:1px; height:28px; background:#f1f3f7;"></div>
                <div style="display:flex; align-items:center; gap:10px; cursor:pointer;">
                    <div style="text-align:right;">
                        <div style="font-size:13px; font-weight:700; color:#1e293b; line-height:1.2;">Admin Đức</div>
                        <div style="font-size:11px; color:#94a3b8; font-weight:500;">Quản lý cấp cao</div>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Admin+Duc&background=2a3f8a&color=fff&size=80" style="width:36px; height:36px; border-radius:50%; border:2px solid rgba(42,63,138,.2);" alt="Admin">
                </div>
            </div>
        </header>

        {{-- MAIN CONTENT --}}
        <div style="flex:1; overflow-y:auto; padding:28px 32px; display:flex; flex-direction:column; gap:22px;">

            {{-- STATS CARDS --}}
            <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:18px;">
                {{-- Card 1 --}}
                <div style="background:#fff; border-radius:16px; padding:22px; border:1px solid #f1f3f7; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                    <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:14px;">
                        <div style="width:42px; height:42px; border-radius:12px; background:#eff6ff; display:flex; align-items:center; justify-content:center; color:#3b82f6;">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                        </div>
                        <span style="font-size:11px; font-weight:700; color:#10b981; background:#d1fae5; padding:2px 9px; border-radius:99px;">+12.4%</span>
                    </div>
                    <div style="font-size:12px; color:#94a3b8; font-weight:500; margin-bottom:4px;">Tỷ lệ lấp đầy</div>
                    <div style="font-size:26px; font-weight:900; color:#0f172a;">84.5%</div>
                </div>
                {{-- Card 2 --}}
                <div style="background:#fff; border-radius:16px; padding:22px; border:1px solid #f1f3f7; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                    <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:14px;">
                        <div style="width:42px; height:42px; border-radius:12px; background:#f0fdf4; display:flex; align-items:center; justify-content:center; color:#22c55e;">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                        </div>
                        <span style="font-size:11px; font-weight:700; color:#10b981; background:#d1fae5; padding:2px 9px; border-radius:99px;">+8.2%</span>
                    </div>
                    <div style="font-size:12px; color:#94a3b8; font-weight:500; margin-bottom:4px;">Doanh thu hôm nay</div>
                    <div style="font-size:22px; font-weight:900; color:#0f172a;">42.500.000đ</div>
                </div>
                {{-- Card 3 --}}
                <div style="background:#fff; border-radius:16px; padding:22px; border:1px solid #f1f3f7; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                    <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:14px;">
                        <div style="width:42px; height:42px; border-radius:12px; background:#fff7ed; display:flex; align-items:center; justify-content:center; color:#f97316;">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                        </div>
                        <span style="font-size:11px; font-weight:700; color:#f97316; background:#fff7ed; padding:2px 9px; border-radius:99px;">Hôm nay</span>
                    </div>
                    <div style="font-size:12px; color:#94a3b8; font-weight:500; margin-bottom:4px;">Phòng trống</div>
                    <div style="font-size:26px; font-weight:900; color:#0f172a;">12</div>
                </div>
                {{-- Card 4 --}}
                <div style="background:#fff; border-radius:16px; padding:22px; border:1px solid #f1f3f7; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                    <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:14px;">
                        <div style="width:42px; height:42px; border-radius:12px; background:#faf5ff; display:flex; align-items:center; justify-content:center; color:#a855f7;">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </div>
                        <span style="font-size:11px; font-weight:700; color:#a855f7; background:#faf5ff; padding:2px 9px; border-radius:99px;">Mới</span>
                    </div>
                    <div style="font-size:12px; color:#94a3b8; font-weight:500; margin-bottom:4px;">Đánh giá khách</div>
                    <div style="font-size:26px; font-weight:900; color:#0f172a;">124</div>
                </div>
            </div>

            {{-- ARRIVALS TABLE --}}
            <div style="background:#fff; border-radius:16px; border:1px solid #f1f3f7; box-shadow:0 1px 4px rgba(0,0,0,.04); overflow:hidden;">
                <div style="display:flex; align-items:center; justify-content:space-between; padding:22px 28px 18px;">
                    <div>
                        <h1 style="font-size:17px; font-weight:800; color:#0f172a; margin:0 0 4px;">Danh Sách Khách Sẽ Đến</h1>
                        <p style="font-size:13px; color:#94a3b8; margin:0;">Danh sách khách hàng dự kiến nhận phòng hôm nay</p>
                    </div>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <div style="display:flex; gap:3px; background:#f8f9fb; border:1px solid #f1f3f7; border-radius:10px; padding:3px;">
                            <button style="display:flex; align-items:center; gap:6px; padding:6px 14px; background:#2a3f8a; color:#fff; border:none; border-radius:8px; font-size:12px; font-weight:700; cursor:pointer;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                SẼ ĐẾN
                            </button>
                            <button style="padding:6px 14px; background:transparent; border:none; font-size:12px; font-weight:600; color:#64748b; cursor:pointer; border-radius:8px;">SẼ ĐI</button>
                            <button style="padding:6px 14px; background:transparent; border:none; font-size:12px; font-weight:600; color:#64748b; cursor:pointer; border-radius:8px;">ĐANG Ở</button>
                        </div>
                        <button style="display:flex; align-items:center; gap:6px; padding:8px 18px; background:#2a3f8a; color:#fff; border:none; border-radius:10px; font-size:12px; font-weight:700; cursor:pointer; box-shadow:0 3px 10px rgba(42,63,138,.25);">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Đặt phòng mới
                        </button>
                    </div>
                </div>

                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr style="background:#f8f9fb; border-top:1px solid #f1f3f7; border-bottom:1px solid #f1f3f7;">
                                <th style="padding:12px 28px; text-align:left; font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em;">Số Phòng</th>
                                <th style="padding:12px 16px; text-align:left; font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em;">Mã ĐP</th>
                                <th style="padding:12px 16px; text-align:left; font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em;">Tên Khách</th>
                                <th style="padding:12px 16px; text-align:left; font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em;">Giờ Đến</th>
                                <th style="padding:12px 16px; text-align:left; font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em;">Số Khách</th>
                                <th style="padding:12px 28px; text-align:right; font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em;">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
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
                            <tr>
                                <td style="padding:14px 28px;">
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <div style="width:34px; height:34px; border-radius:9px; background:#faf5ff; border:1px solid #e9d5ff; display:flex; align-items:center; justify-content:center; color:#a855f7;">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                                        </div>
                                        <span style="font-size:14px; font-weight:700; color:#0f172a;">105 (Suite)</span>
                                    </div>
                                </td>
                                <td style="padding:14px 16px; font-size:13px; color:#64748b; font-weight:500;">#BK-9045</td>
                                <td style="padding:14px 16px;">
                                    <div style="display:flex; align-items:center; gap:7px;">
                                        <span>🇺🇸</span>
                                        <span style="font-size:13.5px; font-weight:700; color:#0f172a;">Robert Johnson</span>
                                    </div>
                                </td>
                                <td style="padding:14px 16px; font-size:13px; color:#64748b;">16:30 · Hôm nay</td>
                                <td style="padding:14px 16px;"><span style="padding:3px 10px; background:#faf5ff; color:#a855f7; border-radius:99px; font-size:11px; font-weight:700;">1 NL / 0 TE</span></td>
                                <td style="padding:14px 28px; text-align:right;">
                                    <button style="padding:5px 14px; background:#eff6ff; color:#2a3f8a; border:none; border-radius:8px; font-size:12px; font-weight:700; cursor:pointer;">Xem</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div style="padding:14px 28px; display:flex; align-items:center; justify-content:space-between; border-top:1px solid #f8f9fb;">
                    <div style="display:flex; align-items:center; gap:8px; font-size:13px; color:#64748b;">
                        Số lượng mỗi trang
                        <select style="border:1px solid #e2e8f0; border-radius:7px; padding:3px 8px; font-size:12px; font-weight:600; color:#0f172a; background:#f8f9fb; outline:none;">
                            <option>10</option><option>20</option><option>50</option>
                        </select>
                    </div>
                    <div style="display:flex; align-items:center; gap:10px; font-size:13px; color:#64748b;">
                        1 - 2 trên 12
                        <button style="width:28px; height:28px; border:1px solid #e2e8f0; border-radius:7px; background:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                        </button>
                        <button style="width:28px; height:28px; border:1px solid #e2e8f0; border-radius:7px; background:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        {{-- FOOTER --}}
        @include('admin.layouts.footer')

    </main>
</div>
@endsection
