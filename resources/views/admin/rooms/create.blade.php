@extends('admin.layouts.master')

@section('title', 'Thêm loại phòng mới | Urban Luxe Admin')

@section('content')
<div class="admin-layout">
    @include('admin.layouts.sidebar')

    <main class="admin-main">
        <header class="admin-header">
            <div class="admin-header-left">
                <a href="{{ route('admin.rooms.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    Quay lại danh sách
                </a>
            </div>
        </header>

        <div class="admin-content" style="padding: 2rem;">
            <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                <h2 style="margin-bottom: 2rem;">Thêm loại phòng mới</h2>

                <form action="{{ route('admin.rooms.store') }}" method="POST">
                    @csrf
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        {{-- Tên & Mã --}}
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Tên loại phòng</label>
                            <input type="text" name="name" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Mã loại phòng (Code)</label>
                            <input type="text" name="code" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;" placeholder="Ví dụ: SUITE_KING">
                        </div>

                        {{-- Giá cả --}}
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Giá theo giờ (VNĐ)</label>
                            <input type="number" name="hourly_price" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Giá theo ngày (VNĐ)</label>
                            <input type="number" name="daily_price" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                        </div>

                        {{-- Sức chứa --}}
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Số người lớn</label>
                            <input type="number" name="adult_quantity" value="2" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Số trẻ em</label>
                            <input type="number" name="child_quantity" value="1" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                        </div>

                        {{-- Giường --}}
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Số giường đơn</label>
                            <input type="number" name="single_bed_quantity" value="0" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Số giường đôi</label>
                            <input type="number" name="double_bed_quantity" value="1" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                        </div>

                        {{-- Kích thước --}}
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Chiều rộng (m)</label>
                            <input type="number" step="0.1" name="width" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Chiều dài (m)</label>
                            <input type="number" step="0.1" name="height" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Mô tả</label>
                        <textarea name="description" rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;"></textarea>
                    </div>

                    <div style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: flex-end;">
                        <button type="reset" style="padding: 0.75rem 2rem; border: 1px solid #ddd; border-radius: 8px; background: white; cursor: pointer;">Hủy</button>
                        <button type="submit" style="padding: 0.75rem 2rem; border: none; border-radius: 8px; background: #2a3f8a; color: white; cursor: pointer; font-weight: 600;">Lưu loại phòng</button>
                    </div>
                </form>
            </div>
        </div>

        @include('admin.layouts.footer')
    </main>
</div>
@endsection