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

        {{-- HEADER --}}
        @include('admin.layouts.header')

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
                    <form method="GET" action="{{ route('admin.staffs.index') }}" style="display: flex; align-items: center; gap: 12px; flex: 1;">
                        <div class="sf-search-wrapper">
                            <div class="sf-search-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            </div>
                            <input type="text" name="filter[search]" class="sf-search-input" placeholder="Tìm theo tên hoặc mã nhân viên..." value="{{ request('filter.search') }}" onkeyup="if(event.key==='Enter') this.form.submit();">
                        </div>


                    
                    <div class=" sf-filters" style="margin-left:50%;">
                        <select class="sf-select" name="filter[role_id]">
                            <option value="">Vai trò (Tất cả)</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ request('filter.role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <button class="sf-btn-action" style="color: #94a3b8;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        </button>
                    </div>
                                        </form>
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

                <!-- Pagination Component -->
                <x-pagination :paginator="$staffs" />
            </div>

        {{-- FOOTER --}}
        @include('admin.layouts.footer')

    </main>
</div>
@endsection