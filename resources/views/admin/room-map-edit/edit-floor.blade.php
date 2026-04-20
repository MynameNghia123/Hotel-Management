@extends('admin.layouts.master')
@section('title', 'Chỉnh sửa tầng | Urban Luxe')

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

        <div style="padding: 40px 60px; overflow-y: auto; flex: 1;">
            
            <a href="{{ route('admin.room-map-edit.index') }}" style="display:inline-flex; align-items:center; gap:8px; color:#64748b; font-size:13px; font-weight:700; text-decoration:none; margin-bottom:32px; transition:color 0.15s;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Quay lại sơ đồ
            </a>

            <div style="background:#fff; border-radius:20px; border:1px solid #e2e8f0; max-width:600px; box-shadow:0 10px 15px -3px rgba(0,0,0,0.05); overflow:hidden;">
                <div style="padding: 24px 32px; border-bottom:1px solid #f1f5f9;">
                    <h1 style="font-size:20px; font-weight:900; color:#0f172a; margin:0;">Chỉnh sửa tầng</h1>
                </div>
                
                <form method="POST" action="{{ route('admin.room-map-edit.update-floor', $floor->id) }}">
                    @csrf
                    @method('PUT')

                    <div style="padding: 32px; display:flex; flex-direction:column; gap:24px;">
                        <div style="display:flex; flex-direction:column; gap:8px;">
                            <label style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Tên tầng / Số tầng</label>
                            <input type="text" name="name" value="{{ old('name', $floor->name) }}" placeholder="Ví dụ: Tầng 6, Tầng trệt, Tầng lửng..." style="width:100%; padding:12px 16px; border-radius:10px; border:1px solid #e2e8f0; font-size:14px; outline:none; transition:border-color 0.15s;" required>
                            @error('name')
                                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div style="padding: 24px 32px; background:#f8fafc; border-top:1px solid #f1f5f9; display:flex; justify-content:flex-end; gap:12px;">
                        <a href="{{ route('admin.room-map-edit.index') }}" style="padding:10px 24px; border-radius:8px; font-size:13px; font-weight:700; color:#64748b; background:#fff; border:1px solid #e2e8f0; text-decoration:none;">Hủy</a>
                        <button type="submit" style="padding:10px 32px; border-radius:8px; font-size:13px; font-weight:800; color:#fff; background:#2a3f8a; border:none; cursor:pointer; transition:transform 0.15s, background 0.15s;">Cập nhật tầng</button>
                    </div>
                </form>
            </div>

        </div>

    </main>
</div>
@endsection
