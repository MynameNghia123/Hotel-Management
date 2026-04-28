@extends('admin.layouts.master')
@section('title', 'Chỉnh sửa Sơ đồ Phòng | Urban Luxe')

@section('content')
{{-- Flash Messages --}}
@if($errors->any())
<div style="position:fixed; top:20px; right:20px; background:#fee2e2; border:1px solid #fecaca; border-radius:8px; padding:16px; max-width:400px; z-index:10000; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
    <div style="display:flex; gap:12px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div>
            <div style="font-weight:700; color:#991b1b; margin-bottom:8px;">❌ Lỗi xóa tầng</div>
            @foreach($errors->all() as $error)
            <div style="font-size:14px; color:#7f1d1d; margin-bottom:4px;">{{ $error }}</div>
            @endforeach
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div style="position:fixed; top:20px; right:20px; background:#fee2e2; border:1px solid #fecaca; border-radius:8px; padding:16px; max-width:400px; z-index:10000; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
    <div style="display:flex; gap:12px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div>
            <div style="font-weight:700; color:#991b1b; margin-bottom:8px;">❌ Lỗi</div>
            <div style="font-size:14px; color:#7f1d1d;">{{ session('error') }}</div>
        </div>
    </div>
</div>
@endif

@if(session('success'))
<div style="position:fixed; top:20px; right:20px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:16px; max-width:400px; z-index:10000; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
    <div style="display:flex; gap:12px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <div>
            <div style="font-weight:700; color:#15803d; margin-bottom:8px;">✅ Thành công</div>
            <div style="font-size:14px; color:#166534;">{{ session('success') }}</div>
        </div>
    </div>
</div>
@endif

<div style="display:flex; height:100vh; background:#f8f9fb; overflow:hidden;">

    @include('admin.layouts.sidebar')

    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

        {{-- HEADER --}}
        @include('admin.layouts.header')

        {{-- BODY --}}
        <div class="rme-body">
            <div class="rme-container">

                {{-- CỘT TRÁI: DANH SÁCH LOẠI PHÒNG --}}
                <aside class="rme-sidebar">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; padding:0 8px;">
                        <div class="rme-sidebar-label" style="margin-bottom:0;">Loại phòng</div>
                    </div>

                    <div class="rme-type-list">
                        {{-- Tất cả phòng --}}
                        <a href="{{ route('admin.room-map-edit.index') }}" class="rme-type-item {{ !$selectedType ? 'is-active' : '' }}" style="text-decoration:none; color:inherit; display:flex; justify-content:space-between;">
                            <div>
                                <div class="rme-ti-name">TẤT CẢ PHÒNG</div>
                                <div class="rme-ti-sub">{{ $rooms->count() ?? 0 }} phòng</div>
                            </div>
                            <span class="rme-ti-count {{ !$selectedType ? 'is-active' : '' }}">{{ $rooms->count() ?? 0 }}</span>
                        </a>

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

                    {{-- Tiêu đề --}}
                    <div class="rme-main-header">
                        <div style="display:flex; align-items:center; gap:14px;">
                            @if($selectedType)
                            <h1 class="rme-main-title">{{ strtoupper($selectedType->name) }}</h1>
                            <span class="rme-main-subtitle">
                                {{ $selectedType->description ?? 'Loại phòng ' . $selectedType->name }}
                            </span>
                            @else
                            <h1 class="rme-main-title">TẤT CẢ PHÒNG</h1>
                            <span class="rme-main-subtitle">
                                Hiển thị tất cả tầng và phòng
                            </span>
                            @endif
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
                                @php
                                    $roomCount = $floor->rooms->count();
                                    $deleteMessage = $roomCount > 0 
                                        ? "⚠️ KHÔNG THỂ XÓA\n\nTầng này có $roomCount phòng. Vui lòng xóa hết phòng trước!" 
                                        : "⚠️ Xác nhận xóa tầng này?\n\nHành động này không thể hoàn tác.";
                                    $isDisabled = $roomCount > 0;
                                @endphp
                                <form action="{{ route('admin.room-map-edit.destroy-floor', $floor->id) }}" method="POST" style="display:inline;" {{ $isDisabled ? 'disabled' : '' }} data-confirm-delete="{{ $deleteMessage }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="background:none; border:none; padding:0; cursor:{{ $isDisabled ? 'not-allowed' : 'pointer' }}; color:{{ $isDisabled ? '#cbd5e1' : '#ef4444' }}; margin-left:8px; opacity:{{ $isDisabled ? '0.5' : '1' }};" title="{{ $isDisabled ? 'Không thể xóa (còn phòng bên trong)' : 'Xóa tầng' }}" {{ $isDisabled ? 'onclick="return false;"' : '' }}>
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                                    </button>
                                </form>
                            </div>
                            <div class="rme-room-list">
                                @php
                                    $roomsInFloor = $selectedType ? $floor->rooms->where('room_type_id', $selectedType->id) : $floor->rooms;
                                @endphp
                                @foreach($roomsInFloor as $room)
                                <div style="display:inline-flex; position:relative; align-items:center;">
                                    <span class="rme-room-tag {{ $room->status === \App\Enums\RoomStatus::DIRTY ? 'is-orange' : '' }}">{{ $room->name }}</span>
                                    <form action="{{ route('admin.room-map-edit.destroy-room', $room->id) }}" method="POST" style="position:absolute; top:-5px; right:-5px;" data-confirm-delete="⚠️ Xác nhận xóa phòng này?\n\nHành động này không thể hoàn tác.">
                                        @csrf @method('DELETE')
                                        <button type="submit" style="background:#ef4444; color:white; border:none; border-radius:50%; width:16px; height:16px; cursor:pointer; display:flex; align-items:center; justify-content:center; padding:0;" title="Xóa phòng">
                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                        </button>
                                    </form>
                                </div>
                                @endforeach
                                <a href="{{ route('admin.room-map-edit.create-room', ['floor_id' => $floor->id] + ($selectedType ? ['type_id' => $selectedType->id] : [])) }}" class="rme-room-add-btn">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>

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

{{-- Include Confirm Delete Modal Component --}}
@include('components.confirm-delete')

<script>
    // Auto-dismiss flash messages after 5 seconds
    document.addEventListener('DOMContentLoaded', () => {
        const flashMessages = document.querySelectorAll('[style*="position:fixed"][style*="top:20px"]');
        flashMessages.forEach(msg => {
            setTimeout(() => {
                msg.style.opacity = '0';
                msg.style.transition = 'opacity 0.3s ease';
                setTimeout(() => msg.remove(), 300);
            }, 5000);
        });
    });
</script>

@endsection
