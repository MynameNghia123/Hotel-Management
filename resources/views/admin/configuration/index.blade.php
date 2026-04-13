@extends('admin.layouts.master')

@section('title', 'Cấu hình hệ thống | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/configuration.css')
@endpush

@section('content')
<div class="admin-layout">

    {{-- SIDEBAR --}}
    @include('admin.layouts.sidebar')

    {{-- CONTENT --}}
    <main class="admin-main">

         {{-- HEADER --}}
        <header class="admin-header">
            <div class="admin-header-left">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                16819 &middot; Urban Luxe Hotel
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div class="admin-header-right">
                <button class="admin-header-notification">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
                    <span class="admin-header-notification-dot"></span>
                </button>
                <div class="admin-header-divider"></div>
                <div class="admin-header-user">
                    <div class="admin-header-user-info">
                        <div class="admin-header-user-name">Admin Đức</div>
                        <div class="admin-header-user-role">Quản lý cấp cao</div>
                    </div>
                     <img src="https://ui-avatars.com/api/?name=Admin+Duc&background=2a3f8a&color=fff&size=80" class="admin-header-user-avatar" alt="Admin">
                </div>
            </div>
        </header>

        {{-- MAIN CONTENT --}}
        <div class="admin-content">

            <div class="config-container">
                
                {{-- LEFT MENU --}}
                <div class="config-menu">
                    <div class="config-menu-header">
                        <h3>Danh sách cấu hình</h3>
                        <p>Chọn mục để chỉnh sửa cấu hình</p>
                    </div>
                    <div class="config-menu-list">
                        <a href="{{ request()->fullUrlWithQuery(['type' => 'general']) }}" class="config-menu-item {{ (request('type', 'general') == 'general') ? 'active' : '' }}">
                            <h4>Cấu hình vận hành chung</h4>
                            <p>Cài đặt giờ nhận/trả phòng, thời gian chờ, quy định hủy phòng...</p>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['type' => 'surcharges']) }}" class="config-menu-item {{ (request('type') == 'surcharges') ? 'active' : '' }}">
                            <h4>Quy định phụ phí</h4>
                            <p>Thiết lập giá chênh lệch khi khách nhận/trả phòng trễ, gửi thêm khách...</p>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['type' => 'roles']) }}" class="config-menu-item {{ (request('type') == 'roles') ? 'active' : '' }}">
                            <h4>Quản lý vai trò (Roles)</h4>
                            <p>Phân quyền truy cập và chức năng cho các cấp nhân viên...</p>
                        </a>
                    </div>
                </div>

                {{-- RIGHT DETAIL --}}
                <div class="config-detail">
                    <div class="config-detail-header">
                        <div class="config-detail-title">
                            @if(request('type', 'general') == 'general')
                                <h3>Cấu hình vận hành chung</h3>
                                <p>Thiết lập các mốc thời gian và quy tắc cốt lõi của khách sạn.</p>
                            @elseif(request('type') == 'surcharges')
                                <h3>Quy định phụ phí</h3>
                                <p>Quản lý các loại phụ phí khi nhận/trả phòng.</p>
                            @else
                                <h3>Quản lý vai trò</h3>
                                <p>Thiết lập quyền hạn cho nhân viên.</p>
                            @endif
                        </div>
                        <button class="btn-save-config">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Lưu thay đổi
                        </button>
                    </div>

                    <div class="config-detail-body">
                        
                        @if(request('type', 'general') == 'general')
                            @include('admin.configuration.general')
                        @elseif(request('type') == 'surcharges')
                            @include('admin.configuration.surcharges')
                        @else
                            <div style="text-align:center; padding:100px 0; color:#94a3b8;">
                                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:20px; opacity:0.3;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                <p>Đang phát triển chức năng phân quyền...</p>
                            </div>
                        @endif

                    </div>
                </div>

            </div>

             {{-- FOOTER --}}
            @include('admin.layouts.footer')

        </div>

    </main>
</div>
@endsection