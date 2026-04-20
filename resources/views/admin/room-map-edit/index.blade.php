@extends('admin.layouts.master')
@section('title', 'Chỉnh sửa Sơ đồ Phòng | Urban Luxe')

@section('content')
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
                        {{-- Tất cả loại phòng --}}
                        <div class="rme-type-item is-active" onclick="selectRoomType(this, null)">
                            <div>
                                <div class="rme-ti-name">TẤT CẢ LOẠI PHÒNG</div>
                                <div class="rme-ti-sub">Hiển thị tất cả tầng</div>
                            </div>
                            <span class="rme-ti-count">{{ $floors->count() }}</span>
                        </div>

                        @forelse($roomTypes as $type)
                            <div class="rme-type-item" onclick="selectRoomType(this, {{ $type->id }})">
                                <div>
                                    <div class="rme-ti-name">{{ strtoupper($type->name) }}</div>
                                    <div class="rme-ti-sub">{{ $type->code ?? 'Loại phòng' }}</div>
                                </div>
                                <span class="rme-ti-count">{{ $rooms->where('room_type_id', $type->id)->count() }}</span>
                            </div>
                        @empty
                            <div style="padding: 16px; text-align: center; color: #94a3b8; font-size: 13px;">
                                Chưa có loại phòng nào
                            </div>
                        @endforelse
                    </div>
                </aside>

                {{-- CỘT PHẢI: NỘI DUNG CHỈNH SỬA --}}
                <section class="rme-main">

                    {{-- Tiêu đề --}}
                    <div class="rme-main-header">
                        <div style="display:flex; align-items:center; gap:14px;">
                            <h1 class="rme-main-title" id="selectedRoomTypeName">
                                @if($roomTypes->first())
                                    {{ strtoupper($roomTypes->first()->name) }}
                                @else
                                    Loại phòng
                                @endif
                            </h1>
                            <span class="rme-main-subtitle" id="selectedRoomTypeDesc">
                                @if($roomTypes->first())
                                    {{ $roomTypes->first()->description ?? 'Loại phòng' }}
                                @else
                                    Chưa có loại phòng
                                @endif
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </span>
                        </div>
                    </div>

                    {{-- Danh sách tầng --}}
                    <div class="rme-floor-list">
                        @forelse($floors as $floor)
                            <div class="rme-floor-row" data-floor-id="{{ $floor->id }}" data-room-types="{{ $rooms->where('floor_id', $floor->id)->pluck('room_type_id')->join(',') }}" style="display: flex;">
                                <div class="rme-floor-drag">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="5" r="1" fill="currentColor"/><circle cx="9" cy="12" r="1" fill="currentColor"/><circle cx="9" cy="19" r="1" fill="currentColor"/><circle cx="15" cy="5" r="1" fill="currentColor"/><circle cx="15" cy="12" r="1" fill="currentColor"/><circle cx="15" cy="19" r="1" fill="currentColor"/></svg>
                                </div>
                                <div class="rme-floor-label">
                                    {{ $floor->name }}
                                    <div style="display: flex; gap: 8px; margin-left: auto;">
                                        <a href="{{ route('admin.room-map-edit.edit-floor', $floor->id) }}" title="Chỉnh sửa tầng" style="color: #64748b; cursor: pointer; text-decoration: none;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.room-map-edit.delete-floor', $floor->id) }}" style="display: inline;" onsubmit="return confirm('Bạn chắc chắn muốn xóa tầng này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Xóa tầng" style="color: #ef4444; cursor: pointer; border: none; background: none; padding: 0;">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="rme-room-list">
                                    @forelse($rooms->where('floor_id', $floor->id) as $room)
                                        <div class="rme-room-item" style="position: relative; display: inline-block;">
                                            <span class="rme-room-tag" style="cursor: pointer;" title="Nhấn để chỉnh sửa" onclick="editRoom({{ $room->id }})">{{ $room->name }}</span>
                                            <div class="rme-room-actions" style="position: absolute; top: 100%; left: 0; background: #fff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 4px; display: none; z-index: 10; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                                <a href="{{ route('admin.room-map-edit.edit-room', $room->id) }}" style="display: block; padding: 4px 8px; color: #2a3f8a; text-decoration: none; font-size: 12px;">Sửa</a>
                                                <form method="POST" action="{{ route('admin.room-map-edit.delete-room', $room->id) }}" style="display: inline;" onsubmit="return confirm('Bạn chắc chắn?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="display: block; width: 100%; text-align: left; padding: 4px 8px; color: #ef4444; border: none; background: none; font-size: 12px; cursor: pointer;">Xóa</button>
                                                </form>
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                    
                                    <a href="{{ route('admin.room-map-edit.create-room', ['floor_id' => $floor->id]) }}" class="rme-room-add-btn">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div style="padding: 32px; text-align: center; color: #94a3b8; font-size: 14px;">
                                Chưa có tầng nào. <a href="{{ route('admin.room-map-edit.create-floor') }}" style="color: #2a3f8a; text-decoration: none;">Tạo tầng mới</a>
                            </div>
                        @endforelse
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

<script>
    // Data room types
    const roomTypesData = @json($roomTypes);

    /**
     * Select room type and filter floors
     */
    function selectRoomType(element, typeId) {
        // Remove active class from all items
        document.querySelectorAll('.rme-type-item').forEach(item => {
            item.classList.remove('is-active');
        });
        
        // Add active class to clicked item
        element.classList.add('is-active');
        
        // Filter floors based on room type
        const floorRows = document.querySelectorAll('.rme-floor-row');
        floorRows.forEach(row => {
            if (typeId === null) {
                // Show all floors
                row.style.display = 'flex';
            } else {
                // Show only floors containing this room type
                const roomTypes = row.dataset.roomTypes.split(',').map(Number);
                if (roomTypes.includes(typeId)) {
                    row.style.display = 'flex';
                } else {
                    row.style.display = 'none';
                }
            }
        });
        
        // Update header
        if (typeId === null) {
            document.getElementById('selectedRoomTypeName').textContent = 'TẤT CẢ LOẠI PHÒNG';
            document.getElementById('selectedRoomTypeDesc').innerHTML = 'Hiển thị tất cả tầng <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>';
        } else {
            const roomType = roomTypesData.find(rt => rt.id === typeId);
            if (roomType) {
                document.getElementById('selectedRoomTypeName').textContent = roomType.name.toUpperCase();
                document.getElementById('selectedRoomTypeDesc').innerHTML = (roomType.description || 'Loại phòng') + 
                    '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>';
            }
        }
        
        console.log('Selected room type:', typeId);
    }

    /**
     * Edit room - redirect to edit page
     */
    function editRoom(roomId) {
        window.location.href = `{{ route('admin.room-map-edit.edit-room', ['id' => '__ROOM_ID__']) }}`.replace('__ROOM_ID__', roomId);
    }

    /**
     * Show room actions on hover
     */
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.rme-room-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                const actions = this.querySelector('.rme-room-actions');
                if (actions) actions.style.display = 'block';
            });
            
            item.addEventListener('mouseleave', function() {
                const actions = this.querySelector('.rme-room-actions');
                if (actions) actions.style.display = 'none';
            });
        });

        // Set first room type as active
        const firstType = document.querySelector('.rme-type-item');
        if (firstType) {
            firstType.classList.add('is-active');
        }
    });
</script>
@endsection