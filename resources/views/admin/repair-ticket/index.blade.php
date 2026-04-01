@extends('admin.layouts.master')

@section('title', 'Quản lý phiếu sửa chữa | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/repair-ticket.css')
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
                <div style="text-align: right;">
                    <span style="font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase;">Ngày làm việc</span>
                    <div style="font-size:13px; font-weight:700; color:#1e293b;">24 Tháng 05, 2024</div>
                </div>
                <button style="position:relative; width:36px; height:36px; border:none; background:#f1f5f9; cursor:pointer; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#64748b;">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
                    <span style="position:absolute; top:8px; right:8px; width:6px; height:6px; background:#ef4444; border-radius:50%;"></span>
                </button>
                <div style="width:36px; height:36px; border-radius:10px; background:#dcfce7; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=dcfce7&color=16a34a&size=80" style="width:100%; height:100%; object-fit:cover;" alt="Admin User">
                </div>
            </div>
        </header>

        {{-- MAIN CONTENT --}}
        <div style="flex:1; overflow-y:auto; padding:32px; display:flex; flex-direction:column; background:#f8fafc;">
            
            <div class="rp-container">
                <div class="rp-header">
                    <div>
                        <h1 class="rp-title">Quản lý phiếu sửa chữa</h1>
                        <p class="rp-subtitle">Hệ thống quản trị khách sạn Urban Luxe - Quản lý phiếu sửa chữa thiết bị.</p>
                    </div>
                    <a href="{{ route('admin.repair-ticket.create') }}" class="rp-btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Tạo phiếu sửa chữa mới
                    </a>
                </div>

                <div class="rp-toolbar">
                    <div class="rp-search-wrapper">
                        <div class="rp-search-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </div>
                        <input type="text" class="rp-search-input" placeholder="Tìm theo số phòng/thiết bị...">
                    </div>
                    
                    <div class="rp-filters">
                        <select class="rp-select">
                            <option>Trạng thái (Tất cả)</option>
                            <option>Đang chờ xử lý</option>
                            <option>Đang sửa chữa</option>
                            <option>Đã hoàn thành</option>
                            <option>Đã hủy</option>
                        </select>
                        <button class="rp-btn-action" style="color: #94a3b8;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        </button>
                    </div>
                </div>

                <div class="rp-table-wrapper">
                    <table class="rp-table">
                        <thead>
                            <tr>
                                <th>MÃ PHIẾU</th>
                                <th>PHÒNG</th>
                                <th>TÊN THIẾT BỊ</th>
                                <th>NGÀY BÁO CÁO</th>
                                <th>CHI PHÍ DỰ KIẾN (VNĐ)</th>
                                <th>TRẠNG THÁI</th>
                                <th style="text-align: right;">THAO TÁC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $repairs = [
                                    ['id' => 'REP-2024-001', 'room' => 'P.301', 'device' => 'Điều hòa Daikin Inverter', 'date' => '24/05/2024', 'cost' => '450.000đ', 'status' => 'waiting', 'label' => 'ĐANG CHỜ XỬ LÝ'],
                                    ['id' => 'REP-2024-002', 'room' => 'P.105', 'device' => 'Smart TV Samsung 4K', 'date' => '22/05/2024', 'cost' => '1.500.000đ', 'status' => 'repairing', 'label' => 'ĐANG SỬA CHỮA'],
                                    ['id' => 'REP-2024-003', 'room' => 'P.402', 'device' => 'Vòi sen TOTO', 'date' => '20/05/2024', 'cost' => '250.000đ', 'status' => 'completed', 'label' => 'ĐÃ HOÀN THÀNH'],
                                    ['id' => 'REP-2024-004', 'room' => 'P.210', 'device' => 'Khóa thẻ từ thông minh', 'date' => '18/05/2024', 'cost' => '0đ', 'status' => 'cancelled', 'label' => 'ĐÃ HỦY'],
                                ];
                            @endphp

                            @foreach($repairs as $item)
                            <tr>
                                <td>{{ $item['id'] }}</td>
                                <td>{{ $item['room'] }}</td>
                                <td>{{ $item['device'] }}</td>
                                <td>{{ $item['date'] }}</td>
                                <td class="rp-price">{{ $item['cost'] }}</td>
                                <td>
                                    <span class="rp-status-badge rp-status-{{ $item['status'] }}">
                                        {{ $item['label'] }}
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                                    </span>
                                </td>
                                <td>
                                    <div class="rp-actions">
                                        <a href="{{ route('admin.repair-ticket.create') }}" class="rp-btn-action view" title="Xem chi tiết">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        </a>
                                        @if($item['status'] == 'waiting')
                                        <button class="rp-btn-action edit" title="Chỉnh sửa">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </button>
                                        @endif
                                        <button class="rp-btn-action delete" title="Xóa">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="rp-footer">
                    <div class="rp-info">Hiển thị 4 trên 12 phiếu sửa chữa</div>
                    <div class="rp-pagination">
                        <button class="rp-page-btn disabled">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        <button class="rp-page-btn active">1</button>
                        <button class="rp-page-btn">2</button>
                        <button class="rp-page-btn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- FOOTER --}}
        @include('admin.layouts.footer')

    </main>
</div>
@endsection
