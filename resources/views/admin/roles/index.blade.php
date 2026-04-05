@extends('admin.layouts.master')

@section('title', 'Quản lý vai trò | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/staff-roles.css')
@endpush

@section('content')
<div style="display:flex; height:100vh; background:#f5f6fa;">

    {{-- SIDEBAR --}}
    @include('admin.layouts.sidebar')

    {{-- CONTENT --}}
    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

        {{-- HEADER --}}
        @include('admin.layouts.header')

        {{-- MAIN CONTENT --}}
        <div style="flex:1; overflow-y:auto; padding:32px; display:flex; flex-direction:column; background:#f8fafc;">
            
            <div class="sr-container">
                <div class="sr-header">
                    <div>
                        <h1 class="sr-title">Quản lý vai trò</h1>
                        <p class="sr-subtitle">Hệ thống quản trị khách sạn Urban Luxe - Quản lý phân quyền và vai trò người dùng (Roles).</p>
                    </div>
                    <button class="sr-btn-primary" onclick="window.location.href='{{ route('admin.roles.create') }}'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 00-3-3.87"></path><path d="M16 3.13a4 4 0 010 7.75"></path></svg>
                        Thêm vai trò mới
                    </button>
                </div>

                <div class="sr-toolbar">
                    <div class="sr-search-wrapper">
                        <div class="sr-search-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </div>
                        <input type="text" class="sr-search-input" placeholder="Tìm tên vai trò...">
                    </div>
                    
                    <button class="sr-btn-filter">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        Lọc cơ bản
                    </button>
                </div>

                <div class="sr-table-wrapper">
                    <table class="sr-table">
                        <thead>
                            <tr>
                                <th>MÃ VAI TRÒ (ID)</th>
                                <th>TÊN VAI TRÒ (ROLE NAME)</th>
                                <th>SỐ NHÂN VIÊN (STAFF COUNT)</th>
                                <th>TRẠNG THÁI (STATUS)</th>
                                <th style="text-align: right;">THAO TÁC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $roles = [
                                    ['id' => 'ROLE-01', 'name' => 'Admin', 'count' => '02', 'color' => '#6366f1'],
                                    ['id' => 'ROLE-02', 'name' => 'Lễ tân', 'count' => '06', 'color' => '#10b981'],
                                    ['id' => 'ROLE-03', 'name' => 'Kỹ thuật', 'count' => '03', 'color' => '#f59e0b'],
                                    ['id' => 'ROLE-04', 'name' => 'Quản lý kho', 'count' => '03', 'color' => '#3b82f6'],
                                    ['id' => 'ROLE-05', 'name' => 'Buồng phòng', 'count' => '12', 'color' => '#64748b'],
                                ];
                            @endphp

                            @foreach($roles as $item)
                            <tr>
                                <td class="sr-id">{{ $item['id'] }}</td>
                                <td>
                                    <div class="sr-role-main">
                                        <div class="sr-role-dot" style="background: {{ $item['color'] }}"></div>
                                        <div class="sr-role-name">{{ $item['name'] }}</div>
                                    </div>
                                </td>
                                <td class="sr-staff-count">{{ $item['count'] }}</td>
                                <td>
                                    <span class="sr-status-badge">ĐANG KÍCH HOẠT</span>
                                </td>
                                <td>
                                    <div class="sr-actions">
                                        <button class="sr-btn-action permissions" title="Phân quyền">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                        </button>
                                        <button class="sr-btn-action edit" title="Chỉnh sửa">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </button>
                                        <button class="sr-btn-action delete" title="Xóa">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="sr-footer">
                    <div class="sr-info">Hiển thị 5 vai trò hệ thống</div>
                    <div class="sr-pagination">
                        <button class="sr-page-btn disabled">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        <button class="sr-page-btn active">1</button>
                        <button class="sr-page-btn">2</button>
                        <button class="sr-page-btn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    </div>
                </div>
            </div>

        {{-- FOOTER --}}
        @include('admin.layouts.footer')

    </main>
</div>
@endsection