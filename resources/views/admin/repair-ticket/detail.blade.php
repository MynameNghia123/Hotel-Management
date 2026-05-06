@extends('admin.layouts.master')

@section('title', 'Chi tiết phiếu sửa chữa | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/repair-ticket-detail.css')
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
            
            <div class="rtd-page-header" style="width:100%; max-width:1100px;">
                <h1 class="rtd-title">Chi tiết phiếu sửa chữa</h1>
                <p class="rtd-subtitle">Hệ thống quản trị khách sạn Urban Luxe - Xem chi tiết và quản lý phiếu sửa chữa.</p>
            </div>

            <div class="rtd-container">
                @if ($message = Session::get('success'))
                    <div style="margin-bottom: 16px; padding: 12px 16px; background: #dcfce7; border: 1px solid #86efac; border-radius: 8px; color: #166534; font-weight: 500;">
                        ✓ {{ $message }}
                    </div>
                @endif
                @if ($message = Session::get('error'))
                    <div style="margin-bottom: 16px; padding: 12px 16px; background: #fee2e2; border: 1px solid #fecaca; border-radius: 8px; color: #991b1b; font-weight: 500;">
                        ✕ {{ $message }}
                    </div>
                @endif

                <div class="rtd-header">
                    <div>
                        <h2 class="rtd-box-title">Phiếu Sửa Chữa #{{ $repairTicket->id }}</h2>
                        <p class="rtd-box-subtitle">Ngày tạo: {{ $repairTicket->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <a href="{{ route('admin.repair-ticket.index') }}" class="rtd-back-link">← Quay lại</a>
                </div>

                <div class="rtd-content">
                    <!-- Information Section -->
                    <div class="rtd-section">
                        <h3 class="rtd-section-title">Thông tin chung</h3>
                        
                        <div class="rtd-info-grid">
                            <div class="rtd-info-item">
                                <label class="rtd-info-label">PHÒNG</label>
                                <div class="rtd-info-value">
                                    Phòng {{ $repairTicket->room->name }}
                                    <small style="display: block; color: #6b7280; margin-top: 4px;">{{ $repairTicket->room->roomType->name }}</small>
                                </div>
                            </div>

                            <div class="rtd-info-item">
                                <label class="rtd-info-label">TRẠNG THÁI</label>
                                <div class="rtd-info-value">
                                    <span class="rtd-badge rtd-badge-{{ $repairTicket->status->value }}">
                                        {{ $repairTicket->status->label() }}
                                    </span>
                                </div>
                            </div>

                            <div class="rtd-info-item">
                                <label class="rtd-info-label">NGÀY BÁO CÁO</label>
                                <div class="rtd-info-value">
                                    {{ $repairTicket->reported_date->format('d/m/Y') }}
                                </div>
                            </div>

                            <div class="rtd-info-item">
                                <label class="rtd-info-label">CHI PHÍ SỬA CHỮA</label>
                                <div class="rtd-info-value">
                                    {{ number_format($repairTicket->repair_cost, 2, ',', '.') }} VND
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Issue Description Section -->
                    <div class="rtd-section">
                        <h3 class="rtd-section-title">Mô tả vấn đề</h3>
                        <div class="rtd-description-box">
                            {{ $repairTicket->issue_description }}
                        </div>
                    </div>

                    <!-- Notes Section -->
                    <div class="rtd-section">
                        <h3 class="rtd-section-title">Ghi chú kỹ thuật</h3>
                        @if($repairTicket->technician_note)
                            <div class="rtd-description-box">
                                {{ $repairTicket->technician_note }}
                            </div>
                        @else
                            <div style="padding: 16px; background: #f1f5f9; border-radius: 6px; color: #64748b; text-align: center;">
                                Không có ghi chú
                            </div>
                        @endif
                    </div>

                    <!-- Status Update Section -->
                    @if($repairTicket->status->value !== 'completed')
                    <div class="rtd-section">
                        <h3 class="rtd-section-title">Cập nhật trạng thái</h3>
                        
                        <form id="updateStatusForm" method="POST" action="{{ route('admin.repair-ticket.updateStatus', $repairTicket->id) }}">
                            @csrf
                            @method('PATCH')
                            
                            <div class="rtd-form-grid">
                                <div class="rtd-form-group">
                                    <label class="rtd-label">TRẠNG THÁI MỚI <span style="color: red;">*</span></label>
                                    <select name="status" class="rtd-input rtd-select @error('status') is-invalid @enderror" required id="statusSelect">
                                        <option value="" disabled selected>Chọn trạng thái...</option>
                                    </select>
                                    @error('status')
                                        <small style="color: #dc2626;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="rtd-form-group">
                                    <label class="rtd-label">GHI CHÚ KỸ THUẬT</label>
                                    <textarea name="notes" class="rtd-input @error('notes') is-invalid @enderror" rows="4" placeholder="Thêm ghi chú kỹ thuật..."></textarea>
                                    @error('notes')
                                        <small style="color: #dc2626;">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="rtd-form-actions">
                                <button type="button" class="rtd-btn-secondary" onclick="history.back()">Quay lại</button>
                                <button type="submit" class="rtd-btn-primary">Cập nhật trạng thái</button>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</div>

<style>
.rtd-page-header { margin-bottom: 24px; }
.rtd-title { font-size: 28px; font-weight: 700; color: #1e293b; margin: 0; }
.rtd-subtitle { font-size: 14px; color: #64748b; margin: 4px 0 0; }

.rtd-container { width: 100%; max-width: 900px; background: white; border-radius: 8px; overflow: hidden; }
.rtd-header { padding: 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: flex-start; }
.rtd-box-title { font-size: 20px; font-weight: 600; color: #1e293b; margin: 0; }
.rtd-box-subtitle { font-size: 14px; color: #64748b; margin: 4px 0 0; }
.rtd-close-btn { background: none; border: none; cursor: pointer; color: #94a3b8; padding: 6px; transition: color 0.3s; }
.rtd-close-btn:hover { color: #1e293b; }
.rtd-back-link { color: #1e3a8a; text-decoration: none; font-weight: 500; font-size: 14px; padding: 8px 12px; border-radius: 6px; transition: all 0.3s; display: inline-block; }
.rtd-back-link:hover { background: #f1f5f9; color: #1e40af; }

.rtd-content { padding: 24px; }
.rtd-section { margin-bottom: 32px; }
.rtd-section:last-child { margin-bottom: 0; }
.rtd-section-title { font-size: 16px; font-weight: 600; color: #1e293b; margin: 0 0 16px; padding-bottom: 12px; border-bottom: 2px solid #f1f5f9; }

.rtd-info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
.rtd-info-item { }
.rtd-info-label { display: block; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
.rtd-info-value { font-size: 14px; color: #1e293b; font-weight: 500; }

.rtd-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; }
.rtd-badge-pending { background: #fef3c7; color: #92400e; }
.rtd-badge-in_progress { background: #dbeafe; color: #1e40af; }
.rtd-badge-completed { background: #dcfce7; color: #166534; }

.rtd-description-box { padding: 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; color: #475569; line-height: 1.6; white-space: pre-wrap; word-break: break-word; }

.rtd-form-grid { display: grid; grid-template-columns: 1fr; gap: 16px; margin-bottom: 20px; }
.rtd-form-group { }
.rtd-label { display: block; font-size: 14px; font-weight: 500; color: #1e293b; margin-bottom: 8px; }
.rtd-input { width: 100%; padding: 10px 12px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 14px; font-family: inherit; }
.rtd-input:focus { outline: none; border-color: #0f172a; box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.1); }
.rtd-input.is-invalid { border-color: #dc2626; }
.rtd-select { cursor: pointer; }

.rtd-form-actions { display: flex; gap: 12px; justify-content: flex-end; }
.rtd-btn-primary { padding: 10px 20px; background: #0f172a; color: white; border: none; border-radius: 6px; font-weight: 500; cursor: pointer; transition: all 0.3s; }
.rtd-btn-primary:hover { background: #1e293b; }
.rtd-btn-secondary { padding: 10px 20px; background: #e2e8f0; color: #1e293b; border: none; border-radius: 6px; font-weight: 500; cursor: pointer; transition: all 0.3s; }
.rtd-btn-secondary:hover { background: #cbd5e1; }
</style>

<script>
const allowedTransitions = {
    'pending': ['in_progress'],
    'in_progress': ['completed'],
    'completed': []
};

const statusLabels = {
    'pending': 'Đang chờ xử lý',
    'in_progress': 'Đang sửa chữa',
    'completed': 'Đã hoàn thành'
};

const currentStatus = '{{ $repairTicket->status->value }}';
const statusSelect = document.getElementById('statusSelect');

const allowed = allowedTransitions[currentStatus] || [];
allowed.forEach(status => {
    const option = document.createElement('option');
    option.value = status;
    option.textContent = statusLabels[status];
    statusSelect.appendChild(option);
});
</script>
@endsection
