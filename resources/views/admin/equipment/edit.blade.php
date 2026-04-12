@extends('admin.layouts.master')

@section('title', 'Sửa thiết bị | Urban Luxe Admin')

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
                <h2 class="am-card-title">Sửa thiết bị</h2>
                <form action="{{ route('admin.equipment.update', $equipment->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="am-form-group">
                        <label class="am-form-label">Tên thiết bị <span style="color:#ef4444">*</span></label>
                        <input type="text" name="name" class="am-form-input" value="{{ old('name', $equipment->name) }}" placeholder="Vd: Điều hoà Daikin, Tivi Samsung...">
                        @error('name') <span class="am-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="am-form-group" style="margin-top:16px;">
                        <label class="am-form-label">Phân loại <span style="color:#ef4444">*</span></label>
                        <select name="equipment_category_id" class="am-form-input" style="cursor:pointer;">
                            <option value="">-- Chọn phân loại --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('equipment_category_id', $equipment->equipment_category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('equipment_category_id') <span class="am-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="am-form-group" style="margin-top:16px;">
                        <label class="am-form-label">Giá nhập (VNĐ) <span style="color:#ef4444">*</span></label>
                        <input type="number" name="import_price" class="am-form-input" value="{{ old('import_price', $equipment->import_price) }}" placeholder="Vd: 5000000" min="0">
                        @error('import_price') <span class="am-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="am-actions">
                        <a href="{{ route('admin.equipment.index') }}" class="am-btn-back">Hủy bỏ</a>
                        <button type="submit" class="am-btn-submit">Cập nhật thiết bị</button>
                    </div>
                </form>
            </div>
        </div>
        @include('admin.layouts.footer')
    </main>
</div>
@endsection
