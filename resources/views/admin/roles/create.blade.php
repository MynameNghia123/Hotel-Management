@extends('admin.layouts.master')

@section('title', 'Thêm vai trò mới | Urban Luxe Admin')

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
                <div style="margin-bottom: 24px;">
                    <a href="{{ route('admin.roles.index') }}" style="color:#64748b; font-size:14px;">&larr; Quay lại danh sách</a>
                    <h1 class="sr-title" style="margin-top:8px;">Thông tin vai trò</h1>
                    <p class="sr-subtitle">Thiết lập chi tiết quyền hạn cho vai trò người dùng trong hệ thống.</p>
                </div>
                <form method="POST" action="{{ route('admin.roles.store') }}">
                    @csrf
                    <div style="margin-bottom: 24px;">
                        <label for="role_name" style="font-weight:600;">TÊN VAI TRÒ <span style="color:#ef4444;">*</span></label>
                        <input id="role_name" name="role_name" type="text" class="sr-input" placeholder="Nhập tên vai trò" value="{{ old('role_name') }}" required style="margin-top:8px; width:320px;">
                    </div>
                    <div>
                        {{-- Bảng phân quyền --}}
                        {{-- Copy bảng từ ảnh, có thể dùng table như index.blade.php --}}
                        {{-- ... (Xây dựng bảng phân quyền ở đây, dùng HTML table, checkbox, radio, ...) --}}
                    </div>
                    <div style="margin-top:32px; display:flex; gap:12px;">
                        <a href="{{ route('admin.roles.index') }}" class="sr-btn-secondary" style="text-decoration:none; padding:10px 16px; border-radius:8px;">Hủy</a>
                        <button type="submit" class="sr-btn-primary">Lưu vai trò</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- FOOTER --}}
        @include('admin.layouts.footer')
    </main>
</div>
@endsection