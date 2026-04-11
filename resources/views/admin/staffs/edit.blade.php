@extends('admin.layouts.master')

@section('title', 'Sửa thông tin nhân viên | Urban Luxe Admin')

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
            
            {{-- Flash Messages --}}
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    ✓ {{ $message }}
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-error">
                    ✗ {{ $message }}
                </div>
            @endif

            <div class="staff-form-container">
                {{-- Header --}}
                <div class="page-header">
                    <a href="{{ route('admin.staffs.index') }}" class="breadcrumb">&larr; Quay lại danh sách</a>
                    <h1 class="page-title">Sửa thông tin nhân viên</h1>
                    <p class="page-subtitle">Cập nhật thông tin nhân viên {{ $staff->first_name }} {{ $staff->last_name }}</p>
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
                <form method="POST" action="{{ route('admin.staffs.update', $staff->id) }}">
                    @csrf
                    @method('PUT')

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
                                value="{{ old('first_name', $staff->first_name) }}"
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
                                value="{{ old('last_name', $staff->last_name) }}"
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
                                    <option value="{{ $role->id }}" {{ old('role_id', $staff->role_id) == $role->id ? 'selected' : '' }}>
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
                                value="{{ old('email', $staff->email) }}"
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
                            value="{{ old('phone_number', $staff->phone_number) }}"
                            required
                        >
                        @error('phone_number')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Section: Bảo mật --}}
                    <div class="form-section-title">CẬP NHẬT MẬT KHẨU <span style="font-size:12px; font-weight:400; color:#94a3b8;">(Để trống nếu không muốn thay đổi)</span></div>

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
                                XÁC NHẬN MẬT KHẨU
                            </label>
                            <div class="input-with-toggle">
                                <input 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    type="password" 
                                    placeholder="••••••••" 
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
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            Cập nhật nhân viên
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
