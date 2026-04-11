@extends('admin.layouts.master')

@section('title', 'Quản lý nhân viên | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/roles.css')
    @vite('resources/css/admin/staffs-index.css')
@endpush

@push('scripts')
    @vite('resources/js/admin/staffs-index.js')
@endpush

@section('content')
<div style="display:flex; height:100vh; background:#f5f6fa;">

    {{-- SIDEBAR --}}
    @include('admin.layouts.sidebar')

    {{-- CONTENT --}}
    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

        {{-- HEADER (Dùng chung bộ khung thống nhất) --}}
        <header style="height:64px; background:#fff; border-bottom:1px solid #f1f3f7; padding:0 32px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0; box-shadow:0 1px 4px rgba(0,0,0,.04);">
            <div style="display:flex; align-items:center; gap:8px; font-size:14px; font-weight:600; color:#1e293b; cursor:pointer;">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                16819 &middot; Urban Luxe Hotel
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div style="display:flex; align-items:center; gap:18px;">
                <div style="text-align: right;">
                    <span style="font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase;">Ngày làm việc</span>
                    <div style="font-size:13px; font-weight:700; color:#1e293b;">24 Tháng 05, 2024</div>
                </div>
                <button style="position:relative; width:36px; height:36px; border:none; background:#f1f5f9; cursor:pointer; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#64748b;">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
                    <span style="position:absolute; top:8px; right:8px; width:6px; height:6px; background:#ef4444; border-radius:50%;"></span>
                </button>
                <div style="width:36px; height:36px; border-radius:10px; background:#dcfce7; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=dcfce7&color=16a34a&size=80" style="width:100%; height:100%; object-fit:cover;" alt="Admin User">
                </div>
            </div>
        </header>

        {{-- MAIN CONTENT --}}
        <div style="flex:1; overflow-y:auto; padding:32px; display:flex; flex-direction:column; background:#f8fafc;">
            
            <div class="sf-container">
                <div class="sf-header">
                    <div>
                        <h1 class="sf-title">Quản lý nhân viên</h1>
                        <p class="sf-subtitle">Hệ thống quản trị khách sạn Urban Luxe - Quản lý hồ sơ và tài khoản nhân sự.</p>
                    </div>
                    <a href={{ route('admin.staffs.create') }} class="sf-btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="16" y1="11" x2="22" y2="11"></line></svg>
                        Thêm nhân viên mới
                    </a>
                </div>

                <div class="sf-toolbar">
                    <div class="sf-search-wrapper">
                        <div class="sf-search-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </div>
                        <input type="text" class="sf-search-input" placeholder="Tìm theo tên hoặc mã nhân viên...">
                    </div>
                    
                    <div class="sf-filters">
                        <select class="sf-select">
                            <option>Vai trò (Tất cả)</option>
                            <option>Lễ tân</option>
                            <option>Kỹ thuật</option>
                            <option>Quản lý</option>
                        </select>
                        <button class="sf-btn-action" style="color: #94a3b8;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        </button>
                    </div>
                </div>

                <div class="sf-table-wrapper">
                    <table class="sf-table">
                        <thead>
                            <tr>
                                <th>MÃ NV</th>
                                <th>HỌ VÀ TÊN</th>
                                <th>VAI TRÒ</th>
                                <th>LIÊN HỆ</th>
                                <th>TRẠNG THÁI</th>
                                <th style="text-align: right;">HÀNH ĐỘNG</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($staffs as $staff)
                            <tr>
                                <td class="sf-id">{{ $staff->id }}</td>
                                <td>
                                    <div class="sf-user-block">
                                        <div class="sf-user-info">
                                            <span class="sf-user-name">{{ $staff->first_name }} {{ $staff->last_name }}</span>
                                            <span class="sf-user-email">{{ $staff->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="sf-role-pill" >
                                        {{ $staff->role->name }}
                                    </span>
                                </td>
                                <td>{{ $staff->phone_number }}</td>
                                <td>
                                    @if($staff->is_active)
                                    <div class="sf-status-flex sf-dot-green">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                                        Đang hoạt động
                                    </div>
                                    @else
                                    <div class="sf-status-flex sf-dot-red">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                                        Ngừng hoạt động
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="sf-actions">
                                        <label class="sf-switch">
                                            <input type="checkbox" data-staff-id="{{ $staff->id }}" {{ $staff->is_active ? 'checked' : '' }}>
                                            <span class="sf-slider"></span>
                                        </label>

                                        <a class="sf-btn-action edit" title="Sửa" href="{{ route('admin.staffs.edit', $staff->id) }}">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </a>
                                        <button class="sf-btn-action delete" title="Xóa" onclick="if(confirm('Bạn có chắc muốn xóa nhân viên này?')) { document.getElementById('deleteForm-{{ $staff->id }}').submit(); }">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        </button>
                                        <form id="deleteForm-{{ $staff->id }}" action="{{ route('admin.staffs.destroy', $staff->id) }}" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="sf-footer">
                    <div class="sf-info">Hiển thị 5 trên 32 nhân viên</div>
                    <div class="sf-pagination">
                        <button class="sf-page-btn disabled">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        <button class="sf-page-btn active">1</button>
                        <button class="sf-page-btn">2</button>
                        <button class="sf-page-btn">
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