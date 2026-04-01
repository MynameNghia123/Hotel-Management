@extends('admin.layouts.master')

@section('title', 'Quản lý trang thiết bị | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/equipment.css')
@endpush

@section('content')
<div style="display:flex; height:100vh; background:#f5f6fa;">

    {{-- SIDEBAR --}}
    @include('admin.layouts.sidebar')

    {{-- CONTENT --}}
    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

         {{-- HEADER --}}
        <header style="height:64px; background:#fff; border-bottom:1px solid #f1f3f7; padding:0 32px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0; box-shadow:0 1px 4px rgba(0,0,0,.04);">
            <div style="display:flex; align-items:center; gap:8px; font-size:14px; font-weight:600; color:#1e293b; cursor:pointer;">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                16819 &middot; Urban Luxe Hotel
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div style="display:flex; align-items:center; gap:18px;">
                <button style="position:relative; width:36px; height:36px; border:none; background:transparent; cursor:pointer; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#94a3b8;">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
                    <span style="position:absolute; top:6px; right:6px; width:8px; height:8px; background:#ef4444; border-radius:50%; border:2px solid #fff;"></span>
                </button>
                <div style="width:1px; height:28px; background:#f1f3f7;"></div>
                <div style="display:flex; align-items:center; gap:10px; cursor:pointer;">
                    <div style="text-align:right;">
                        <div style="font-size:13px; font-weight:700; color:#1e293b; line-height:1.2;">Admin Đức</div>
                        <div style="font-size:11px; color:#94a3b8; font-weight:500;">Quản lý cấp cao</div>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Admin+Duc&background=2a3f8a&color=fff&size=80" style="width:36px; height:36px; border-radius:50%; border:2px solid rgba(42,63,138,.2);" alt="Admin">
                </div>
            </div>
        </header>


        {{-- MAIN CONTENT --}}
        <div style="flex:1; overflow-y:auto; padding:32px; display:flex; flex-direction:column; background:#f8fafc;">
            
            <a href="#" class="eq-back-link">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Quay lại danh sách
            </a>

            <div class="eq-container">
                <div class="eq-header">
                    <div>
                        <h1 class="eq-title">Quản lý trang thiết bị</h1>
                        <p class="eq-subtitle">Hệ thống quản trị khách sạn Urban Luxe - Quản lý trang thiết bị dựa trên mô hình dữ liệu.</p>
                    </div>
                    <button class="eq-btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Thêm thiết bị mới
                    </button>
                </div>

                <div class="eq-toolbar">
                    <div class="eq-search-wrapper">
                        <div class="eq-search-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </div>
                        <input type="text" class="eq-search-input" placeholder="Tìm kiếm mã thiết bị, tên...">
                    </div>
                    
                    <div class="eq-filters">
                        <select class="eq-select">
                            <option>Loại thiết bị (Tất cả)</option>
                            <option>Thiết bị điện tử</option>
                            <option>Nội thất phòng</option>
                            <option>Đồ dùng phòng tắm</option>
                            <option>Tiện ích khác</option>
                        </select>
                    </div>
                </div>

                <div class="eq-table-wrapper">
                    <table class="eq-table">
                        <thead>
                            <tr>
                                <th>MÃ THIẾT BỊ</th>
                                <th>TÊN THIẾT BỊ</th>
                                <th>PHÂN LOẠI</th>
                                <th>GIÁ NHẬP (VNĐ)</th>
                                <th style="text-align: right;">HÀNH ĐỘNG</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $equipments = [
                                    ['code' => 'EQ-001', 'name' => 'Smart TV Samsung 4K 55 inch', 'category' => 'Thiết bị điện tử', 'price' => '12.500.000đ'],
                                    ['code' => 'EQ-002', 'name' => 'Ghế Sofa đơn phong cách Urban', 'category' => 'Nội thất phòng', 'price' => '4.200.000đ'],
                                    ['code' => 'EQ-003', 'name' => 'Máy điều hòa Panasonic Inverter', 'category' => 'Thiết bị điện tử', 'price' => '9.800.000đ'],
                                    ['code' => 'EQ-004', 'name' => 'Máy pha cà phê Nespresso Mini', 'category' => 'Tiện ích khác', 'price' => '3.500.000đ'],
                                    ['code' => 'EQ-005', 'name' => 'Bộ vòi sen cao cấp Inax', 'category' => 'Đồ dùng phòng tắm', 'price' => '1.850.000đ'],
                                ];
                            @endphp

                            @foreach($equipments as $item)
                            <tr>
                                <td>{{ $item['code'] }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td><span class="eq-category-pill">{{ $item['category'] }}</span></td>
                                <td class="eq-price">{{ $item['price'] }}</td>
                                <td>
                                    <div class="eq-actions">
                                        <button class="eq-btn-action view" title="Xem chi tiết">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        </button>
                                        <a href="{{ route('admin.equipment.edit') }}" class="eq-btn-action edit" title="Chỉnh sửa">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </a>
                                        <button class="eq-btn-action delete" title="Xóa">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="eq-footer">
                    <div class="eq-info">Hiển thị 1 đến 5 trên 48 trang thiết bị</div>
                    <div class="eq-pagination">
                        <button class="eq-page-btn disabled">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        <button class="eq-page-btn active">1</button>
                        <button class="eq-page-btn">2</button>
                        <button class="eq-page-btn">3</button>
                        <button class="eq-page-btn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    </div>
                </div>
            </div>

        {{-- FOOTER --}}
        @include('admin.layouts.footer')

    </main>
</div>
@endsection