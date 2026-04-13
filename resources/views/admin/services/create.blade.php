@extends('admin.layouts.master')

@section('title', 'Thêm Dịch Vụ Mới | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/service-types-create.css')
@endpush

@section('content')
<div class="st-layout">
    @include('admin.layouts.sidebar')
    
    <main class="st-main">
        @include('admin.layouts.header')
        
        <div class="st-content-area">
            <div class="st-card">
                <h2 class="st-card-title">Thêm Dịch Vụ Mới</h2>
                
                <form action="{{ route('admin.services.store') }}" method="POST">
                    @csrf
                    
                    <div class="st-form-group">
                        <label class="st-form-label">Tên dịch vụ <span style="color:#ef4444">*</span></label>
                        <input type="text" name="name" class="st-form-input" value="{{ old('name') }}" placeholder="Vd: Buffet Sáng Cao Cấp, Giặt khô...">
                        @error('name') <span class="st-error">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="st-form-group">
                        <label class="st-form-label">Thuộc nhóm dịch vụ <span style="color:#ef4444">*</span></label>
                        <select name="group_id" class="st-form-input">
                            <option value="">-- Chọn nhóm dịch vụ --</option>
                            @foreach($serviceGroups as $group)
                                <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>{{ $group->service_name }}</option>
                            @endforeach
                        </select>
                        @error('group_id') <span class="st-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="st-form-group">
                        <label class="st-form-label">Đơn giá (VNĐ) <span style="color:#ef4444">*</span></label>
                        <input type="number" name="unit_price" class="st-form-input" value="{{ old('unit_price') }}" placeholder="Vd: 450000">
                        @error('unit_price') <span class="st-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="st-form-group">
                        <label class="st-form-label">Đơn vị tính <span style="color:#ef4444">*</span></label>
                        <input type="text" name="unit" class="st-form-input" value="{{ old('unit') }}" placeholder="Vd: Người, Lượt, Bộ, Set...">
                        @error('unit') <span class="st-error">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="st-actions">
                        <a href="{{ route('admin.services.index') }}" class="st-btn-back">Hủy bỏ</a>
                        <button type="submit" class="st-btn-submit">Lưu dịch vụ</button>
                    </div>
                </form>
            </div>
        </div>
        
        @include('admin.layouts.footer')
    </main>
</div>
@endsection
