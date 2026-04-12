@extends('admin.layouts.master')

@section('title', 'Thêm phân loại thiết bị | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/amenities-create.css')
@endpush

@section('content')
<div class="am-layout">
    @include('admin.layouts.sidebar')
    <main class="am-main">
        @include('admin.layouts.header')
        <div class="am-content-area">
            <div class="am-card">
                <h2 class="am-card-title">Thêm phân loại thiết bị mới</h2>
                <form action="{{ route('admin.equipment-types.store') }}" method="POST">
                    @csrf
                    <div class="am-form-group">
                        <label class="am-form-label">Tên phân loại <span style="color:#ef4444">*</span></label>
                        <input type="text" name="name" class="am-form-input" value="{{ old('name') }}" placeholder="Vd: Thiết bị phòng, Thiết bị nhà bếp...">
                        @error('name') <span class="am-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="am-actions">
                        <a href="{{ route('admin.equipment-types.index') }}" class="am-btn-back">Hủy bỏ</a>
                        <button type="submit" class="am-btn-submit">Lưu phân loại</button>
                    </div>
                </form>
            </div>
        </div>
        @include('admin.layouts.footer')
    </main>
</div>
@endsection
