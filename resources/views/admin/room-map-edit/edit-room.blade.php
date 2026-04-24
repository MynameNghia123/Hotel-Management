@extends('admin.layouts.master')
@section('title', 'Chỉnh sửa phòng | Urban Luxe')

@section('content')
<div style="display:flex; height:100vh; background:#f8f9fb; overflow:hidden;">

    @include('admin.layouts.sidebar')

    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

        {{-- HEADER --}}
        @include('admin.layouts.header')

        <div style="padding: 40px 60px; overflow-y: auto; flex: 1;">
            
            <a href="{{ route('admin.room-map-edit.index') }}" style="display:inline-flex; align-items:center; gap:8px; color:#64748b; font-size:13px; font-weight:700; text-decoration:none; margin-bottom:32px; transition:color 0.15s;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Quay lại sơ đồ
            </a>

            <div style="background:#fff; border-radius:20px; border:1px solid #e2e8f0; max-width:600px; box-shadow:0 10px 15px -3px rgba(0,0,0,0.05); overflow:hidden;">
                <div style="padding: 24px 32px; border-bottom:1px solid #f1f5f9;">
                    <h1 style="font-size:20px; font-weight:900; color:#0f172a; margin:0;">Chỉnh sửa phòng</h1>
                </div>
                
                <form method="POST" action="{{ route('admin.room-map-edit.update-room', $room->id) }}">
                    @csrf
                    @method('PUT')

                    <div style="padding: 32px; display:flex; flex-direction:column; gap:24px;">
                        <div style="display:flex; flex-direction:column; gap:8px;">
                            <label style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Số phòng</label>
                            <input type="text" name="name" value="{{ old('name', $room->name) }}" placeholder="Nhập số phòng (vd: 101, 202...)" style="width:100%; padding:12px 16px; border-radius:10px; border:1px solid #e2e8f0; font-size:14px; outline:none; transition:border-color 0.15s;" required>
                            @error('name')
                                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="display:flex; flex-direction:column; gap:8px;">
                            <label style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Loại phòng</label>
                            <select name="room_type_id" style="width:100%; padding:12px 16px; border-radius:10px; border:1px solid #e2e8f0; font-size:14px; outline:none; background:#fff; cursor:pointer;" required>
                                <option value="">-- Chọn loại phòng --</option>
                                @foreach($roomTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('room_type_id', $room->room_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('room_type_id')
                                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="display:flex; flex-direction:column; gap:8px;">
                            <label style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Tầng</label>
                            <select name="floor_id" style="width:100%; padding:12px 16px; border-radius:10px; border:1px solid #e2e8f0; font-size:14px; outline:none; background:#fff; cursor:pointer;" required>
                                <option value="">-- Chọn tầng --</option>
                                @foreach($floors as $floor)
                                    <option value="{{ $floor->id }}" {{ old('floor_id', $room->floor_id) == $floor->id ? 'selected' : '' }}>{{ $floor->name }}</option>
                                @endforeach
                            </select>
                            @error('floor_id')
                                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div style="padding: 24px 32px; background:#f8fafc; border-top:1px solid #f1f5f9; display:flex; justify-content:flex-end; gap:12px;">
                        <a href="{{ route('admin.room-map-edit.index') }}" style="padding:10px 24px; border-radius:8px; font-size:13px; font-weight:700; color:#64748b; background:#fff; border:1px solid #e2e8f0; text-decoration:none;">Hủy</a>
                        <button type="submit" style="padding:10px 32px; border-radius:8px; font-size:13px; font-weight:800; color:#fff; background:#2a3f8a; border:none; cursor:pointer; transition:transform 0.15s, background 0.15s;">Cập nhật phòng</button>
                    </div>
                </form>
            </div>

        </div>

    </main>
</div>
@endsection
