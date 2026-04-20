@extends('admin.layouts.master')
@section('title', 'Chỉnh sửa Sơ đồ Phòng | Urban Luxe')

@section('content')
<div style="display:flex; height:100vh; background:#f8f9fb; overflow:hidden;">

    @include('admin.layouts.sidebar')

    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

        {{-- HEADER --}}
        <header style="height:64px; background:#fff; border-bottom:1px solid #f1f3f7; padding:0 32px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:8px; font-size:14px; font-weight:600; color:#1e293b;">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                16819 · Urban Luxe Hotel
            </div>
            <div style="display:flex; align-items:center; gap:10px;">
                <img src="https://ui-avatars.com/api/?name=Admin+Duc&background=2a3f8a&color=fff" style="width:36px; height:36px; border-radius:50%;">
                <div>
                    <div style="font-size:13px; font-weight:700; color:#1e293b;">Admin Đức</div>
                    <div style="font-size:11px; color:#94a3b8;">Quản lý cấp cao</div>
                </div>
            </div>
        </header>

        {{-- BODY --}}
        <div class="rme-body">
            <div class="rme-container">

                {{-- CỘT TRÁI: DANH SÁCH LOẠI PHÒNG --}}
                <aside class="rme-sidebar">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; padding:0 8px;">
                        <div class="rme-sidebar-label" style="margin-bottom:0;">Loại phòng</div>
                        <a href="{{ route('admin.room-map-edit.create-type') }}" class="rme-add-type-btn" title="Thêm loại phòng mới" style="text-decoration:none;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        </a>
                    </div>

                    <div class="rme-type-list">
                        @foreach($roomTypes as $type)
                        <a href="{{ route('admin.room-map-edit.index', ['type_id' => $type->id]) }}" class="rme-type-item {{ $selectedType && $selectedType->id == $type->id ? 'is-active' : '' }}" style="text-decoration:none; color:inherit; display:flex; justify-content:space-between;">
                            <div>
                                <div class="rme-ti-name">{{ strtoupper($type->name) }}</div>
                                <div class="rme-ti-sub">{{ $type->rooms_count ?? 0 }} phòng</div>
                            </div>
                            <span class="rme-ti-count {{ $selectedType && $selectedType->id == $type->id ? 'is-active' : '' }}">{{ $type->rooms_count ?? 0 }}</span>
                        </a>
                        @endforeach
                    </div>
                </aside>

                {{-- CỘT PHẢI: NỘI DUNG CHỈNH SỬA --}}
                <section class="rme-main">

                    @if($selectedType)
                    {{-- Tiêu đề + Nút xóa --}}
                    <div class="rme-main-header">
                        <div style="display:flex; align-items:center; gap:14px;">
                            <h1 class="rme-main-title">{{ strtoupper($selectedType->name) }}</h1>
                            <span class="rme-main-subtitle">
                                {{ $selectedType->description ?? 'Loại phòng ' . $selectedType->name }}
                            </span>
                        </div>
                    </div>

                    {{-- Danh sách tầng --}}
                    <div class="rme-floor-list">
                        @foreach($floors as $floor)
                        <div class="rme-floor-row">
                            <div class="rme-floor-drag">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="5" r="1" fill="currentColor"/><circle cx="9" cy="12" r="1" fill="currentColor"/><circle cx="9" cy="19" r="1" fill="currentColor"/><circle cx="15" cy="5" r="1" fill="currentColor"/><circle cx="15" cy="12" r="1" fill="currentColor"/><circle cx="15" cy="19" r="1" fill="currentColor"/></svg>
                            </div>
                            <div class="rme-floor-label">
                                {{ $floor->name }}
                                <form action="{{ route('admin.room-map-edit.destroy-floor', $floor->id) }}" method="POST" style="display:inline;" data-confirm-delete="Bạn có chắc chắn muốn xóa tầng này?">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="background:none; border:none; padding:0; cursor:pointer; color:#ef4444; margin-left:8px;" title="Xóa tầng">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                                    </button>
                                </form>
                            </div>
                            <div class="rme-room-list">
                                @php
                                    $roomsInFloor = $floor->rooms->where('room_type_id', $selectedType->id);
                                @endphp
                                @foreach($roomsInFloor as $room)
                                <div style="display:inline-flex; position:relative; align-items:center;">
                                    <span class="rme-room-tag {{ $room->status === 'maintenance' ? 'is-orange' : '' }}">{{ $room->name }}</span>
                                    <form action="{{ route('admin.room-map-edit.destroy-room', $room->id) }}" method="POST" style="position:absolute; top:-5px; right:-5px;" data-confirm-delete="Bạn có chắc chắn muốn xóa phòng này?">
                                        @csrf @method('DELETE')
                                        <button type="submit" style="background:#ef4444; color:white; border:none; border-radius:50%; width:16px; height:16px; cursor:pointer; display:flex; align-items:center; justify-content:center; padding:0;" title="Xóa phòng">
                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                        </button>
                                    </form>
                                </div>
                                @endforeach
                                <a href="{{ route('admin.room-map-edit.create-room', ['floor_id' => $floor->id, 'type_id' => $selectedType->id]) }}" class="rme-room-add-btn">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div style="padding: 20px; text-align: center; color: #64748b;">
                        Không có loại phòng nào được chọn hoặc chưa có loại phòng. Vui lòng thêm loại phòng trước.
                    </div>
                    @endif

                    {{-- Thêm tầng mới --}}
                    <a href="{{ route('admin.room-map-edit.create-floor') }}" class="rme-add-floor-btn" style="text-decoration:none;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Thêm tầng mới
                    </a>

                </section>

            </div>
        </div>
    </main>

</div>
@include('admin.layouts.footer') 

@vite(['resources/css/admin/room-map-edit.css'])
@endsection