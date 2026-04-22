@extends('admin.layouts.master')
@section('title', 'Tạo đặt phòng mới | Urban Luxe')

@section('content')
<div style="display:flex; height:100vh; background:#f8fafc; overflow:hidden;">

    @include('admin.layouts.sidebar')

    <main style="flex:1; display:flex; flex-direction:column;">

        {{-- HEADER CHUNG --}}
        <header style="height:64px; background:#fff; border-bottom:1px solid #f1f3f7; padding:0 32px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:8px; font-size:14px; font-weight:600; color:#1e293b;">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                16819 · Urban Luxe Hotel
            </div>
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="text-align:right;">
                    <div style="font-size:13px; font-weight:700; color:#1e293b;">Admin Đức</div>
                    <div style="font-size:11px; color:#94a3b8;">Quản lý cấp cao</div>
                </div>
                <img src="https://ui-avatars.com/api/?name=Admin+Duc&background=2a3f8a&color=fff" style="width:36px; height:36px; border-radius:50%;">
            </div>
        </header>

        {{-- MAIN CONTENT --}}
        <div style="flex:1; overflow-y:auto; padding:24px 32px;">
            {{-- Back Link --}}
            <a href="{{ route('admin.bookings.index') }}" class="bc-back-link" style="display:inline-flex; align-items:center; gap:6px; color:#2a3f8a; text-decoration:none; font-size:13px; font-weight:600; margin-bottom:20px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                Trở lại
            </a>

            {{-- Page Title --}}
            <h1 style="font-size:28px; font-weight:900; color:#0f172a; margin:0 0 32px 0;">Tạo đặt phòng mới</h1>

            {{-- Main Form Container with Sidebar --}}
            <div style="display:flex; gap:32px; max-width:1400px;">
                {{-- LEFT COLUMN: FORM --}}
                <div style="flex:1; min-width:0;">
                <form method="POST" action="{{ route('admin.bookings.store') }}" id="bookingForm">
                    @csrf

                    {{-- SECTION 1: THÔNG TIN KHÁCH HÀNG --}}
                    <div class="bc-card">
                        <div class="bc-card-title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Thông tin khách hàng
                        </div>

                        {{-- EMAIL VERIFICATION SECTION --}}
                        <div class="bc-form-group">
                            <label class="bc-label">Email khách hàng</label>
                            <div class="bc-email-input-row">
                                <input type="email" id="customerEmail" class="bc-input" placeholder="new.guest@gmail.com" style="flex:1;">
                                <button type="button" class="bc-btn-verify" onclick="verifyCustomerEmail()">Xác thực</button>
                            </div>
                            <small style="color:#94a3b8; font-size:11px; margin-top:4px;">Khách hàng mới sẽ được tạo tạo tài khoản.</small>
                        </div>

                        {{-- VERIFY RESULT AREA --}}
                        <div id="verifyResult" style="display:none; margin-bottom:16px;">
                            {{-- ERROR MESSAGE (Email not in system) --}}
                            <div id="emailError" style="display:none; padding:12px 14px; background:#fef2f2; border:1px solid #fee2e2; border-radius:8px; margin-bottom:16px;">
                                <div style="display:flex; align-items:flex-start; gap:10px;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5" style="margin-top:2px; flex-shrink:0;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    <div style="font-size:12px; color:#dc2626;">
                                        <div style="font-weight:700;">Email chưa có trong hệ thống</div>
                                        <div style="font-weight:500; margin-top:2px;">Vui lòng nhập thông tin khách hàng mới bên dưới.</div>
                                    </div>
                                </div>
                            </div>

                            {{-- SUCCESS MESSAGE (Email exists) --}}
                            <div id="emailSuccess" style="display:none; padding:12px 14px; background:#f0fdf4; border:2px solid #22c55e; border-radius:8px; margin-bottom:16px;">
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="3" style="flex-shrink:0;"><polyline points="20 6 9 17 4 12"/></svg>
                                    <div>
                                        <div style="font-size:13px; font-weight:700; color:#15803d;">Chào mừng quay trở lại, <span id="customerNameDisplay"></span>!</div>
                                        <div style="font-size:11px; color:#16a34a; font-weight:500; margin-top:2px;">Thông tin khách hàng đã được tải.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- NEW CUSTOMER FORM (Hidden by default) --}}
                        <div id="newCustomerFormSection" style="display:none; padding:16px; background:#f8fafc; border-radius:8px; border:1px solid #e2e8f0;">
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                                <div class="bc-form-group">
                                    <label class="bc-label">Họ</label>
                                    <input type="text" id="customerLastName" name="customer_last_name" class="bc-input" placeholder="Nhập họ khách hàng" value="{{ old('customer_last_name') }}">
                                    @error('customer_last_name')
                                        <span style="color:#ef4444; font-size:12px;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="bc-form-group">
                                    <label class="bc-label">Email liên hệ</label>
                                    <input type="email" id="customerNewEmail" name="customer_new_email" class="bc-input" placeholder="email@example.com" readonly>
                                </div>
                            </div>

                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                                <div class="bc-form-group">
                                    <label class="bc-label">Tên</label>
                                    <input type="text" id="customerFirstName" name="customer_first_name" class="bc-input" placeholder="Nhập tên khách hàng" value="{{ old('customer_first_name') }}">
                                    @error('customer_first_name')
                                        <span style="color:#ef4444; font-size:12px;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="bc-form-group">
                                    <label class="bc-label">ID tài khoản</label>
                                    <input type="text" id="customerAccountId" name="customer_account_id" class="bc-input" placeholder="VD: ACC-1234" value="{{ old('customer_account_id') }}">
                                </div>
                            </div>

                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                                <div class="bc-form-group">
                                    <label class="bc-label">Số điện thoại</label>
                                    <input type="text" id="customerPhone" name="customer_phone" class="bc-input" placeholder="VD: 0901234567" value="{{ old('customer_phone') }}">
                                    @error('customer_phone')
                                        <span style="color:#ef4444; font-size:12px;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="bc-form-group">
                                    <label class="bc-label">Quốc gia</label>
                                    <input type="text" id="customerCountry" name="customer_country" class="bc-input" placeholder="VD: Việt Nam" value="{{ old('customer_country') }}">
                                </div>
                            </div>
                        </div>

                        {{-- HIDDEN CUSTOMER ID FOR EXISTING CUSTOMER --}}
                        <input type="hidden" id="selectedCustomerId" name="customer_id" value="">

                        {{-- Check-in/Check-out dates --}}
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                            <div class="bc-form-group">
                                <label class="bc-label">Ngày nhận phòng (Check-in)</label>
                                <input type="date" id="checkinDate" class="bc-input" value="{{ old('checkin_date', today()->toDateString()) }}">
                            </div>
                            <div class="bc-form-group">
                                <label class="bc-label">Ngày trả phòng (Check-out)</label>
                                <input type="date" id="checkoutDate" class="bc-input" value="{{ old('checkout_date', today()->addDay()->toDateString()) }}">
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 2: CHỌN PHÒNG LƯU TRÚ --}}
                    <div class="bc-card">
                        <div class="bc-card-title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                            Chọn phòng lưu trú
                        </div>

                        <div id="roomListContainer" class="bc-room-list">
                            {{-- Rooms will be added here --}}
                        </div>

                        <button type="button" class="bc-btn-secondary" onclick="openRoomModal()" style="margin-top: 16px;">+ Thêm phòng</button>
                    </div>
<!-- 
                    {{-- SECTION 3: CHI TIẾT THANH TOÁN --}}
                    <div class="bc-card">
                        <div class="bc-card-title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                            Chi tiết thanh toán
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div class="bc-form-group">
                                <label class="bc-label">Tổng tiền phòng</label>
                                <input type="number" name="total_room_amount" class="bc-input" placeholder="0" value="{{ old('total_room_amount', 0) }}" min="0">
                            </div>
                            <div class="bc-form-group">
                                <label class="bc-label">Phí dịch vụ</label>
                                <input type="number" name="total_service_amount" class="bc-input" placeholder="0" value="{{ old('total_service_amount', 0) }}" min="0">
                            </div>
                            <div class="bc-form-group">
                                <label class="bc-label">Phụ phí bổ sung</label>
                                <input type="number" name="surcharge_amount" class="bc-input" placeholder="0" value="{{ old('surcharge_amount', 0) }}" min="0">
                            </div>
                            <div class="bc-form-group">
                                <label class="bc-label">Tổng cộng</label>
                                <input type="number" name="final_amount" class="bc-input" placeholder="0" value="{{ old('final_amount', 0) }}" min="0">
                            </div>
                        </div>
                    </div> -->

                    {{-- HIDDEN ROOM IDS ARRAY --}}
                    <input type="hidden" id="roomIds" name="room_ids" value="">
                    <input type="hidden" id="checkinDates" name="checkin_dates" value="">
                    <input type="hidden" id="checkoutDates" name="checkout_dates" value="">
                </form>
                </div>

                {{-- RIGHT COLUMN: PAYMENT SUMMARY SIDEBAR --}}
                <div style="width:380px; position:sticky; top:24px; height:fit-content;">
                    <div class="bc-card" style="margin-bottom:0;">
                        <div class="bc-card-title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                            Chi tiết thanh toán
                        </div>

                        {{-- Room Items List --}}
                        <div id="paymentRoomsList" style="max-height:300px; overflow-y:auto; margin-bottom:16px; padding-bottom:16px; border-bottom:2px solid var(--border-color);">
                            <div style="text-align:center; color:#94a3b8; font-size:12px; padding:12px;">Chưa có phòng nào</div>
                        </div>

                        {{-- Breakdown Lines --}}
                        <div style="display:flex; flex-direction:column; gap:12px; margin-bottom:16px; padding-bottom:16px; border-bottom:2px solid var(--border-color);">
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <span style="font-size:13px; color:#64748b;">Tổng tiền phòng</span>
                                <span style="font-size:13px; font-weight:600; color:#0f172a;" id="sidebarRoomAmount">0 đ</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <span style="font-size:13px; color:#64748b;">Phí dịch vụ</span>
                                <span style="font-size:13px; font-weight:600; color:#0f172a;" id="sidebarServiceAmount">0 đ</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <span style="font-size:13px; color:#64748b;">Phụ phí bổ sung</span>
                                <span style="font-size:13px; font-weight:600; color:#0f172a;" id="sidebarSurchargeAmount">0 đ</span>
                            </div>
                        </div>

                        {{-- Total Amount --}}
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; padding-bottom:16px; border-bottom:2px solid var(--border-color);">
                            <span style="font-size:14px; font-weight:700; color:#0f172a;">TỔNG CỘNG</span>
                            <span style="font-size:24px; font-weight:900; color:#2a3f8a;" id="sidebarTotalAmount">0 đ</span>
                        </div>

                        {{-- Buttons --}}
                        <div style="display:flex; flex-direction:column; gap:8px;">
                            <button type="submit" form="bookingForm" class="bc-btn-confirm" style="width:100%; padding:12px;">Xác nhận đặt phòng</button>
                            <button type="button" onclick="window.location.href='{{ route('admin.bookings.index') }}'" class="bc-btn-cancel" style="width:100%; padding:12px;">Hủy bỏ</button>
                        </div>
                    </div>
                </div>
            </div>
    </main>
</div>

{{-- MODAL CHỌN PHÒNG --}}
<div id="roomModal" class="bc-modal-overlay" style="display: none;">
    <div class="bc-modal">
        <div class="bc-modal-header">
            <div>
                <h2 class="bc-modal-title">Chọn phòng trống</h2>
                <p class="bc-modal-subtitle">
                    Sắp xếp từ thấp đến cao &nbsp;·&nbsp;
                    <span id="roomCountBadge" style="font-weight:700; color:#2a3f8a;">{{ $rooms->count() }} phòng</span>
                </p>
            </div>
            <button type="button" class="bc-modal-close" onclick="closeRoomModal()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        {{-- SEARCH SECTION --}}
        <div style="padding:14px 20px; border-bottom:1px solid var(--border-color); background:#f8fafc;">
            <div style="position:relative; display:flex; align-items:center;">
                {{-- Search icon --}}
                <svg style="position:absolute; left:12px; color:#94a3b8; pointer-events:none; flex-shrink:0;"
                     width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="roomSearchInput" class="bc-input"
                       placeholder="Nhập số phòng (101, 202...) hoặc loại phòng..."
                       style="width:100%; padding:10px 36px 10px 36px;"
                       oninput="filterRooms()">
                {{-- Clear button --}}
                <button type="button" id="roomSearchClear"
                        onclick="clearRoomSearch()"
                        style="position:absolute; right:10px; background:none; border:none; cursor:pointer; color:#94a3b8; display:none; padding:4px; line-height:1;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center; margin-top:6px;">
                <small style="color:#94a3b8; font-size:11px;">Tìm theo số phòng hoặc loại phòng</small>
                <small id="roomSearchResult" style="color:#64748b; font-size:11px; font-weight:600;"></small>
            </div>
        </div>

        <div class="bc-modal-body">
            <div id="roomGridContainer" class="bc-room-grid-modal">
                @forelse ($rooms as $room)
                    <div class="bc-room-card-select" onclick="toggleRoomSelection(this, {{ $room->id }}, '{{ $room->name }}')" 
                         data-room-number="{{ $room->name }}" 
                         data-room-type="{{ $room->roomType->name ?? '' }}" 
                         data-room-floor="{{ $room->floor->name ?? '' }}">
                        <span class="bc-rcs-num">{{ $room->name }}</span>
                        <span class="bc-rcs-type">{{ $room->roomType->name ?? 'N/A' }}</span>
                        <span class="bc-rcs-price">{{ number_format($room->roomType->daily_price ?? 0, 0, ',', '.') }} đ</span>
                        <div class="bc-rcs-check">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                    </div>
                @empty
                    <p style="text-align: center; color: #94a3b8; padding: 40px; grid-column: 1/-1;">Không có phòng nào</p>
                @endforelse
            </div>
            <div id="noResultsMessage" style="display:none; text-align: center; color: #94a3b8; padding: 40px; grid-column: 1/-1;">
                <p style="font-size:14px; font-weight:600; margin-bottom:8px;">Không tìm thấy phòng phù hợp</p>
                <p style="font-size:12px;">Vui lòng thử tìm kiếm với từ khóa khác</p>
            </div>
        </div>

        <div class="bc-modal-footer">
            <button type="button" class="bc-btn-modal-cancel" onclick="closeRoomModal()">Hủy</button>
            <button type="button" class="bc-btn-modal-confirm" onclick="confirmRoomSelection()">Xác nhận</button>
        </div>
    </div>
</div>

<script>
    let selectedRooms = new Set();

    function verifyCustomerEmail() {
        const email = document.getElementById('customerEmail').value.trim();
        const verifyResult = document.getElementById('verifyResult');
        const emailError = document.getElementById('emailError');
        const emailSuccess = document.getElementById('emailSuccess');
        const newCustomerForm = document.getElementById('newCustomerFormSection');
        const selectedCustomerId = document.getElementById('selectedCustomerId');
        const customerNewEmail = document.getElementById('customerNewEmail');

        if (!email) {
            alert('Vui lòng nhập email');
            return;
        }

        // API call to verify email
        fetch(`/api/bookings/verify-customer`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            verifyResult.style.display = 'block';
            
            if (data.exists) {
                // Customer exists
                emailSuccess.style.display = 'block';
                emailError.style.display = 'none';
                newCustomerForm.style.display = 'none';
                document.getElementById('customerNameDisplay').textContent = data.customer.name;
                selectedCustomerId.value = data.customer.id;
            } else {
                // Customer doesn't exist
                emailError.style.display = 'block';
                emailSuccess.style.display = 'none';
                newCustomerForm.style.display = 'block';
                customerNewEmail.value = email;
                selectedCustomerId.value = '';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Lỗi khi xác thực email');
        });
    }

    // Allow Enter key to verify
    document.getElementById('customerEmail').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            verifyCustomerEmail();
        }
    });

    function openRoomModal() {
        document.getElementById('roomModal').style.display = 'flex';
        // Reset search when opening modal
        document.getElementById('roomSearchInput').value = '';
        filterRooms();
    }

    function closeRoomModal() {
        document.getElementById('roomModal').style.display = 'none';
    }

    function filterRooms() {
        const raw = document.getElementById('roomSearchInput').value;
        const searchInput = raw.toLowerCase().trim();
        const roomCards = document.querySelectorAll('.bc-room-card-select');
        const noResultsMessage = document.getElementById('noResultsMessage');
        const totalRooms = roomCards.length;
        let visibleCount = 0;

        // Show/hide clear button
        const clearBtn = document.getElementById('roomSearchClear');
        if (clearBtn) clearBtn.style.display = raw.length > 0 ? 'block' : 'none';

        roomCards.forEach(card => {
            const roomNumber = card.getAttribute('data-room-number').toLowerCase();
            const roomType   = card.getAttribute('data-room-type').toLowerCase();
            const roomFloor  = card.getAttribute('data-room-floor').toLowerCase();

            const matches = searchInput === '' ||
                            roomNumber.includes(searchInput) ||
                            roomType.includes(searchInput) ||
                            roomFloor.includes(searchInput);

            card.style.display = matches ? '' : 'none';
            if (matches) visibleCount++;
        });

        // Update counter badge
        const badge = document.getElementById('roomCountBadge');
        const result = document.getElementById('roomSearchResult');
        if (searchInput === '') {
            if (badge) badge.textContent = totalRooms + ' phòng';
            if (result) result.textContent = '';
        } else {
            if (badge) badge.textContent = visibleCount + '/' + totalRooms + ' phòng';
            if (result) result.textContent = 'Tìm thấy ' + visibleCount + ' kết quả';
        }

        // Show/hide no results message
        noResultsMessage.style.display = visibleCount === 0 ? 'block' : 'none';
    }

    function clearRoomSearch() {
        const input = document.getElementById('roomSearchInput');
        input.value = '';
        input.focus();
        filterRooms();
    }

    function toggleRoomSelection(element, roomId, roomNumber) {
        element.classList.toggle('is-selected');
        if (element.classList.contains('is-selected')) {
            selectedRooms.add(roomId);
        } else {
            selectedRooms.delete(roomId);
        }
    }

    function confirmRoomSelection() {
        const roomIds = Array.from(selectedRooms);
        const checkinDate = document.getElementById('checkinDate').value;
        const checkoutDate = document.getElementById('checkoutDate').value;
        
        if (!checkinDate || !checkoutDate) {
            alert('Vui lòng nhập ngày nhận phòng và ngày trả phòng');
            return;
        }
        
        if (new Date(checkinDate) >= new Date(checkoutDate)) {
            alert('Ngày trả phòng phải sau ngày nhận phòng');
            return;
        }
        
        // Build arrays for each room with same dates (can be customized per room later)
        const checkinDates = Array(roomIds.length).fill(checkinDate);
        const checkoutDates = Array(roomIds.length).fill(checkoutDate);
        
        document.getElementById('roomIds').value = JSON.stringify(roomIds);
        document.getElementById('checkinDates').value = JSON.stringify(checkinDates);
        document.getElementById('checkoutDates').value = JSON.stringify(checkoutDates);
        
        // Update room list display (left column)
        const container = document.getElementById('roomListContainer');
        container.innerHTML = '';
        
        // Update payment sidebar
        const paymentRoomsList = document.getElementById('paymentRoomsList');
        paymentRoomsList.innerHTML = '';
        
        const roomElements = document.querySelectorAll('.bc-room-card-select.is-selected');
        roomElements.forEach((el, index) => {
            const roomNum = el.querySelector('.bc-rcs-num').textContent;
            const roomType = el.querySelector('.bc-rcs-type').textContent;
            const roomPrice = el.querySelector('.bc-rcs-price').textContent;
            
            // Left column: room item
            container.innerHTML += `
                <div class="bc-room-item">
                    <div class="bc-room-num-badge">${roomNum}</div>
                    <div class="bc-room-info">
                        <div class="bc-room-name">${roomType}</div>
                        <div class="bc-room-detail">${checkinDate} - ${checkoutDate}</div>
                    </div>
                </div>
            `;
            
            // Right column: payment item
            paymentRoomsList.innerHTML += `
                <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; font-size:12px; color:#64748b;">
                    <span>${roomType} (x${Math.ceil((new Date(checkoutDate) - new Date(checkinDate)) / (1000 * 60 * 60 * 24))} đêm)</span>
                    <span style="color:#0f172a; font-weight:600;">${roomPrice}</span>
                </div>
            `;
        });
        
        // Update payment totals
        updatePaymentSummary();
        
        closeRoomModal();
    }
    
    function updatePaymentSummary() {
        const totalRoomAmount = parseFloat(document.querySelector('input[name="total_room_amount"]').value) || 0;
        const totalServiceAmount = parseFloat(document.querySelector('input[name="total_service_amount"]').value) || 0;
        const surchargeAmount = parseFloat(document.querySelector('input[name="surcharge_amount"]').value) || 0;
        const finalAmount = totalRoomAmount + totalServiceAmount + surchargeAmount;
        
        // Format currency VND
        const formatVND = (value) => {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value).replace('₫', 'đ').trim();
        };
        
        document.getElementById('sidebarRoomAmount').textContent = formatVND(totalRoomAmount);
        document.getElementById('sidebarServiceAmount').textContent = formatVND(totalServiceAmount);
        document.getElementById('sidebarSurchargeAmount').textContent = formatVND(surchargeAmount);
        document.getElementById('sidebarTotalAmount').textContent = formatVND(finalAmount);
        
        // Update final_amount field
        document.querySelector('input[name="final_amount"]').value = finalAmount;
    }
    
    // Listen to payment input changes
    ['total_room_amount', 'total_service_amount', 'surcharge_amount'].forEach(fieldName => {
        const field = document.querySelector(`input[name="${fieldName}"]`);
        if (field) {
            field.addEventListener('input', updatePaymentSummary);
        }
    });
</script>

@vite(['resources/css/admin/booking-create.css'])
@endsection