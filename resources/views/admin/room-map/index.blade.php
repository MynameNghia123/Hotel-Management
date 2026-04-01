@extends('admin.layouts.master')
@section('title', 'Sơ đồ phòng | Urban Luxe')

@section('content')
    <div style="display:flex; height:100vh; background:#f5f6fa;">

        {{-- SIDEBAR --}}
        @include('admin.layouts.sidebar')

        {{-- MAIN CONTENT --}}
        <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

            {{-- HEADER --}}
            <header style="height:64px; background:#fff; border-bottom:1px solid #f1f3f7; padding:0 32px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
                <div style="display:flex; align-items:center; gap:8px; font-size:14px; font-weight:600; color:#1e293b;">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                    16819 · Urban Luxe Hotel
                </div>
                <div style="display:flex; align-items:center; gap:18px;">
                    <button style="position:relative; width:36px; height:36px; border:none; background:transparent; display:flex; align-items:center; justify-content:center; color:#94a3b8; cursor:pointer;">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
                        <span style="position:absolute; top:6px; right:6px; width:8px; height:8px; background:#ef4444; border-radius:50%; border:2px solid #fff;"></span>
                    </button>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <div style="text-align:right;">
                            <div style="font-size:13px; font-weight:700; color:#1e293b;">Admin Đức</div>
                            <div style="font-size:11px; color:#94a3b8;">Quản lý cấp cao</div>
                        </div>
                        <img src="https://ui-avatars.com/api/?name=Admin+Duc&background=2a3f8a&color=fff" style="width:36px; height:36px; border-radius:50%;">
                    </div>
                </div>
            </header>

            {{-- ROOM MAP WRAPPER --}}
            <div class="rm-wrapper">

                {{-- TRẠNG THÁI (FILTERS) --}}
                <div class="rm-filters">
                    <button class="rm-filter-btn green active">
                        <span class="rm-dot"></span> Trống (14)
                    </button>
                    <button class="rm-filter-btn blue">
                        <span class="rm-dot"></span> Đã đặt (0)
                    </button>
                    <button class="rm-filter-btn purple">
                        <span class="rm-dot"></span> Sắp đến (4)
                    </button>
                    <button class="rm-filter-btn red">
                        <span class="rm-dot"></span> Có khách (21)
                    </button>
                    <button class="rm-filter-btn orange">
                        <span class="rm-dot"></span> Chuẩn bị đi (2)
                    </button>
                    <button class="rm-filter-btn dark">
                        <span class="rm-dot"></span> Dơ (5)
                    </button>
                    <button class="rm-filter-btn" style="border: 1px solid #cbd5e1; color: #475569;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        Bảo trì (2)
                    </button>
                </div>

                {{-- TOOLBAR --}}
                <div class="rm-toolbar">
                    <div class="rm-toolbar-left">
                        <div class="rm-toggle-group">
                            <button class="rm-toggle-btn active">Lưới</button>
                            <button class="rm-toggle-btn">Tầng</button>
                            <button class="rm-toggle-btn">Phòng</button>
                        </div>
                        <div class="rm-date-picker">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            10 ngày - Biết ngày
                        </div>
                    </div>
                    <div class="rm-search">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" placeholder="Tìm tên/phòng...">
                    </div>
                </div>

                {{-- TẦNG / SUITE --}}
                <div class="rm-group">
                    <div class="rm-group-header">
                        <span class="rm-group-title">SUITE</span>
                        <span class="rm-group-count">6</span>
                    </div>

                    <div class="rm-grid">
                        {{-- Có Khách --}}
                        <div class="rm-card occupied">
                            <div class="rm-card-header">
                                <div><span class="rm-card-room">201</span> <span class="rm-card-type">SUI</span></div>
                                <span class="rm-card-indicator"></span>
                            </div>
                            <div class="rm-guest-name">Lê Anh Tuấn</div>
                            <div class="rm-time-row">
                                <span style="color:#dc2626; font-weight:700;">▼ 13:52</span>
                                <span>1.2tr</span>
                            </div>
                            <div class="rm-footer" style="margin-top:8px;">
                                <span class="rm-status-badge blue-text" style="background:#eff6ff;">+ P. Khách Hàng</span>
                                <span style="font-size:10px; font-weight:700; color:#0f172a;">14h</span>
                            </div>
                        </div>

                        {{-- Có Khách --}}
                        <div class="rm-card occupied">
                            <div class="rm-card-header">
                                <div><span class="rm-card-room">202</span> <span class="rm-card-type">PRE</span></div>
                                <span class="rm-card-indicator"></span>
                            </div>
                            <div class="rm-guest-name">Nguyễn Thùy Chi</div>
                            <div class="rm-time-row">
                                <span>22/02 - 26/02</span>
                                <span>2.4tr</span>
                            </div>
                            <div class="rm-footer" style="margin-top:8px;">
                                <span class="rm-status-badge red-text" style="background:#fef2f2;">▲ 350.000</span>
                            </div>
                        </div>

                        {{-- Trống --}}
                        <div class="rm-card empty">
                            <div class="rm-card-header" style="margin-bottom:0;">
                                <div><span class="rm-card-room">203</span> <span class="rm-card-type">SUI</span></div>
                            </div>
                            <div class="rm-card-body">
                                <div class="check-circle">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                                <div class="status-text">TRỐNG</div>
                            </div>
                        </div>

                        {{-- Chuẩn Bị Đi (Checkout) --}}
                        <div class="rm-card checkout">
                            <div class="rm-card-header">
                                <div><span class="rm-card-room">204</span> <span class="rm-card-type">ORD</span></div>
                                <span class="rm-card-indicator"></span>
                            </div>
                            <div class="rm-guest-name">Hoàng Gia Bảo</div>
                            <div class="rm-footer">
                                <button class="rm-action-btn btn-orange" style="width:100%;">
                                    <svg style="display:inline; margin-bottom:-2px;" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                    CHỜ NHẬN
                                </button>
                            </div>
                        </div>

                        {{-- Đã đặt phòng (Booked / Blue) --}}
                        <div class="rm-card booked">
                            <div class="rm-card-header">
                                <div><span class="rm-card-room">205</span> <span class="rm-card-type">FLX</span></div>
                                <span class="rm-card-indicator"></span>
                            </div>
                            <div class="rm-guest-name" style="color:#2563eb;">#KSA5YRT HO1N</div>
                            <div class="rm-guest-name">Trần Khắc Quân</div>
                            <div class="rm-footer">
                                <span style="font-size:11px; font-weight:700; color:#2563eb; display:flex; align-items:center; gap:4px;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                    Mới - VVIP
                                </span>
                            </div>
                        </div>

                        {{-- Trống --}}
                        <div class="rm-card empty">
                            <div class="rm-card-header" style="margin-bottom:0;">
                                <div><span class="rm-card-room">206</span> <span class="rm-card-type">SUI</span></div>
                            </div>
                            <div class="rm-card-body">
                                <div class="check-circle">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                                <div class="status-text">TRỐNG</div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- DELUXE --}}
                <div class="rm-group">
                    <div class="rm-group-header">
                        <span class="rm-group-title">DELUXE</span>
                        <span class="rm-group-count">14</span>
                    </div>

                    <div class="rm-grid">

                        {{-- Dơ (Dirty) --}}
                        <div class="rm-card dirty">
                            <div class="rm-card-header">
                                <div><span class="rm-card-room">401</span> <span class="rm-card-type">DEL</span></div>
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 14l6-6-6-6"/></svg>
                            </div>
                            <div class="rm-card-body" style="flex:1; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px;">
                                <div style="font-size:11px; font-weight:800; letter-spacing:0.05em;">🧹 CHỜ DỌN</div>
                            </div>
                            <div class="rm-footer">
                                <button class="rm-action-btn btn-outline" style="width:100%;">XÁC NHẬN</button>
                            </div>
                        </div>

                        {{-- Sắp Đến (Purple) --}}
                        <div class="rm-card incoming">
                            <div class="rm-card-header">
                                <div><span class="rm-card-room">402</span> <span class="rm-card-type">DEL</span></div>
                                <span class="rm-card-indicator"></span>
                            </div>
                            <div class="rm-guest-name" style="color:#9333ea; font-size:11px; margin-bottom:0;">JAM-DLXUX-4V</div>
                            <div class="rm-guest-name">Lý Minh Quân</div>
                            <div class="rm-footer">
                                <span style="font-size:11px; font-weight:700; color:#9333ea; display:flex; align-items:center; gap:4px;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                    Đã Dọn Xong
                                </span>
                            </div>
                        </div>

                        {{-- Khách đang ở (Có Trả phòng) --}}
                        <div class="rm-card occupied">
                            <div class="rm-card-header">
                                <div><span class="rm-card-room">403</span> <span class="rm-card-type">DEL</span></div>
                                <span class="rm-card-indicator"></span>
                            </div>
                            <div class="rm-guest-name">Bly... Donit</div>
                            <div class="rm-time-row">
                                <span style="color:#dc2626; text-decoration:line-through;">Đoán Đi - 11:30</span>
                            </div>
                            <div class="rm-footer" style="margin-top:8px;">
                                <span class="rm-status-badge blue-text" style="background:#eff6ff;">+ P. Khách Hàng</span>
                                <span style="font-size:10px; font-weight:700; color:#0f172a;">12:00</span>
                            </div>
                        </div>

                        {{-- Trống --}}
                        <div class="rm-card empty">
                            <div class="rm-card-header" style="margin-bottom:0;">
                                <div><span class="rm-card-room">404</span> <span class="rm-card-type">PRE</span></div>
                            </div>
                            <div class="rm-card-body">
                                <div class="check-circle">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                                <div class="status-text">TRỐNG</div>
                            </div>
                        </div>

                        {{-- Trống --}}
                        <div class="rm-card empty">
                            <div class="rm-card-header" style="margin-bottom:0;">
                                <div><span class="rm-card-room">405</span> <span class="rm-card-type">DEL</span></div>
                            </div>
                            <div class="rm-card-body">
                                <div class="check-circle">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                                <div class="status-text">TRỐNG</div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            {{-- Nếu có footer bạn thêm vào đây --}}
            {{-- @include('admin.layouts.footer') --}}

        </main>
    </div>

    @vite('resources/css/admin/room-map.css')

@endsection