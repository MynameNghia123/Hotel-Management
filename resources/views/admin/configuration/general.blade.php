{{-- ===== CARD: Check-in / Check-out Time ===== --}}
<div class="general-card">
    <div class="general-field">
        <label class="general-label">Thời gian nhận / trả phòng trong ngày</label>
        <div class="general-time-range">
            <input type="time" class="general-time-input" value="{{ $data['check_in_time'] ?? '14:00' }}" id="checkin-time">
            <div class="general-time-arrow">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </div>
            <input type="time" class="general-time-input" value="{{ $data['check_out_time'] ?? '12:00' }}" id="checkout-time">
        </div>
    </div>

    <div class="general-field">
        <label class="general-label">Số phút làm tròn 1 giờ</label>
        <input type="number" class="general-number-input" value="{{ $data['round_minutes'] ?? 15 }}" min="0" max="59" id="round-minutes">
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnSave = document.querySelector('.btn-save-config');
        
        if (btnSave) {
            btnSave.addEventListener('click', function(e) {
                // Only proceed if general configuration inputs exist
                const checkinInput = document.getElementById('checkin-time');
                if (!checkinInput) return;

                e.preventDefault();
                
                const formData = {
                    check_in_time: document.getElementById('checkin-time').value,
                    check_out_time: document.getElementById('checkout-time').value,
                    round_minutes: document.getElementById('round-minutes').value,
                };

                fetch('{{ route("admin.configuration.update-general") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify(formData),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Lỗi: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Đã xảy ra lỗi khi lưu!');
                });
            });
        }
    });
</script>
@endpush
