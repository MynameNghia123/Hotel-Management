@extends('admin.layouts.master')

@section('title', 'Thêm khách hàng mới | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/customer-create.css')
@endpush

@section('content')
<div style="display:flex; height:100vh; background:#f5f6fa;">

    {{-- SIDEBAR --}}
    @include('admin.layouts.sidebar')

    {{-- CONTENT --}}
    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

        {{-- HEADER (Common Admin Header) --}}
        <header style="height:64px; background:#fff; border-bottom:1px solid #f1f3f7; padding:0 32px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0; box-shadow:0 1px 4px rgba(0,0,0,.04);">
            <div style="display:flex; align-items:center; gap:8px; font-size:14px; font-weight:600; color:#1e293b; cursor:pointer;">
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

        {{-- MAIN CONTENT AREA --}}
        <div style="flex:1; overflow-y:auto; padding:28px 32px; background:#f8fafc;">
            
            <div class="cc-container">
                {{-- Header Section --}}
                <div class="cc-header">
                    <a href="{{ route('admin.customers') }}" class="cc-back">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        Quay lại danh sách
                    </a>
                    <h1 class="cc-title">Thêm khách hàng mới</h1>
                    <p class="cc-subtitle">Thông tin chi tiết khách hàng Urban Luxe</p>
                </div>

                {{-- Form Card --}}
                <div class="cc-card">
                    <form action="#" method="POST">
                        @csrf
                        <div class="cc-form-grid">
                            {{-- Field: Họ --}}
                            <div class="cc-form-group">
                                <label class="cc-label">Họ</label>
                                <input type="text" class="cc-input" placeholder="Nhập họ khách hàng">
                            </div>

                            {{-- Field: Email --}}
                            <div class="cc-form-group">
                                <label class="cc-label">Email</label>
                                <input type="email" class="cc-input" placeholder="example@email.com">
                            </div>

                            {{-- Field: Tên --}}
                            <div class="cc-form-group">
                                <label class="cc-label">Tên</label>
                                <input type="text" class="cc-input" placeholder="Nhập tên khách hàng">
                            </div>

                            {{-- Field: ID Tài khoản --}}
                            <div class="cc-form-group">
                                <label class="cc-label">ID Tài khoản</label>
                                <input type="text" class="cc-input" placeholder="VD: ACC-1234">
                            </div>

                            {{-- Field: Số điện thoại --}}
                            <div class="cc-form-group">
                                <label class="cc-label">Số điện thoại</label>
                                <input type="text" class="cc-input" placeholder="VD: 0901234567">
                            </div>

                            {{-- Field: Quốc gia --}}
                            <div class="cc-form-group">
                                <label class="cc-label">Quốc gia</label>
                                <select class="cc-input cc-select">
                                    <option value="Vietnam">Việt Nam</option>
                                    <option value="USA">Hoa Kỳ</option>
                                    <option value="Japan">Nhật Bản</option>
                                    <option value="Korea">Hàn Quốc</option>
                                </select>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="cc-actions">
                            <button type="button" class="cc-btn cc-btn-cancel">Hủy</button>
                            <button type="submit" class="cc-btn cc-btn-save">Lưu thông tin</button>
                        </div>
                    </form>
                </div>

                {{-- Footer Text --}}
                <div style="text-align:center; margin-top:40px; font-size:12px; color:#94a3b8; font-weight:500;">
                    &copy; 2024 Urban Luxe Management System. All rights reserved.
                </div>
            </div>

        </div>
    </main>
</div>
@endsection
