@extends('admin.layouts.master')

@section('title', 'Thêm nhân viên mới | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/staffs-create.css')
@endpush

@push('scripts')
    @vite('resources/js/admin/staffs-create.js')
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
            


            <div class="staff-form-container">
                {{-- Header --}}
                <div class="page-header">
                    <a href="{{ route('admin.staffs.index') }}" class="breadcrumb">&larr; Quay lại danh sách</a>
                    <h1 class="page-title">Thêm nhân viên mới</h1>
                    <p class="page-subtitle">Điền thông tin bên dưới để tạo tài khoản nhân viên mới vào hệ thống</p>
                </div>

                {{-- Error Summary --}}
                @if ($errors->any())
                    <div class="alert alert-error">
                        <strong>Lỗi:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('admin.staffs.store') }}">
                    @csrf

                    {{-- Section: Thông tin cơ bản --}}
                    <div class="form-section-title">NHẬP THÔNG TIN CƠ BẢN</div>

                    {{-- Họ & Tên --}}
                    <div class="staff-form-row">
                        <div class="staff-form-group @error('first_name') has-error @enderror">
                            <label for="first_name">
                                HỌ <span class="required">*</span>
                            </label>
                            <input 
                                id="first_name" 
                                name="first_name" 
                                type="text" 
                                placeholder="Nguyễn" 
                                value="{{ old('first_name') }}"
                                required
                            >
                            @error('first_name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="staff-form-group @error('last_name') has-error @enderror">
                            <label for="last_name">
                                TÊN <span class="required">*</span>
                            </label>
                            <input 
                                id="last_name" 
                                name="last_name" 
                                type="text" 
                                placeholder="Văn A" 
                                value="{{ old('last_name') }}"
                                required
                            >
                            @error('last_name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Vai trò & Email --}}
                    <div class="staff-form-row">
                        <div class="staff-form-group @error('role_id') has-error @enderror">
                            <label for="role_id">
                                VĀI TRÒ <span class="required">*</span>
                            </label>
                            <select 
                                id="role_id" 
                                name="role_id" 
                                required
                            >
                                <option value="">Chọn vai trò</option>
                                @foreach($roles ?? [] as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="staff-form-group @error('email') has-error @enderror">
                            <label for="email">
                                EMAIL <span class="required">*</span>
                            </label>
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                placeholder="example@urbanluxe.com" 
                                value="{{ old('email') }}"
                                required
                            >
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Số điện thoại --}}
                    <div class="staff-form-group @error('phone_number') has-error @enderror">
                        <label for="phone_number">
                            SỐ ĐIỆN THOẠI <span class="required">*</span>
                        </label>
                        <input 
                            id="phone_number" 
                            name="phone_number" 
                            type="tel" 
                            placeholder="090 123 4567" 
                            value="{{ old('phone_number') }}"
                            required
                        >
                        @error('phone_number')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Section: Bảo mật --}}
                    <div class="form-section-title">BẢNG MẬT KHẨU</div>

                    {{-- Mật khẩu & Xác nhận --}}
                    <div class="staff-form-row">
                        <div class="staff-form-group @error('password') has-error @enderror">
                            <label for="password">
                                MẬT KHẨU <span class="required">*</span>
                            </label>
                            <div class="input-with-toggle">
                                <input 
                                    id="password" 
                                    name="password" 
                                    type="password" 
                                    placeholder="••••••••" 
                                    required
                                >
                                <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </button>
                            </div>
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="staff-form-group">
                            <label for="password_confirmation">
                                XÁC NHẬN MẬT KHẨU <span class="required">*</span>
                            </label>
                            <div class="input-with-toggle">
                                <input 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    type="password" 
                                    placeholder="••••••••" 
                                    required
                                >
                                <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Trạng thái --}}
                    

                    {{-- Form Actions --}}
                    <div class="form-actions">
                        <button type="button" onclick="history.back()" class="btn-cancel">
                            Hủy
                        </button>
                        <button type="submit" class="btn-submit">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 00-3-3.87"></path><path d="M16 3.13a4 4 0 010 7.75"></path></svg>
                            Tạo nhân viên
                        </button>
                    </div>
                </form>
            </div>

            {{-- FOOTER --}}
            {{-- @include('admin.layouts.footer') --}}
        </div>
    </main>
</div>

@endsection
