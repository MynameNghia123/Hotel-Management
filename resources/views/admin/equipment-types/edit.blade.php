@extends('admin.layouts.master')

@section('title', 'Sửa phân loại thiết bị | Urban Luxe Admin')

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
                <h2 class="am-card-title">Sửa phân loại thiết bị</h2>
                <form action="{{ route('admin.equipment-types.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="am-form-group">
                        <label class="am-form-label">Tên phân loại <span style="color:#ef4444">*</span></label>
                        <input type="text" name="name" class="am-form-input" value="{{ old('name', $category->name) }}" placeholder="Vd: Thiết bị phòng, Thiết bị nhà bếp...">
                        @error('name') <span class="am-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="am-actions">
                        <a href="{{ route('admin.equipment-types.index') }}" class="am-btn-back">Hủy bỏ</a>
                        <button type="submit" class="am-btn-submit">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
        @include('admin.layouts.footer')
    </main>
</div>
@endsection
