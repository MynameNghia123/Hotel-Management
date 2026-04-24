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
                    <button type="button" class="rta-close-btn" onclick="history.back()">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>

                <div class="rta-body">
                    <form id="repairTicketForm" class="rta-form-grid">
                        
                        <div class="rta-form-group">
                            <label class="rta-label">CHỌN PHÒNG (ROOMID)</label>
                            <select class="rta-input rta-select">
                                <option selected disabled>Chọn phòng...</option>
                                <option>Phòng 101</option>
                                <option>Phòng 102</option>
                                <option>Phòng 301</option>
                            </select>
                        </div>

                        <div class="rta-form-group">
                            <label class="rta-label">CHỌN THIẾT BỊ (EQUIPMENTID)</label>
                            <select class="rta-input rta-select">
                                <option selected disabled>Chọn thiết bị...</option>
                                <option>Điều hòa Daikin</option>
                                <option>Tivi Samsung</option>
                                <option>Vòi sen Inax</option>
                            </select>
                        </div>

                        <div class="rta-form-group full-width">
                            <label class="rta-label">MÔ TẢ LỖI (ISSUEDESCRIPTION)</label>
                            <textarea class="rta-input rta-textarea" placeholder="Mô tả chi tiết tình trạng hư hỏng..."></textarea>
                        </div>

                        <div class="rta-form-group full-width">
                            <label class="rta-label">GHI CHÚ KỸ THUẬT (TECHNICIANNOTE)</label>
                            <textarea class="rta-input rta-textarea" placeholder="Kỹ thuật viên ghi chú quá trình xử lý..."></textarea>
                        </div>

                        <div class="rta-form-group">
                            <label class="rta-label">TRẠNG THÁI (STATUS)</label>
                            <select class="rta-input rta-select">
                                <option selected>Đang chờ</option>
                                <option>Đang sửa</option>
                                <option>Hoàn thành</option>
                                <option>Hủy</option>
                            </select>
                        </div>

                        <div class="rta-form-group">
                            <label class="rta-label">CHI PHÍ SỬA CHỮA (VNĐ)</label>
                            <div class="rta-input-wrapper">
                                <input type="number" class="rta-input" value="0" style="padding-right: 50px;">
                                <span class="rta-currency-addon">VND</span>
                            </div>
                        </div>

                        <div class="rta-form-group full-width">
                            <label class="rta-label">KỸ THUẬT VIÊN THỰC HIỆN (TECHNICIANID)</label>
                            <select class="rta-input rta-select">
                                <option selected disabled>Chọn nhân viên kỹ thuật...</option>
                                <option>Nguyễn Văn A</option>
                                <option>Trần Văn B</option>
                            </select>
                        </div>
                    </form>
                </div>

                <div class="rta-footer">
                    <button type="button" class="rta-btn-cancel" onclick="history.back()">Hủy</button>
                    <button type="submit" form="repairTicketForm" class="rta-btn-save">Lưu phiếu</button>
                </div>
            </div>
        </div>

        {{-- FOOTER --}}
        @include('admin.layouts.footer')

    </main>
</div>
@endsection
