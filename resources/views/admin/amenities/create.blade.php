@extends('admin.layouts.master')

@section('title', 'Thêm tiện ích | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/amenities-create.css')
    @vite('resources/css/admin/amenities-icon-picker.css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
@endpush

@push('scripts')
    @vite('resources/js/admin/amenities-icon-picker.js')
@endpush

@section('content')
<div class="am-layout">
    @include('admin.layouts.sidebar')
    
    <main class="am-main">
        @include('admin.layouts.header')
        
        <div class="am-content-area">
            <div class="am-card">
                <h2 class="am-card-title">Thêm tiện ích mới</h2>
                
                <form action="{{ route('admin.amenities.store') }}" method="POST">
                    @csrf
                    <div class="am-form-group">
                        <label class="am-form-label">Tên tiện ích <span style="color:#ef4444">*</span></label>
                        <input type="text" name="name" class="am-form-input" value="{{ old('name') }}" placeholder="Vd: Wifi miễn phí, Tivi màn hình phẳng...">
                        @error('name') <span class="am-error">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="am-form-group">
                        <label class="am-form-label">Tên Icon (Tùy chọn)</label>
                        <div class="icon-input-wrapper">
                            <input type="text" id="iconInput" name="icon" class="am-form-input with-icon" value="{{ old('icon') }}" placeholder="Vd: wifi, bath, kitchen..." autocomplete="off">
                            <span class="icon-preview" id="iconPreview"></span>
                            <div class="icon-suggestions" id="iconSuggestions"></div>
                        </div>
                        <small style="color: #64748b; font-size: 12px; margin-top: 4px; display: inline-block;">Gõ để tìm icon từ Google Material Symbols</small>
                        @error('icon') <span class="am-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="am-actions">
                        <a href="{{ route('admin.amenities.index') }}" class="am-btn-back">Hủy bỏ</a>
                        <button type="submit" class="am-btn-submit">Lưu tiện ích</button>
                    </div>
                </form>
            </div>
        </div>
        
        @include('admin.layouts.footer')
    </main>
</div>
@endsection
