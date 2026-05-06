@extends('admin.layouts.master')

@section('title', 'Quản lý phiếu sửa chữa | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/repair-ticket.css')
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
        <div style="flex:1; overflow-y:auto; padding:32px; display:flex; flex-direction:column; background:#f8fafc;">
            
            <div class="rp-container">
                <div class="rp-header">
                    <div>
                        <h1 class="rp-title">Quản lý phiếu sửa chữa</h1>
                        <p class="rp-subtitle">Hệ thống quản trị khách sạn Urban Luxe - Quản lý phiếu sửa chữa thiết bị.</p>
                    </div>
                    <a href="{{ route('admin.repair-ticket.create') }}" class="rp-btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Tạo phiếu sửa chữa mới
                    </a>
                </div>

                <div class="rp-toolbar">
                    <form method="GET" action="{{ route('admin.repair-ticket.index') }}" style="display: flex; align-items: center; gap: 12px; flex: 1;">
                        <div class="rp-search-wrapper">
                            <div class="rp-search-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            </div>
                            <input type="text" name="filter[search]" class="rp-search-input" placeholder="Tìm mô tả vấn đề..." value="{{ request('filter.search') }}" onkeyup="if(event.key==='Enter') this.form.submit();">
                        </div>
                        
                        <select class="rp-select" name="filter[status]" onchange="this.form.submit();">
                            <option value="">Trạng thái (Tất cả)</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->value }}" {{ request('filter.status') == $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>

                        <select class="rp-select" name="filter[room_id]" onchange="this.form.submit();">
                            <option value="">Phòng (Tất cả)</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ request('filter.room_id') == $room->id ? 'selected' : '' }}>
                                    Phòng {{ $room->name }}
                                </option>
                            @endforeach
                        </select>

                        <button class="rp-btn-action" type="button" style="color: #94a3b8;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        </button>
                    </form>
                </div>

                <div class="rp-table-wrapper">
                    <table class="rp-table">
                        <thead>
                            <tr>
                                <th>PHÒNG</th>
                                <th>MÔ TẢ VẤN ĐỀ</th>
                                <th>TRẠNG THÁI</th>

                                <th>NGÀY TẠO</th>
                                <th style="text-align: right;">THAO TÁC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($repairTickets as $ticket)
                            <tr>
                                <td class="rp-room">
                                    <strong>Phòng {{ $ticket->room->name }}</strong>
                                    <br>
                                    <small style="color: #6b7280;">{{ $ticket->room->roomType->name }}</small>
                                </td>
                                <td class="rp-issue">{{ Str::limit($ticket->issue_description, 50) }}</td>
                                <td>
                                    <span class="rp-status-badge rp-status-{{ $ticket->status->value }}">
                                        {{ $ticket->status->label() }}
                                    </span>
                                </td>
                                <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="rp-actions">
                                        <a href="{{ route('admin.repair-ticket.show', $ticket->id) }}" class="rp-btn-action view" title="Xem chi tiết">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        </a>
                                        @if($ticket->status->value !== 'completed')
                                            <button type="button" class="rp-btn-action edit" title="Cập nhật trạng thái" onclick="openStatusModal({{ $ticket->id }}, '{{ $ticket->status->value }}')">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px 20px; color: #6b7280;">
                                    <p>Không có phiếu sửa chữa nào</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($repairTickets->hasPages())
                <div class="rp-footer">
                    <div class="rp-pagination">
                        {{ $repairTickets->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- FOOTER --}}
        @include('admin.layouts.footer')

    </main>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="rp-modal" style="display:none;">
    <div class="rp-modal-content">
        <div class="rp-modal-header">
            <h2>Cập nhật trạng thái</h2>
            <button type="button" class="rp-modal-close" onclick="closeStatusModal()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <form id="statusForm" method="POST">
            @csrf
            @method('PATCH')
            
            <div class="rp-modal-body">
                <div class="rp-form-group">
                    <label class="rp-label">Trạng thái mới</label>
                    <select name="status" id="statusSelect" class="rp-input rp-select" required>
                        <option value="">Chọn trạng thái...</option>
                    </select>
                    <small id="statusError" style="color: #dc2626; display:none;"></small>
                </div>

                <div class="rp-form-group">
                    <label class="rp-label">Ghi chú</label>
                    <textarea name="notes" class="rp-input" rows="4" placeholder="Thêm ghi chú..."></textarea>
                </div>
            </div>

            <div class="rp-modal-footer">
                <button type="button" class="rp-btn-secondary" onclick="closeStatusModal()">Hủy</button>
                <button type="submit" class="rp-btn-primary">Cập nhật</button>
            </div>
        </form>
    </div>
</div>

<style>
.rp-modal { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000; }
.rp-modal-content { background: white; border-radius: 8px; width: 90%; max-width: 500px; }
.rp-modal-header { padding: 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
.rp-modal-header h2 { margin: 0; font-size: 18px; font-weight: 600; }
.rp-modal-close { background: none; border: none; cursor: pointer; color: #64748b; }
.rp-modal-body { padding: 20px; }
.rp-form-group { margin-bottom: 16px; }
.rp-label { display: block; margin-bottom: 8px; font-size: 14px; font-weight: 500; color: #1e293b; }
.rp-input { width: 100%; padding: 10px 12px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 14px; font-family: inherit; }
.rp-modal-footer { padding: 20px; border-top: 1px solid #e2e8f0; display: flex; gap: 12px; justify-content: flex-end; }
.rp-btn-secondary { padding: 10px 16px; background: #e2e8f0; color: #1e293b; border: none; border-radius: 6px; font-weight: 500; cursor: pointer; }
.rp-btn-secondary:hover { background: #cbd5e1; }
.rp-status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; }
.rp-status-pending { background: #fef3c7; color: #92400e; }
.rp-status-in_progress { background: #dbeafe; color: #1e40af; }
.rp-status-completed { background: #dcfce7; color: #166534; }
.rp-room { font-weight: 500; }
.rp-issue { max-width: 300px; color: #475569; }
.rp-actions { display: flex; gap: 8px; }
.rp-btn-action { padding: 6px; background: none; border: none; cursor: pointer; color: #64748b; transition: all 0.3s; }
.rp-btn-action:hover { color: #1e293b; }
.rp-btn-action.edit:hover { color: #3b82f6; }
.rp-btn-action.view:hover { color: #10b981; }
.rp-btn-primary { padding: 10px 16px; background: #1e3a8a; color: white; border: 1px solid #1e40af; border-radius: 6px; font-weight: 500; cursor: pointer; box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3); transition: all 0.3s; }
.rp-btn-primary:hover { background: #1e40af; box-shadow: 0 6px 16px rgba(30, 58, 138, 0.4); }
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

function openStatusModal(ticketId, currentStatus) {
    const form = document.getElementById('statusForm');
    form.action = `/admin/repair-ticket/${ticketId}/status`;
    
    const statusSelect = document.getElementById('statusSelect');
    statusSelect.innerHTML = '<option value="">Chọn trạng thái...</option>';
    
    const allowed = allowedTransitions[currentStatus] || [];
    allowed.forEach(status => {
        const option = document.createElement('option');
        option.value = status;
        option.textContent = statusLabels[status];
        statusSelect.appendChild(option);
    });
    
    document.getElementById('statusModal').style.display = 'flex';
}

function closeStatusModal() {
    document.getElementById('statusModal').style.display = 'none';
    document.getElementById('statusForm').reset();
}

document.getElementById('statusForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const statusSelect = document.getElementById('statusSelect');
    if (!statusSelect.value) {
        document.getElementById('statusError').textContent = 'Vui lòng chọn trạng thái mới';
        document.getElementById('statusError').style.display = 'block';
        return;
    }
    
    this.submit();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeStatusModal();
    }
});
</script>
@endsection
