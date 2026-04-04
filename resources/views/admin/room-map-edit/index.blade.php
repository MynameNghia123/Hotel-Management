@extends('admin.layouts.master')
@section('title', 'Chỉnh sửa Sơ đồ Phòng | Urban Luxe')

@section('content')
<div style="display:flex; height:100vh; background:#f8f9fb; overflow:hidden;">

    @include('admin.layouts.sidebar')

    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

        {{-- HEADER --}}
        <header style="height:64px; background:#fff; border-bottom:1px solid #f1f3f7; padding:0 32px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:8px; font-size:14px; font-weight:600; color:#1e293b;">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                16819 · Urban Luxe Hotel
            </div>
            <div style="display:flex; align-items:center; gap:10px;">
                <img src="https://ui-avatars.com/api/?name=Admin+Duc&background=2a3f8a&color=fff" style="width:36px; height:36px; border-radius:50%;">
                <div>
                    <div style="font-size:13px; font-weight:700; color:#1e293b;">Admin Đức</div>
                    <div style="font-size:11px; color:#94a3b8;">Quản lý cấp cao</div>
                </div>
            </div>
        </header>

        {{-- BODY --}}
        <div class="rme-body">
            <div class="rme-container">

                {{-- CỘT TRÁI: DANH SÁCH LOẠI PHÒNG --}}
                <aside class="rme-sidebar">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; padding:0 8px;">
                        <div class="rme-sidebar-label" style="margin-bottom:0;">Loại phòng</div>
                        <a href="{{ route('admin.room-map-edit.create-type') }}" class="rme-add-type-btn" title="Thêm loại phòng mới" style="text-decoration:none;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        </a>
                    </div>

                    <div class="rme-type-list">
                        <div class="rme-type-item">
                            <div>
                                <div class="rme-ti-name">TẦNG A</div>
                                <div class="rme-ti-sub">3 loại · 8 phòng</div>
                            </div>
                            <span class="rme-ti-count">28</span>
                        </div>

                        <div class="rme-type-item is-active">
                            <div>
                                <div class="rme-ti-name">SUITE</div>
                                <div class="rme-ti-sub">Hạng sang · Tầng cao</div>
                            </div>
                            <span class="rme-ti-count is-active">6</span>
                        </div>

                        <div class="rme-type-item">
                            <div>
                                <div class="rme-ti-name">DELUXE</div>
                                <div class="rme-ti-sub">2 tầng · 18 phòng</div>
                            </div>
                            <span class="rme-ti-count">18</span>
                        </div>

                        <div class="rme-type-item">
                            <div>
                                <div class="rme-ti-name">STANDARD</div>
                                <div class="rme-ti-sub">3 tầng · 36 phòng</div>
                            </div>
                            <span class="rme-ti-count">36</span>
                        </div>
                    </div>
                </aside>

                {{-- CỘT PHẢI: NỘI DUNG CHỈNH SỬA --}}
                <section class="rme-main">

                    {{-- Tiêu đề + Nút xóa --}}
                    <div class="rme-main-header">
                        <div style="display:flex; align-items:center; gap:14px;">
                            <h1 class="rme-main-title">SUITE</h1>
                            <span class="rme-main-subtitle">
                                Urban Suite King
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </span>
                        </div>
                        <button class="rme-btn-danger">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                            Xóa phòng
                        </button>
                    </div>

                    {{-- Danh sách tầng --}}
                    <div class="rme-floor-list">

                        {{-- Tầng 1 --}}
                        <div class="rme-floor-row">
                            <div class="rme-floor-drag">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="5" r="1" fill="currentColor"/><circle cx="9" cy="12" r="1" fill="currentColor"/><circle cx="9" cy="19" r="1" fill="currentColor"/><circle cx="15" cy="5" r="1" fill="currentColor"/><circle cx="15" cy="12" r="1" fill="currentColor"/><circle cx="15" cy="19" r="1" fill="currentColor"/></svg>
                            </div>
                            <div class="rme-floor-label">Tầng 1</div>
                            <div class="rme-room-list">
                                <span class="rme-room-tag">501</span>
                                <span class="rme-room-tag is-dim">n</span>
                                <a href="{{ route('admin.room-map-edit.create-room') }}" class="rme-room-add-btn">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                </a>
                            </div>
                        </div>

                        {{-- Tầng 2 --}}
                        <div class="rme-floor-row">
                            <div class="rme-floor-drag">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="5" r="1" fill="currentColor"/><circle cx="9" cy="12" r="1" fill="currentColor"/><circle cx="9" cy="19" r="1" fill="currentColor"/><circle cx="15" cy="5" r="1" fill="currentColor"/><circle cx="15" cy="12" r="1" fill="currentColor"/><circle cx="15" cy="19" r="1" fill="currentColor"/></svg>
                            </div>
                            <div class="rme-floor-label">Tầng 2</div>
                            <div class="rme-room-list">
                                <span class="rme-room-tag">503</span>
                                <span class="rme-room-tag">205</span>
                                <span class="rme-room-tag is-orange">202</span>
                                <a href="{{ route('admin.room-map-edit.create-room') }}" class="rme-room-add-btn">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                </a>
                            </div>
                        </div>

                    </div>

                    {{-- Thêm tầng mới --}}
                    <a href="{{ route('admin.room-map-edit.create-floor') }}" class="rme-add-floor-btn" style="text-decoration:none;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Thêm tầng mới
                    </a>

                </section>

            </div>
        </div>
    </main>

</div>
@include('admin.layouts.footer') 

@vite(['resources/css/admin/room-map-edit.css'])
@endsection