@extends('client.layouts.master')
@section('title', 'Thông Tin Khách Hàng | Urban Luxe Hotel')

@push('styles')
@vite(['resources/css/client/checkout.css'])
@endpush

@section('content')
<main class="guest-info-page">
    <!-- Header Section -->
    <header class="guest-header" style="background-image: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), url('{{ asset('img/backgroundhomepage.png') }}');">
        <div class="container">
            <span class="step-indicator">• BƯỚC 2 TRÊN 3</span>
            <h1>Thông tin khách hàng</h1>
            <p>Vui lòng hoàn tất thông tin cá nhân để hoàn tất việc giữ chỗ.</p>
        </div>
    </header>

    @if(session('error'))
        <div style="max-width: 1200px; margin: 20px auto; padding: 15px; background-color: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #ef4444; border-radius: 8px;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
        @csrf
        <input type="hidden" name="customer_id" id="detected_customer_id" value="{{ old('customer_id') }}">
        <div class="guest-content-grid">
            <!-- Left: Details Form -->
            <div class="details-column">
                <div class="details-form-card">
                    <div class="card-title">
                        Nhập thông tin của bạn
                        <span class="required-note">Các trường có dấu (*) là bắt buộc</span>
                    </div>

                    @if(!$user)
                    <!-- Verify Email section -->
                    <div class="verify-email-box">
                        <label class="verify-label">Bạn đã có tài khoản?</label>
                        <p class="verify-note" style="color: #64748b; margin-top: 5px;">
                            <a href="{{ route('login') }}" style="color: #2563eb; text-decoration: underline;">Đăng nhập ngay</a>
                        </p>
                    </div>
                    @endif

                    <div class="form-group-full" style="margin-top: 15px;">
                        <label>ĐỊA CHỈ EMAIL <span>*</span></label>
                        <input type="email" id="checkout_email" name="email" value="{{ old('email', $user ? $user->email : '') }}" placeholder="email@example.com" class="form-control-custom" required {{ $user ? 'readonly' : '' }}>
                        @if(!$user)
                            <div id="customer-lookup-status" class="customer-lookup-status" hidden></div>
                        @endif
                    </div>

                    @php
                        $showCustomerDetails = $user
                            || old('customer_id')
                            || old('first_name')
                            || old('last_name')
                            || old('phone')
                            || old('country');
                    @endphp
                    <div id="customer-details-section" class="customer-details-section" {{ $showCustomerDetails ? '' : 'hidden' }}>
                        <!-- Personal Info Form -->
                        <div class="form-row" style="margin-top: 15px;">
                            <div class="form-col">
                                <label>HỌ <span>*</span></label>
                                <input type="text" id="checkout_last_name" name="last_name" value="{{ old('last_name', $user ? $user->last_name : '') }}" placeholder="VD: Nguyễn" class="form-control-custom" {{ $user ? 'required readonly' : '' }}>
                            </div>
                            <div class="form-col">
                                <label>TÊN <span>*</span></label>
                                <input type="text" id="checkout_first_name" name="first_name" value="{{ old('first_name', $user ? $user->first_name : '') }}" placeholder="VD: Văn An" class="form-control-custom" {{ $user ? 'required readonly' : '' }}>
                            </div>
                        </div>

                        <div class="form-group-full" style="margin-top: 15px;">
                            <label>SỐ ĐIỆN THOẠI <span>*</span></label>
                            <input type="text" id="checkout_phone" name="phone" value="{{ old('phone', $user ? $user->phone_number : '') }}" placeholder="Nhập số điện thoại của bạn" class="form-control-custom" {{ $user ? 'required readonly' : '' }}>
                        </div>

                        <div class="form-group-full" style="margin-top: 15px;">
                            <label>QUỐC GIA</label>
                            <input type="text" id="checkout_country" name="country" value="{{ old('country', $user ? $user->country : '') }}" placeholder="VD: Viet Nam" class="form-control-custom" {{ $user ? 'readonly' : '' }}>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right: Stay Summary (Sticky) -->
            <aside class="summary-column">
                <div class="stay-summary-card">
                    <div class="summary-header">
                        <span class="summary-title">Tóm tắt kỳ nghỉ</span>
                        <a href="{{ route('search') }}" class="link-edit">Chỉnh sửa</a>
                    </div>

                    <!-- Selected Rooms List -->
                    <div class="summary-rooms-list">
                        @foreach($roomDetails as $detail)
                        <div class="summary-room-item">
                            @php
                                $imageUrl = '/img/room-deluxe.png';
                                $primaryImagePath = $detail['roomType']->images
                                    ?->pluck('image_url')
                                    ->map(fn ($path) => is_string($path) ? trim($path) : '')
                                    ->filter(function ($path) {
                                        if ($path === '') {
                                            return false;
                                        }

                                        if (filter_var($path, FILTER_VALIDATE_URL)) {
                                            return true;
                                        }

                                        return file_exists(public_path(ltrim($path, '/')));
                                    })
                                    ->first();

                                if ($primaryImagePath) {
                                    $imageUrl = filter_var($primaryImagePath, FILTER_VALIDATE_URL)
                                        ? $primaryImagePath
                                        : '/' . ltrim($primaryImagePath, '/');
                                }
                            @endphp
                            <img src="{{ $imageUrl }}" alt="Room" class="room-mini-thumb">
                            <div class="room-item-details">
                                <div class="room-item-name">
                                    {{ $detail['roomType']->name }}
                                    <span>{{ number_format($detail['subTotal'], 0, ',', '.') }} đ</span>
                                </div>
                                <div class="room-item-meta">{{ $detail['roomType']->width * $detail['roomType']->height }}m² (x{{ $detail['qty'] }})</div>
                                <span class="room-tag-green">GIÁ TỐT NHẤT</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Stay Details Info -->
                    <div class="stay-dates-summary">
                        <div class="date-box">
                            <span class="date-label">NGÀY NHẬN</span>
                            <span class="date-val">{{ $checkin->format('d/m/Y') }}</span>
                        </div>
                        <div class="date-box">
                            <span class="date-label">NGÀY TRẢ</span>
                            <span class="date-val">{{ $checkout->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <div class="extra-info-small">
                        <span>{{ $nights }} Đêm • {{ collect($roomDetails)->sum('qty') }} Phòng</span>
                    </div>

                    <!-- Pricing Breakdown -->
                    <div class="pricing-breakdown">
                        <div class="p-total-line">
                            <div class="p-item" style="margin-top: 15px;">
                                <span style="font-weight: 700; color: #0f172a;">TỔNG THANH TOÁN</span>
                                <span class="total-amount-val">{{ number_format($totalAmount, 0, ',', '.') }} đ</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <button type="submit" class="btn-continue-long" style="width: 100%; border: none; cursor: pointer;">
                        XÁC NHẬN ĐẶT PHÒNG
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <div class="security-footer">
                        <i class="fas fa-lock"></i>
                        Đặt phòng an toàn • Mã hóa SSL
                    </div>
                </div>

                <!-- Assistance Box -->
                <div class="assistance-card">
                    <div class="assistance-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="assistance-text">
                        <strong>Bạn cần hỗ trợ?</strong>
                        Liên hệ đội ngũ hỗ trợ 24/7 của chúng tôi tại 1900 1234
                    </div>
                </div>
            </aside>
        </div>
    </form>
</main>
@endsection

@if(!$user)
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const emailInput = document.getElementById('checkout_email');
    const firstNameInput = document.getElementById('checkout_first_name');
    const lastNameInput = document.getElementById('checkout_last_name');
    const phoneInput = document.getElementById('checkout_phone');
    const countryInput = document.getElementById('checkout_country');
    const detailsSection = document.getElementById('customer-details-section');
    const customerIdInput = document.getElementById('detected_customer_id');
    const statusBox = document.getElementById('customer-lookup-status');

    if (!emailInput || !firstNameInput || !lastNameInput || !phoneInput || !countryInput || !detailsSection || !customerIdInput || !statusBox) {
        return;
    }

    const lookupUrl = "{{ route('checkout.customer.lookup', [], false) }}";
    let debounceTimer = null;
    let activeLookup = 0;
    let lastMatchedCustomerId = customerIdInput.value ? Number(customerIdInput.value) : null;

    function setReadOnlyState(isReadOnly) {
        firstNameInput.readOnly = isReadOnly;
        lastNameInput.readOnly = isReadOnly;
        phoneInput.readOnly = isReadOnly;
        countryInput.readOnly = isReadOnly;
    }

    function setRequiredState(isRequired) {
        firstNameInput.required = isRequired;
        lastNameInput.required = isRequired;
        phoneInput.required = isRequired;
    }

    function toggleDetails(shouldShow) {
        detailsSection.hidden = !shouldShow;
    }

    function setStatus(type, message) {
        if (!message) {
            statusBox.hidden = true;
            statusBox.className = 'customer-lookup-status';
            statusBox.textContent = '';
            return;
        }

        statusBox.hidden = false;
        statusBox.className = 'customer-lookup-status ' + type;
        statusBox.textContent = message;
    }

    function clearMatchedCustomer() {
        customerIdInput.value = '';
        lastMatchedCustomerId = null;
        setReadOnlyState(false);
        setRequiredState(false);
    }

    function clearCustomerFields() {
        firstNameInput.value = '';
        lastNameInput.value = '';
        phoneInput.value = '';
        countryInput.value = '';
    }

    function useExistingCustomer(customer) {
        customerIdInput.value = String(customer.id || '');
        firstNameInput.value = customer.first_name || '';
        lastNameInput.value = customer.last_name || '';
        phoneInput.value = customer.phone_number || '';
        countryInput.value = customer.country || '';
        setReadOnlyState(true);
        setRequiredState(false);
        toggleDetails(true);
        lastMatchedCustomerId = customer.id || null;
    }

    function useNewCustomerForm(clearFields) {
        if (clearFields) {
            clearCustomerFields();
        }
        clearMatchedCustomer();
        setReadOnlyState(false);
        setRequiredState(true);
        toggleDetails(true);
    }

    if (lastMatchedCustomerId) {
        toggleDetails(true);
        setReadOnlyState(true);
        setRequiredState(false);
    } else if (firstNameInput.value || lastNameInput.value || phoneInput.value || countryInput.value) {
        toggleDetails(true);
        setReadOnlyState(false);
        setRequiredState(true);
    } else {
        toggleDetails(false);
        setRequiredState(false);
    }

    async function lookupCustomerByEmail(rawEmail) {
        const email = String(rawEmail || '').trim().toLowerCase();
        if (email === '') {
            clearMatchedCustomer();
            toggleDetails(false);
            setStatus('', '');
            return;
        }

        const isValidEmailFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        if (!isValidEmailFormat) {
            clearMatchedCustomer();
            toggleDetails(false);
            setStatus('info', 'Nhập email hợp lệ để kiểm tra khách hàng.');
            return;
        }

        activeLookup += 1;
        const lookupId = activeLookup;
        setStatus('loading', 'Đang kiểm tra email...');

        try {
            const response = await fetch(lookupUrl + '?email=' + encodeURIComponent(email), {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (lookupId !== activeLookup) {
                return;
            }

            if (!response.ok) {
                throw new Error('lookup_failed');
            }

            const payload = await response.json();
            if (payload.exists && payload.customer) {
                const customer = payload.customer;
                useExistingCustomer(customer);
                setStatus('success', 'Đã xác nhận khách hàng tồn tại: ' + (customer.full_name || customer.email) + '.');
                return;
            }

            useNewCustomerForm(!!lastMatchedCustomerId);
            setStatus('info', 'Email chưa có trong hệ thống. Thông tin này sẽ được dùng để tạo khách hàng mới.');
        } catch (error) {
            if (lookupId !== activeLookup) {
                return;
            }

            useNewCustomerForm(false);
            setStatus('error', 'Không thể kiểm tra email lúc này. Bạn vẫn có thể nhập thông tin để tạo khách hàng mới.');
        }
    }

    function queueLookup() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            lookupCustomerByEmail(emailInput.value);
        }, 450);
    }

    emailInput.addEventListener('input', queueLookup);
    emailInput.addEventListener('blur', function () {
        clearTimeout(debounceTimer);
        lookupCustomerByEmail(emailInput.value);
    });

    if (emailInput.value && !customerIdInput.value) {
        lookupCustomerByEmail(emailInput.value);
    }
});
</script>
@endpush
@endif
