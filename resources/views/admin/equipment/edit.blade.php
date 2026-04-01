@extends('admin.layouts.master')

@section('title', 'Chỉnh sửa trang thiết bị | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/equipment-edit.css')
@endpush

@section('content')
<div style="display:flex; height:100vh; background:#f5f6fa;">

    {{-- SIDEBAR --}}
    @include('admin.layouts.sidebar')

    {{-- CONTENT --}}
    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

         {{-- HEADER --}}
        <header style="height:64px; background:#fff; border-bottom:1px solid #f1f3f7; padding:0 32px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0; box-shadow:0 1px 4px rgba(0,0,0,.04);">
            <div style="display:flex; align-items:center; gap:8px; font-size:14px; font-weight:600; color:#1e293b;">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                16819 &middot; Urban Luxe Hotel
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
        <div style="flex:1; overflow-y:auto; padding:32px; display:flex; flex-direction:column; background:#f8fafc;">
            
            <a href="{{ route('admin.equipment.index') }}" class="eqe-back-link">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Quay tại danh sách
            </a>

            <div style="margin-bottom: 32px;">
                <h1 class="eqe-page-title">Chỉnh sửa thiết bị</h1>
                <p style="font-size:13px; color:#94a3b8; font-weight:500;">Cung cấp thông tin chi tiết để quản lý tài sản Urban Luxe hiệu quả hơn.</p>
            </div>

            <div class="eqe-container">
                <div class="eqe-header">
                    <h2 class="eqe-title">Thông tin thiết bị</h2>
                    <p class="eqe-subtitle">Ghi đầy đủ các trường thông tin bên dưới.</p>
                </div>

                <form id="equipmentEditForm" class="eqe-form-grid">
                    <div class="eqe-form-group">
                        <label class="eqe-label">Tên thiết bị (NAME)</label>
                        <input type="text" class="eqe-input" value="Smart TV Samsung 4K 55 inch" placeholder="Nhập tên thiết bị...">
                    </div>

                    <div class="eqe-form-group">
                        <label class="eqe-label">Mã thiết bị (SKU)</label>
                        <input type="text" class="eqe-input" value="EQ-001" placeholder="Nhập mã thiết bị...">
                    </div>

                    <div class="eqe-form-group">
                        <label class="eqe-label">Loại thiết bị</label>
                        <select class="eqe-input eqe-select">
                            <option selected>Thiết bị điện tử</option>
                            <option>Nội thất phòng</option>
                            <option>Đồ dùng phòng tắm</option>
                            <option>Tiện ích khác</option>
                        </select>
                    </div>

                    <div class="eqe-form-group">
                        <label class="eqe-label">Giá nhập (IMPORT PRICE)</label>
                        <div class="eqe-input-wrapper">
                            <input type="text" class="eqe-input" value="12500000" placeholder="VD: 12500000" style="padding-right: 50px;">
                            <span class="eqe-currency-addon">VNĐ</span>
                        </div>
                    </div>

                    <div class="eqe-actions full-width">
                        <button type="button" class="eqe-btn-cancel" onclick="history.back()">Hủy bỏ</button>
                        <button type="submit" class="eqe-btn-submit">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Cập nhật thiết bị
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- FOOTER --}}
        @include('admin.layouts.footer')

    </main>
</div>
@endsection
