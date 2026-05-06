{{-- ===== CARD 1: Early Check-in Fee ===== --}}
<div class="surcharge-card">
    <div class="surcharge-card-header">
        <div class="surcharge-card-title">
            <div class="surcharge-icon surcharge-icon--blue">
                {{-- Sparkle / early checkin icon --}}
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2z"/>
                    <polyline points="12 6 12 12 16 14"/>
                    <circle cx="12" cy="12" r="1" fill="currentColor"/>
                </svg>
            </div>
            <span>Phí check-in sớm</span>
        </div>
        <button class="surcharge-btn-add" onclick="addSurchargeRow('early-checkin-list')">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
        </button>
    </div>

    <div class="surcharge-list" id="early-checkin-list">
        @foreach($data['early_checkin_policies'] ?? [] as $policy)
        <div class="surcharge-row">
            <div class="surcharge-time-input">
                <input type="text" class="surcharge-input" value="{{ \App\Helpers\TimeHelper::formatHourMark($policy->hour_mark) }}" placeholder="VD: 1h30p">
            </div>
            <div class="surcharge-currency-badge">VND</div>
            <div class="surcharge-amount-input">
                <input type="text" class="surcharge-input surcharge-input--amount" value="{{ number_format($policy->price, 0, ',', '.') }}">
            </div>
            <button class="surcharge-btn-del" onclick="removeSurchargeRow(this)">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        @endforeach
    </div>
</div>

{{-- ===== CARD 2: Late Check-out Fee ===== --}}
<div class="surcharge-card">
    <div class="surcharge-card-header">
        <div class="surcharge-card-title">
            <div class="surcharge-icon surcharge-icon--green">
                {{-- Late checkout icon --}}
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21.5 2l-1.5 1.5M16.5 2a7 7 0 1 0 0 14 7 7 0 0 0 0-14zM22 22l-5-5"/>
                </svg>
            </div>
            <span>Phí checkout muộn</span>
        </div>
        <button class="surcharge-btn-add" onclick="addSurchargeRow('late-checkout-list')">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
        </button>
    </div>

    <div class="surcharge-list" id="late-checkout-list">
        @foreach($data['late_checkout_policies'] ?? [] as $policy)
        <div class="surcharge-row">
            <div class="surcharge-time-input">
                <input type="text" class="surcharge-input" value="{{ \App\Helpers\TimeHelper::formatHourMark($policy->hour_mark) }}" placeholder="VD: 1h30p">
            </div>
            <div class="surcharge-currency-badge">VND</div>
            <div class="surcharge-amount-input">
                <input type="text" class="surcharge-input surcharge-input--amount" value="{{ number_format($policy->price, 0, ',', '.') }}">
            </div>
            <button class="surcharge-btn-del" onclick="removeSurchargeRow(this)">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
function addSurchargeRow(listId) {
    const list = document.getElementById(listId);
    const rows = list.querySelectorAll('.surcharge-row');
    const lastRow = rows[rows.length - 1];

    // Calculate next time slot (format: 1h, 2h, 3h30p...)
    let nextTime = '1h';
    if (lastRow) {
        const lastTimeVal = lastRow.querySelector('.surcharge-time-input input').value;
        const timeMatch = lastTimeVal.match(/(\d+)h(?:(\d+)p)?/);
        if (timeMatch) {
            const hours = parseInt(timeMatch[1]);
            nextTime = (hours + 1) + 'h';
        }
    }

    const newRow = document.createElement('div');
    newRow.className = 'surcharge-row surcharge-row--new';
    newRow.innerHTML = `
        <div class="surcharge-time-input">
            <input type="text" class="surcharge-input" value="${nextTime}" placeholder="VD: 1h30p">
        </div>
        <div class="surcharge-currency-badge">VND</div>
        <div class="surcharge-amount-input">
            <input type="text" class="surcharge-input surcharge-input--amount" placeholder="Nhập số tiền">
        </div>
        <button class="surcharge-btn-del" onclick="removeSurchargeRow(this)">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    `;
    list.appendChild(newRow);

    // Animate in
    requestAnimationFrame(() => {
        newRow.classList.add('surcharge-row--visible');
    });
}

function removeSurchargeRow(btn) {
    const row = btn.closest('.surcharge-row');
    row.style.opacity = '0';
    row.style.transform = 'translateX(10px)';
    row.style.transition = 'all 0.25s ease';
    setTimeout(() => row.remove(), 250);
}

// Save surcharges
document.addEventListener('DOMContentLoaded', function() {
    const btnSave = document.querySelector('.btn-save-config');
    
    if (btnSave) {
        btnSave.addEventListener('click', function(e) {
            // Only proceed if surcharge list exists
            const earlyCheckinList = document.getElementById('early-checkin-list');
            if (!earlyCheckinList) return;

            e.preventDefault();
            
            const earlyCheckinPolicies = [];
            const lateCheckoutPolicies = [];

            // Parse early check-in policies
            document.querySelectorAll('#early-checkin-list .surcharge-row').forEach(row => {
                const time = row.querySelector('.surcharge-time-input input').value;
                const price = row.querySelector('.surcharge-amount-input input').value.replace(/[.,]/g, '');
                
                if (time && price) {
                    earlyCheckinPolicies.push({
                        hour_mark: time,  // Send as string "1h30p", controller will parse
                        price: parseInt(price)
                    });
                }
            });

            // Parse late checkout policies
            document.querySelectorAll('#late-checkout-list .surcharge-row').forEach(row => {
                const time = row.querySelector('.surcharge-time-input input').value;
                const price = row.querySelector('.surcharge-amount-input input').value.replace(/[.,]/g, '');
                
                if (time && price) {
                    lateCheckoutPolicies.push({
                        hour_mark: time,  // Send as string "1h30p", controller will parse
                        price: parseInt(price)
                    });
                }
            });

            const formData = {
                early_checkin_policies: earlyCheckinPolicies,
                late_checkout_policies: lateCheckoutPolicies,
            };

            fetch('{{ route("admin.configuration.update-surcharges") }}', {
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
