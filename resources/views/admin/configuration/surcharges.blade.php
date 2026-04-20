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
        <div class="surcharge-row">
            <div class="surcharge-time-input">
                <input type="text" class="surcharge-input" value="01:00" placeholder="00:00">
            </div>
            <div class="surcharge-currency-badge">VND</div>
            <div class="surcharge-amount-input">
                <input type="text" class="surcharge-input surcharge-input--amount" value="60,000">
            </div>
            <button class="surcharge-btn-del" onclick="removeSurchargeRow(this)">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="surcharge-row">
            <div class="surcharge-time-input">
                <input type="text" class="surcharge-input" value="02:00" placeholder="00:00">
            </div>
            <div class="surcharge-currency-badge">VND</div>
            <div class="surcharge-amount-input">
                <input type="text" class="surcharge-input surcharge-input--amount" value="120,000">
            </div>
            <button class="surcharge-btn-del" onclick="removeSurchargeRow(this)">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="surcharge-row">
            <div class="surcharge-time-input">
                <input type="text" class="surcharge-input" value="03:00" placeholder="00:00">
            </div>
            <div class="surcharge-currency-badge">VND</div>
            <div class="surcharge-amount-input">
                <input type="text" class="surcharge-input surcharge-input--amount" value="180,000">
            </div>
            <button class="surcharge-btn-del" onclick="removeSurchargeRow(this)">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="surcharge-row">
            <div class="surcharge-time-input">
                <input type="text" class="surcharge-input" value="04:00" placeholder="00:00">
            </div>
            <div class="surcharge-currency-badge">VND</div>
            <div class="surcharge-amount-input">
                <input type="text" class="surcharge-input surcharge-input--amount" value="240,000">
            </div>
            <button class="surcharge-btn-del" onclick="removeSurchargeRow(this)">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="surcharge-row">
            <div class="surcharge-time-input">
                <input type="text" class="surcharge-input" value="05:00" placeholder="00:00">
            </div>
            <div class="surcharge-currency-badge">VND</div>
            <div class="surcharge-amount-input">
                <input type="text" class="surcharge-input surcharge-input--amount" value="300,000">
            </div>
            <button class="surcharge-btn-del" onclick="removeSurchargeRow(this)">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
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
        <div class="surcharge-row">
            <div class="surcharge-time-input">
                <input type="text" class="surcharge-input" value="01:00" placeholder="00:00">
            </div>
            <div class="surcharge-currency-badge">VND</div>
            <div class="surcharge-amount-input">
                <input type="text" class="surcharge-input surcharge-input--amount" value="60,000">
            </div>
            <button class="surcharge-btn-del" onclick="removeSurchargeRow(this)">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="surcharge-row">
            <div class="surcharge-time-input">
                <input type="text" class="surcharge-input" value="02:00" placeholder="00:00">
            </div>
            <div class="surcharge-currency-badge">VND</div>
            <div class="surcharge-amount-input">
                <input type="text" class="surcharge-input surcharge-input--amount" value="120,000">
            </div>
            <button class="surcharge-btn-del" onclick="removeSurchargeRow(this)">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="surcharge-row">
            <div class="surcharge-time-input">
                <input type="text" class="surcharge-input" value="03:00" placeholder="00:00">
            </div>
            <div class="surcharge-currency-badge">VND</div>
            <div class="surcharge-amount-input">
                <input type="text" class="surcharge-input surcharge-input--amount" value="180,000">
            </div>
            <button class="surcharge-btn-del" onclick="removeSurchargeRow(this)">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="surcharge-row">
            <div class="surcharge-time-input">
                <input type="text" class="surcharge-input" value="04:00" placeholder="00:00">
            </div>
            <div class="surcharge-currency-badge">VND</div>
            <div class="surcharge-amount-input">
                <input type="text" class="surcharge-input surcharge-input--amount" value="240,000">
            </div>
            <button class="surcharge-btn-del" onclick="removeSurchargeRow(this)">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="surcharge-row">
            <div class="surcharge-time-input">
                <input type="text" class="surcharge-input" value="05:00" placeholder="00:00">
            </div>
            <div class="surcharge-currency-badge">VND</div>
            <div class="surcharge-amount-input">
                <input type="text" class="surcharge-input surcharge-input--amount" value="300,000">
            </div>
            <button class="surcharge-btn-del" onclick="removeSurchargeRow(this)">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function addSurchargeRow(listId) {
    const list = document.getElementById(listId);
    const rows = list.querySelectorAll('.surcharge-row');
    const lastRow = rows[rows.length - 1];

    // Calculate next time slot
    let nextTime = '00:00';
    if (lastRow) {
        const lastTimeVal = lastRow.querySelector('.surcharge-time-input input').value;
        const parts = lastTimeVal.split(':');
        let hours = parseInt(parts[0]) + 1;
        nextTime = String(hours).padStart(2, '0') + ':00';
    }

    const newRow = document.createElement('div');
    newRow.className = 'surcharge-row surcharge-row--new';
    newRow.innerHTML = `
        <div class="surcharge-time-input">
            <input type="text" class="surcharge-input" value="${nextTime}" placeholder="00:00">
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
</script>
@endpush
