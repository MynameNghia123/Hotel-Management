@extends('admin.layouts.master')

@section('title', 'Chỉnh sửa Nhóm Dịch Vụ | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/service-types-edit.css')
@endpush

@section('content')
<div class="st-layout">
    @include('admin.layouts.sidebar')
    
    <main class="st-main">
        @include('admin.layouts.header')
        
        <div class="st-content-area">
            <div class="st-card">
                <h2 class="st-card-title">Chỉnh sửa Nhóm Dịch Vụ</h2>
                
                {{-- Form Tĩnh - Bạn tự nối logic Backend vào action nhé --}}
                <form action="{{ route('admin.service-types.update', $serviceGroup->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="st-form-group">
                        <label class="st-form-label">Tên nhóm dịch vụ <span style="color:#ef4444">*</span></label>
                        <input type="text" name="service_name" class="st-form-input" value="{{ old('service_name', $serviceGroup->service_name) }}" placeholder="Vd: Dịch vụ ăn uống, Spa & Wellness...">
                        @error('service_name') <span class="st-error">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="st-actions">
                        <a href="{{ route('admin.service-types.index') }}" class="st-btn-back">Hủy bỏ</a>
                        <button type="submit" class="st-btn-submit">Cập nhật thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
        
        @include('admin.layouts.footer')
    </main>
</div>
@endsection
