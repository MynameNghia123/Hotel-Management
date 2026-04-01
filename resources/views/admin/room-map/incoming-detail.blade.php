@extends('admin.layouts.master')
@section('title', 'Chi tiết khách sắp nhận | Urban Luxe')

@section('content')
<div style="display:flex; height:100vh; background:#f5f6fa; overflow:hidden;">

    {{-- SIDEBAR --}}
    @include('admin.layouts.sidebar')

    {{-- MAIN CONTENT --}}
    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

        {{-- HEADER (Dùng chung như các trang khác) --}}
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

        {{-- INCOMING DETAIL WRAPPER --}}
        <div class="inc-wrapper">

            {{-- Nút Quay Lại --}}
            <a href="{{ route('admin.room-map.index') }}" class="inc-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Quay lại sơ đồ
            </a>

            {{-- KHUNG THÔNG TIN CHÍNH --}}
            <div class="inc-panel">
                
                {{-- Panel Header --}}
                <div class="inc-panel-header">
                    <h1 class="inc-title">Chi tiết phòng 402 - Deluxe King</h1>
                    <div class="inc-subtitle">MÃ PHÒNG: RM-402-DXK</div>
                </div>

                <div class="inc-grid">
                    
                    {{-- Cột Trái (Thông tin khách đặt) --}}
                    <div class="inc-col inc-col-left">
                        <div class="inc-col-title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            THÔNG TIN KHÁCH ĐẶT
                        </div>

                        <div class="inc-data-group">
                            <div class="inc-data-label">HỌ VÀ TÊN</div>
                            <div class="inc-data-val">Lê Minh Ngọc</div>
                        </div>

                        <div class="inc-data-group">
                            <div class="inc-data-label">SỐ ĐIỆN THOẠI</div>
                            <div class="inc-data-val">0987 654 321</div>
                        </div>

                        <div class="inc-data-group">
                            <div class="inc-data-label">NGÀY NHẬN PHÒNG DỰ KIẾN</div>
                            <div class="inc-data-val">25/05/2024 - 14:00</div>
                        </div>

                        <div class="inc-data-group" style="margin-bottom:0;">
                            <div class="inc-data-label">MÃ ĐẶT CHỖ</div>
                            <div class="inc-code-box" onclick="navigator.clipboard.writeText('ULX-BK-9982'); alert('Đã copy mã!');">
                                ULX-BK-9982
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Cột Phải (Các phòng khác của khách) --}}
                    <div class="inc-col inc-col-right">
                        <div class="inc-col-title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16h16V8l-6-6z"/><path d="M14 2v6h6"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/></svg>
                            CÁC PHÒNG KHÁC CỦA KHÁCH ĐÃ ĐẶT
                        </div>

                        {{-- Phòng 403 --}}
                        <div class="inc-room-item">
                            <div class="inc-room-icon inc-icon-blue">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 6L12 11l-10-5 10-5 10 5z"/><path d="M2 12l10 5 10-5"/><path d="M2 17l10 5 10-5"/></svg>
                            </div>
                            <div>
                                <div class="inc-room-name">Phòng 403 - Deluxe King</div>
                                <div class="inc-room-id">RM-403-DXK</div>
                            </div>
                        </div>

                        {{-- Phòng 405 --}}
                        <div class="inc-room-item">
                            <div class="inc-room-icon inc-icon-purple">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2" ry="2"/><line x1="9" y1="4" x2="9" y2="20"/><line x1="15" y1="4" x2="15" y2="20"/></svg>
                            </div>
                            <div>
                                <div class="inc-room-name">Phòng 405 - Standard Twin</div>
                                <div class="inc-room-id">RM-405-STT</div>
                            </div>
                        </div>

                        {{-- Phòng 501 --}}
                        <div class="inc-room-item">
                            <div class="inc-room-icon inc-icon-green">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                            </div>
                            <div>
                                <div class="inc-room-name">Phòng 501 - Suite Ocean</div>
                                <div class="inc-room-id">RM-501-SUO</div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Action Footer --}}
                <div class="inc-panel-footer">
                    <a href="{{ route('admin.room-map.index') }}" class="inc-btn inc-btn-ghost" style="text-decoration:none;">Đóng</a>
                    <button class="inc-btn inc-btn-outline-red">Hủy đặt lịch</button>
                    <button class="inc-btn inc-btn-purple">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg>
                        Check-in ngay
                    </button>
                </div>

            </div>

            {{-- Copyright Text --}}
            <div class="inc-copyright">
                © 2024 Urban Luxe Management System. All rights reserved.
            </div>

        </div>
    </main>
</div>

@vite('resources/css/admin/incoming.css')

@endsection
