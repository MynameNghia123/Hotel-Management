@extends('admin.layouts.master')

@section('title', 'Chỉnh sửa loại phòng: {{ $roomType->name }} | Urban Luxe Admin')

@push('styles')
    @vite(['resources/css/admin/room-types.css', 'resources/css/admin/room-types-edit.css'])
    <style>
        /* Modal Styles */
        .rte-modal-overlay {
            position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6);
            display: none; justify-content: center; align-items: center; z-index: 1000;
            backdrop-filter: blur(4px);
        }
        .rte-modal-overlay.active { display: flex; }
        .rte-modal {
            background: #fff; width: 100%; max-width: 500px; border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); overflow: hidden;
            transform: scale(0.95); opacity: 0; transition: all 0.2s;
        }
        .rte-modal-overlay.active .rte-modal { transform: scale(1); opacity: 1; }
        .rte-modal-header {
            padding: 20px 24px; border-bottom: 1px solid #f1f5f9;
            display: flex; justify-content: space-between; align-items: center;
        }
        .rte-modal-title { font-size: 16px; font-weight: 800; color: #1e293b; }
        .rte-modal-close {
            background: none; border: none; cursor: pointer; color: #94a3b8; transition: 0.2s;
        }
        .rte-modal-close:hover { color: #ef4444; }
        .rte-modal-body { padding: 24px; max-height: 400px; overflow-y: auto; }
        .rte-modal-footer {
            padding: 16px 24px; border-top: 1px solid #f1f5f9; background: #f8fafc;
            display: flex; justify-content: flex-end; gap: 12px;
        }
        /* Amenities Grid in Modal */
        .amenities-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .amenity-checkbox-wrapper {
            display: flex; align-items: center; gap: 12px; padding: 12px;
            border: 1px solid #e2e8f0; border-radius: 10px; cursor: pointer; transition: 0.2s;
        }
        .amenity-checkbox-wrapper:hover { border-color: #cbd5e1; background: #f8fafc; }
        .amenity-checkbox-wrapper.checked { border-color: #2a3f8a; background: #f0f4ff; }
        .amenity-checkbox-wrapper input { display: none; }
        /* Equipment Select in Modal */
        .equip-modal-row { display: flex; gap: 12px; margin-bottom: 16px; }
    </style>
@endpush

@section('content')
<div class="admin-layout">
    @include('admin.layouts.sidebar')

    <main class="admin-main">
        {{-- HEADER TOP BAR --}}
        <header class="admin-header">
            <div class="header-left">
                <span class="work-date">NGÀY LÀM VIỆC: <strong>24 Tháng 05, 2024</strong></span>
            </div>
            <div class="header-right">
                <button class="notif-btn">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
                    <span class="dot"></span>
                </button>
                <div class="user-profile">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=2a3f8a&color=fff" alt="User">
                </div>
            </div>
        </header>

        {{-- MAIN CONTENT AREA --}}
        <div class="admin-content">

            {{-- PAGE HEADER ACTIONS --}}
            <div class="page-actions-header">
                <div class="header-titles">
                    <a href="{{ route('admin.rooms.show', $roomType->id) }}" class="back-text">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        Trở lại danh sách
                    </a>
                    <h1 class="main-title">Chỉnh sửa loại phòng: {{ $roomType->name }}</h1>
                    <p class="sub-desc">Hệ thống quản trị khách sạn Urban Luxe</p>
                </div>
                <div class="right-badges">
                    <button class="btn-cancel" onclick="history.back()">Quay lại</button>
                    <button class="btn-primary-blue" type="submit" form="roomTypeEditForm">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Lưu thay đổi
                    </button>
                </div>
            </div>

            <form id="roomTypeEditForm" action="{{ route('admin.rooms.update', $roomType->id) }}" method="POST">
                <div class="details-grid-layout">
                    @csrf
                    @method('PUT')

                    {{-- LEFT COLUMN --}}
                    <div class="details-col-left">

                        {{-- THÔNG TIN CHUNG --}}
                        <div class="details-card">
                            <h3 class="card-section-title">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                THÔNG TIN CHUNG
                            </h3>

                            <div class="info-split" style="margin-bottom: 24px;">
                                <div class="rte-form-group">
                                    <label class="rte-label">Tên loại phòng</label>
                                    <input type="text" name="name" class="rte-input" value="{{ old('name', $roomType->name) }}" placeholder="Nhập tên loại phòng...">
                                </div>
                                <div class="rte-form-group">
                                    <label class="rte-label">Mã loại phòng</label>
                                    <input type="text" name="code" class="rte-input" value="{{ old('code', $roomType->code) }}" placeholder="VD: USK-001">
                                </div>
                            </div>

                            <div class="rte-form-group" style="margin-bottom: 24px;">
                                <label class="rte-label">Trạng thái</label>
                                <select name="is_active" class="rte-input rte-select">
                                    <option value="1" {{ old('is_active', $roomType->is_active) ? 'selected' : '' }}>Đang kinh doanh</option>
                                    <option value="0" {{ !old('is_active', $roomType->is_active) ? 'selected' : '' }}>Ngừng kinh doanh</option>
                                </select>
                            </div>

                            <div class="rte-form-group">
                                <label class="rte-label">Mô tả loại phòng</label>
                                <textarea name="description" class="rte-input rte-textarea" rows="6" placeholder="Nhập mô tả chi tiết về loại phòng...">{{ old('description', $roomType->description) }}</textarea>
                            </div>
                        </div>

                        {{-- KÍCH THƯỚC & GIÁ --}}
                        <div class="details-card">
                            <h3 class="card-section-title">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0110 0v4"></path></svg>
                                KÍCH THƯỚC & GIÁ
                            </h3>

                            <div class="pricing-container">
                                <div class="dimension-box">
                                    <label class="rte-label" style="margin-bottom: 15px; display: block;">KÍCH THƯỚC PHÒNG</label>
                                    <div class="dim-flex">
                                        <div class="rte-form-group" style="flex:1;">
                                            <label class="rte-label" style="font-size:10px; color:#94a3b8;">Rộng (m)</label>
                                            <input type="number" name="width" class="rte-input" value="{{ old('width', $roomType->width) }}" step="0.1" style="text-align:center; font-size:18px; font-weight:800;">
                                        </div>
                                        <div class="dim-divider" style="margin: 0 16px;"></div>
                                        <div class="rte-form-group" style="flex:1;">
                                            <label class="rte-label" style="font-size:10px; color:#94a3b8;">Dài (m)</label>
                                            <input type="number" name="height" class="rte-input" value="{{ old('height', $roomType->height) }}" step="0.1" style="text-align:center; font-size:18px; font-weight:800;">
                                        </div>
                                    </div>
                                </div>
                                <div class="price-side">
                                    <div class="rte-form-group">
                                        <label class="rte-label">Giá giờ (hourly)</label>
                                        <div style="position:relative;">
                                            <input type="number" name="hourly_price" class="rte-input" value="{{ old('hourly_price', $roomType->hourly_price) }}" style="font-size:20px; font-weight:850; color:#2a3f8a; padding-right:50px;">
                                            <span style="position:absolute; right:16px; top:50%; transform:translateY(-50%); font-size:12px; font-weight:800; color:#94a3b8;">VNĐ</span>
                                        </div>
                                    </div>
                                    <div class="rte-form-group" style="margin-top:16px;">
                                        <label class="rte-label">Giá ngày (daily)</label>
                                        <div style="position:relative;">
                                            <input type="number" name="daily_price" class="rte-input" value="{{ old('daily_price', $roomType->daily_price) }}" style="font-size:20px; font-weight:850; color:#2a3f8a; padding-right:50px;">
                                            <span style="position:absolute; right:16px; top:50%; transform:translateY(-50%); font-size:12px; font-weight:800; color:#94a3b8;">VNĐ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SỨC CHỨA --}}
                        <div class="details-card">
                            <h3 class="card-section-title">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                                SỨC CHỨA
                            </h3>
                            <div class="capacity-cards-grid">
                                <div class="cap-card">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <span>Người lớn</span>
                                    <input type="number" name="adult_quantity" value="{{ old('adult_quantity', $roomType->adult_quantity) }}" class="rte-input" style="border:none; background:transparent; font-size:24px; font-weight:850; text-align:center; padding:0; width:40px;">
                                </div>
                                <div class="cap-card">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path><circle cx="12" cy="7" r="1.5"></circle><circle cx="12" cy="7" r="4"></circle></svg>
                                    <span>Trẻ em</span>
                                    <input type="number" name="child_quantity" value="{{ old('child_quantity', $roomType->child_quantity) }}" class="rte-input" style="border:none; background:transparent; font-size:24px; font-weight:850; text-align:center; padding:0; width:40px;">
                                </div>
                                <div class="cap-card">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 17v-4M17 17v-4M3 8v9M21 8v9M3 11h18M5 8h14a2 2 0 012 2v1h-18v-1a2 2 0 012-2z"/></svg>
                                    <span>Giường đơn</span>
                                    <input type="number" name="single_bed_quantity" value="{{ old('single_bed_quantity', $roomType->single_bed_quantity) }}" class="rte-input" style="border:none; background:transparent; font-size:24px; font-weight:850; text-align:center; padding:0; width:40px;">
                                </div>
                                <div class="cap-card">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="8" rx="2"/><path d="M7 11V7a2 2 0 012-2h6a2 2 0 012 2v4M11 11v4"/></svg>
                                    <span>Giường đôi</span>
                                    <input type="number" name="double_bed_quantity" value="{{ old('double_bed_quantity', $roomType->double_bed_quantity) }}" class="rte-input" style="border:none; background:transparent; font-size:24px; font-weight:850; text-align:center; padding:0; width:40px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div class="details-col-right">

                        {{-- MEDIA --}}
                        <div class="details-card">
                            <div class="card-top-flex">
                                <h3 class="card-section-title">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"></polyline></svg>
                                    MEDIA (HÌNH ẢNH)
                                </h3>
                                <button type="button" class="rte-upload-btn" onclick="document.getElementById('image-upload').click()">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                    Tải ảnh lên
                                </button>
                                <input type="file" id="image-upload" style="display:none;" accept="image/*" onchange="uploadImage(this, {{ $roomType->id }})">
                            </div>

                            <div class="media-list" id="media-list">
                                @forelse($roomType->images as $img)
                                <div class="media-item" id="media-{{ $img->id }}">
                                    <img src="{{ $img->image_url }}" alt="Image">
                                    <div class="media-info" style="flex:1;">
                                        <strong>Image #{{ $loop->iteration }}</strong>
                                        <span>Order: {{ $img->order }}</span>
                                    </div>
                                    <button type="button" class="rte-media-del" onclick="deleteImage({{ $roomType->id }}, {{ $img->id }})">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                    </button>
                                </div>
                                @empty
                                <div class="media-item border-left-active empty-msg">Chưa có hình ảnh.</div>
                                @endforelse
                            </div>
                            <div class="rte-upload-zone" onclick="document.getElementById('image-upload').click()">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                <span>Kéo thả ảnh hoặc <span style="color:#2a3f8a; cursor:pointer; font-weight:700;">chọn từ máy</span></span>
                            </div>
                        </div>

                        {{-- TIỆN ÍCH --}}
                        <div class="details-card">
                            <h3 class="card-section-title">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 21l-8-4.5v-9L12 3l8 4.5v9z"></path><polyline points="12 21 12 12 20 7.5"></polyline><line x1="12" y1="12" x2="4" y2="7.5"></line></svg>
                                TIỆN ÍCH (AMENITIES)
                            </h3>
                            <div class="amenities-flex" id="amenities-container">
                                @forelse($roomType->amenities as $am)
                                <label class="amenity-toggle is-on">
                                    <span><span class="material-symbols-outlined" style="font-size:16px; margin-right:4px; vertical-align:middle;">{{ strtolower(trim($am->icon)) }}</span>{{ $am->name }}</span>
                                </label>
                                @empty
                                <span class="empty-msg" style="font-size:13px; color:#94a3b8;">Chưa có tiện ích.</span>
                                @endforelse
                                <button type="button" class="amenity-toggle" style="border-style:dashed; border-color:#cbd5e1; background:transparent;" onclick="openAmenityModal()">
                                    <span>+ Quản lý tiện ích</span>
                                </button>
                            </div>
                        </div>

                        {{-- THIẾT BỊ --}}
                        <div class="details-card">
                            <div class="card-top-flex">
                                <h3 class="card-section-title">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>
                                    THIẾT BỊ (ROOM EQUIPMENT)
                                </h3>
                            </div>

                            <table class="equip-table" id="equip-table">
                                <thead>
                                    <tr>
                                        <th>TÊN THIẾT BỊ</th>
                                        <th style="text-align:center;">SL</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($roomType->equipments as $eq)
                                    <tr>
                                        <td>{{ $eq->name }}<input type="hidden" name="equip_id[]" value="{{ $eq->id }}"></td>
                                        <td style="text-align:center;">
                                            <input type="number" name="equip_qty[]" class="rte-table-input rte-qty" value="{{ $eq->pivot->quantity }}" min="1" style="text-align:center;" onchange="syncEquipments({{ $roomType->id }})">
                                        </td>
                                        <td style="text-align:right;">
                                            <button type="button" class="rte-del-row" onclick="removeEquipmentRow(this, {{ $roomType->id }})">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="empty-msg"><td colspan="3" style="text-align:center; color:#94a3b8; font-size:13px;">Chưa có thiết bị.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <button type="button" class="rte-upload-zone" style="margin-top:16px; width:100%; padding:10px; border-style:dashed;" onclick="openEquipModal()">
                                <span style="font-size:12px; font-weight:700;">+ Thêm thiết bị mới</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @include('admin.layouts.footer')
    </main>
</div>

{{-- MODAL AMENITIES --}}
<div class="rte-modal-overlay" id="amenityModal">
    <div class="rte-modal">
        <div class="rte-modal-header">
            <div class="rte-modal-title">Quản lý Tiện ích</div>
            <button class="rte-modal-close" onclick="closeModal('amenityModal')"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <div class="rte-modal-body">
            <div class="amenities-grid">
                @php $currentAmIds = $roomType->amenities->pluck('id')->toArray(); @endphp
                @foreach($allAmenities as $am)
                <label class="amenity-checkbox-wrapper {{ in_array($am->id, $currentAmIds) ? 'checked' : '' }}">
                    <input type="checkbox" value="{{ $am->id }}" class="amenity-checkbox" {{ in_array($am->id, $currentAmIds) ? 'checked' : '' }} onchange="this.parentElement.classList.toggle('checked', this.checked)">
                    <span class="material-symbols-outlined" style="font-size:20px; color:#64748b;">{{ strtolower(trim($am->icon)) }}</span>
                    <span style="font-size:14px; font-weight:600; color:#333;">{{ $am->name }}</span>
                </label>
                @endforeach
            </div>
        </div>
        <div class="rte-modal-footer">
            <button class="btn-cancel" onclick="closeModal('amenityModal')" style="padding:8px 16px;">Hủy</button>
            <button class="btn-primary-blue" onclick="saveAmenities({{ $roomType->id }})" style="padding:8px 16px;">Lưu tiện ích</button>
        </div>
    </div>
</div>

{{-- MODAL EQUIPMENT --}}
<div class="rte-modal-overlay" id="equipModal">
    <div class="rte-modal">
        <div class="rte-modal-header">
            <div class="rte-modal-title">Thêm Thiết Bị Mới</div>
            <button class="rte-modal-close" onclick="closeModal('equipModal')"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <div class="rte-modal-body">
            <div class="equip-modal-row">
                <div class="rte-form-group" style="flex:1;">
                    <label class="rte-label">Chọn thiết bị</label>
                    <select id="new-equip-id" class="rte-input rte-select">
                        @foreach($allEquipments as $eq)
                            <option value="{{ $eq->id }}" data-name="{{ $eq->name }}">{{ $eq->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="rte-form-group" style="width:100px;">
                    <label class="rte-label">Số lượng</label>
                    <input type="number" id="new-equip-qty" class="rte-input" value="1" min="1" style="text-align:center;">
                </div>
            </div>
        </div>
        <div class="rte-modal-footer">
            <button class="btn-cancel" onclick="closeModal('equipModal')" style="padding:8px 16px;">Hủy</button>
            <button class="btn-primary-blue" onclick="addEquipmentRow({{ $roomType->id }})" style="padding:8px 16px;">Thêm</button>
        </div>
    </div>
</div>

<script>
    const csrfToken = "{{ csrf_token() }}";
</script>
@vite('resources/js/admin/room-type-edit.js')

@endsection
