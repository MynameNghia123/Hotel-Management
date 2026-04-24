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
        @include('admin.layouts.header')

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

                    </div>
                </div>

                {{-- RIGHT DETAIL --}}
                <div class="config-detail">
                    <div class="config-detail-header">
                        <div class="config-detail-title">
                            @if(request('type', 'general') == 'general')
                                <h3>Chi tiết cấu hình</h3>
                                <p>Cấu hình vận hành chung cho hệ thống khách sạn.</p>
                            @elseif(request('type') == 'surcharges')
                                <h3>Chi tiết cấu hình</h3>
                                <p>Quản lý các loại phụ phí nhận và trả phòng.</p>
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