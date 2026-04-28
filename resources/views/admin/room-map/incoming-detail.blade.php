@extends('admin.layouts.master')
@section('title', 'Chi tiết khách sắp nhận | Urban Luxe')

@section('content')
<div style="display:flex; height:100vh; background:#f5f6fa; overflow:hidden;">

    {{-- SIDEBAR --}}
    @include('admin.layouts.sidebar')

    {{-- MAIN CONTENT --}}
    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

        {{-- HEADER (Dùng chung như các trang khác) --}}
        @include('admin.layouts.header')

        {{-- INCOMING DETAIL WRAPPER --}}
        <div class="inc-wrapper">
            @if(session('success'))
                <div style="margin-bottom:12px; padding:10px 12px; border-radius:8px; background:#f0fdf4; color:#166534; border:1px solid #bbf7d0;">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="margin-bottom:12px; padding:10px 12px; border-radius:8px; background:#fef2f2; color:#991b1b; border:1px solid #fecaca;">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Nút Quay Lại --}}
            <a href="{{ route('admin.room-map.index') }}" class="inc-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Quay lại sơ đồ
            </a>

            {{-- KHUNG THÔNG TIN CHÍNH --}}
            <div class="inc-panel">
                
                {{-- Panel Header --}}
                <div class="inc-panel-header">
                    <h1 class="inc-title">Chi tiết phòng {{ $room->name ?? '--' }} - {{ $room->roomType->name ?? 'N/A' }}</h1>
                    <div class="inc-subtitle">MÃ PHÒNG: RM-{{ $room->name ?? '--' }}-{{ strtoupper($room->roomType->code ?? 'NA') }}</div>
                </div>

                <div class="inc-grid">
                    
                    {{-- Cột Trái (Thông tin khách đặt) --}}
                    <div class="inc-col inc-col-left">
                        <div class="inc-col-title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            THÔNG TIN KHÁCH ĐẶT
                        </div>

                        <div class="inc-data-group">
                            <div class="inc-data-label">HỌ VÀ TÊN</div>
                            <div class="inc-data-val">{{ $customerName }}</div>
                        </div>

                        <div class="inc-data-group">
                            <div class="inc-data-label">SỐ ĐIỆN THOẠI</div>
                            <div class="inc-data-val">{{ $customer->phone_number ?? 'N/A' }}</div>
                        </div>

                        <div class="inc-data-group">
                            <div class="inc-data-label">NGÀY NHẬN PHÒNG DỰ KIẾN</div>
                            <div class="inc-data-val">{{ $bookingDetail?->checkin_date?->format('d/m/Y - H:i') ?? 'N/A' }}</div>
                        </div>

                        <div class="inc-data-group" style="margin-bottom:0;">
                            <div class="inc-data-label">MÃ ĐẶT CHỖ</div>
                            <div class="inc-code-box" onclick="navigator.clipboard.writeText('{{ 'BK-' . ($booking->id ?? 'N/A') }}'); alert('Đã copy mã!');">
                                {{ 'BK-' . ($booking->id ?? 'N/A') }}
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Cột Phải (Các phòng khác của khách) --}}
                    <div class="inc-col inc-col-right">
                        <div class="inc-col-title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16h16V8l-6-6z"/><path d="M14 2v6h6"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/></svg>
                            CÁC PHÒNG KHÁC CỦA KHÁCH ĐÃ ĐẶT
                        </div>

                        @forelse($otherBookingRooms as $otherRoom)
                            <div class="inc-room-item">
                                <div class="inc-room-icon inc-icon-blue">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 6L12 11l-10-5 10-5 10 5z"/><path d="M2 12l10 5 10-5"/><path d="M2 17l10 5 10-5"/></svg>
                                </div>
                                <div>
                                    <div class="inc-room-name">Phòng {{ $otherRoom['name'] }} - {{ $otherRoom['room_type'] }}</div>
                                    <div class="inc-room-id">RM-{{ $otherRoom['name'] }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="inc-room-item">
                                <div>
                                    <div class="inc-room-name">Không có phòng khác trong booking này</div>
                                </div>
                            </div>
                        @endforelse

                    </div>
                </div>

                {{-- Action Footer --}}
                <div class="inc-panel-footer">
                    <a href="{{ route('admin.room-map.index') }}" class="inc-btn inc-btn-ghost" style="text-decoration:none;">Đóng</a>
                    <form method="POST" action="{{ route('admin.room-map.incoming-cancel', ['id' => $room->id ?? 0]) }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="inc-btn inc-btn-outline-red">Hủy đặt lịch</button>
                    </form>
                    <form method="POST" action="{{ route('admin.room-map.incoming-checkin', ['id' => $room->id ?? 0]) }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="inc-btn inc-btn-purple">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg>
                            Check-in ngay
                        </button>
                    </form>
                </div>

            </div>

            {{-- Copyright Text --}}
            <div class="inc-copyright">
                © 2024 Urban Luxe Management System. All rights reserved.
            </div>

        </div>
    </main>
</div>

@vite('resources/css/admin/incoming.css')

@endsection
