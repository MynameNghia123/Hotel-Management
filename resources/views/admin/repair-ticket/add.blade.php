@extends('admin.layouts.master')

@section('title', 'Tạo phiếu sửa chữa mới | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/repair-ticket-add.css')
@endpush

@section('content')
<div style="display:flex; height:100vh; background:#f5f6fa;">

    {{-- SIDEBAR --}}
    @include('admin.layouts.sidebar')

    {{-- CONTENT --}}
    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

         {{-- HEADER --}}
        @include('admin.layouts.header')


        {{-- MAIN CONTENT --}}
        <div style="flex:1; overflow-y:auto; padding:32px 32px 80px; display:flex; flex-direction:column; background:#f8fafc; align-items:center;">
            
            <div class="rta-page-header" style="width:100%; max-width:1100px;">
                <h1 class="rta-title">Quản lý phiếu sửa chữa</h1>
                <p class="rta-subtitle">Hệ thống quản trị khách sạn Urban Luxe - Quản lý phiếu sửa chữa thiết bị.</p>
            </div>

            <div class="rta-container">
                <div class="rta-header">
                    <div>
                        <h2 class="rta-box-title">Phiếu Sửa Chữa Mới</h2>
                        <p class="rta-box-subtitle">Tạo mới hoặc cập nhật thông tin phiếu sửa chữa thiết bị.</p>
                    </div>
                    <a href="{{ route('admin.repair-ticket.index') }}" class="rta-close-btn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </a>
                </div>

                <div class="rta-body">
                    <form action="{{ route('admin.repair-ticket.store') }}" method="POST" id="repairTicketForm" class="rta-form-grid">
                        @csrf

                        <div class="rta-form-group">
                            <label class="rta-label">CHỌN PHÒNG <span style="color: red;">*</span></label>
                            <select name="room_id" class="rta-input rta-select @error('room_id') is-invalid @enderror" required>
                                <option value="" disabled selected>Chọn phòng...</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" @if(old('room_id') == $room->id) selected @endif>Phòng {{ $room->name }} - {{ $room->roomType->name }}</option>
                                @endforeach
                            </select>
                            @error('room_id')
                                <small style="color: #dc2626;">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="rta-form-group">
                            <label class="rta-label">NGÀY BÁO CÁO <span style="color: red;">*</span></label>
                            <input type="date" name="reported_date" class="rta-input @error('reported_date') is-invalid @enderror" value="{{ old('reported_date', date('Y-m-d')) }}" required>
                            @error('reported_date')
                                <small style="color: #dc2626;">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="rta-form-group">
                            <label class="rta-label">CHI PHÍ SỬA CHỮA</label>
                            <input type="number" name="repair_cost" step="0.01" min="0" class="rta-input @error('repair_cost') is-invalid @enderror" value="{{ old('repair_cost', 0) }}" placeholder="0.00">
                            @error('repair_cost')
                                <small style="color: #dc2626;">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="rta-form-group full-width">
                            <label class="rta-label">MÔ TẢ VẤN ĐỀ <span style="color: red;">*</span></label>
                            <textarea name="issue_description" class="rta-input rta-textarea @error('issue_description') is-invalid @enderror" placeholder="Mô tả chi tiết vấn đề..." required>{{ old('issue_description') }}</textarea>
                            @error('issue_description')
                                <small style="color: #dc2626;">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="rta-form-group full-width">
                            <label class="rta-label">GHI CHÚ KỸ THUẬT</label>
                            <textarea name="technician_note" class="rta-input rta-textarea @error('technician_note') is-invalid @enderror" placeholder="Ghi chú kỹ thuật...">{{ old('technician_note') }}</textarea>
                            @error('technician_note')
                                <small style="color: #dc2626;">{{ $message }}</small>
                            @enderror
                        </div>
                    </form>
                </div>

                <div class="rta-footer">
                    <a href="{{ route('admin.repair-ticket.index') }}" class="rta-btn-cancel">Quay lại</a>
                    <button type="submit" form="repairTicketForm" class="rta-btn-save">Lưu phiếu</button>
                </div>
            </div>
        </div>

        {{-- FOOTER --}}
        @include('admin.layouts.footer')

    </main>
</div>
@endsection
