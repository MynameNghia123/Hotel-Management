@extends('admin.layouts.master')

@section('title', 'Loại thiết bị | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/amenities.css')
@endpush

@section('content')
<div style="display:flex; height:100vh; background:#f5f6fa;">
    @include('admin.layouts.sidebar')
    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">
        @include('admin.layouts.header')
        <div style="flex:1; overflow-y:auto; padding:32px; display:flex; flex-direction:column; background:#f8fafc;">

            @if(session('success'))
                <div style="background:#dcfce7; color:#15803d; padding:16px; border-radius:12px; margin-bottom:24px; border:1px solid #bbf7d0; display:flex; align-items:center; gap:12px; font-weight:600;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background:#fee2e2; color:#b91c1c; padding:16px; border-radius:12px; margin-bottom:24px; border:1px solid #fecaca; display:flex; align-items:center; gap:12px; font-weight:600;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="am-container">
                <div class="am-header">
                    <div>
                        <h1 class="am-title">Loại thiết bị</h1>
                        <p class="am-subtitle">Quản lý danh mục loại thiết bị trong khách sạn.</p>
                    </div>
                    <a href="{{ route('admin.equipment-types.create') }}" class="am-btn-primary" style="text-decoration:none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Thêm loại thiết bị mới
                    </a>
                </div>

                <div class="am-toolbar">
                    <div class="am-search-wrapper">
                        <div class="am-search-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </div>
                        <input type="text" class="am-search-input" placeholder="Tìm tên loại thiết bị...">
                    </div>
                </div>

                <div class="am-table-wrapper">
                    <table class="am-table">
                        <thead>
                            <tr>
                                <th style="width:80px;">ID</th>
                                <th>TÊN LOẠI THIẾT BỊ</th>
                                <th>SỐ THIẾT BỊ</th>
                                <th style="text-align:right;">HÀNH ĐỘNG</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td class="am-id">{{ $category->id }}</td>
                                <td class="am-name">{{ $category->name }}</td>
                                <td>
                                    <span style="background:#eff6ff; color:#1d4ed8; font-weight:600; font-size:12px; padding:4px 10px; border-radius:20px;">
                                        {{ $category->equipments_count ?? $category->equipments->count() }} thiết bị
                                    </span>
                                </td>
                                <td>
                                    <div class="am-actions">
                                        <a href="{{ route('admin.equipment-types.edit', $category->id) }}" class="am-btn-action edit" title="Chỉnh sửa" style="text-decoration:none; display:inline-flex; align-items:center; justify-content:center;">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </a>
                                        <form action="{{ route('admin.equipment-types.destroy', $category->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xoá phân loại này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="am-btn-action delete" title="Xóa">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align:center; padding:2rem; color:#64748b;">Chưa có phân loại thiết bị nào.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="am-footer">
                    <div class="am-info">Tổng: {{ $categories->count() }} loại thiết bị</div>
                </div>
            </div>

            @include('admin.layouts.footer')
        </div>
    </main>
</div>
@endsection
