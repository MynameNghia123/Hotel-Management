<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng nhập | Urban Luxe Hotel</title>
    <meta name="description" content="Đăng nhập vào tài khoản Urban Luxe để quản lý đặt phòng và nhận các ưu đãi đặc quyền.">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/client/login.css'])
</head>
<body>

    <section class="login-section" style="background-image: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.7)), url('{{ asset('img/backgroundhomepage.png') }}'); background-size: cover; background-position: center;">
        
        <a href="{{ route('home') }}" class="back-home-link">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5"></path>
                <path d="M12 19l-7-7 7-7"></path>
            </svg>
            Quay lại trang web
        </a>

        <!-- Branding -->
        <div class="auth-brand">
            <div class="brand-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3" y="10" width="8" height="12" fill="white" rx="1" />
                    <rect x="13" y="4" width="8" height="18" fill="white" rx="1" />
                </svg>
            </div>
            <h2 class="brand-name">Urban Luxe</h2>
            <p class="brand-tagline">CHỐN BÌNH YÊN GIỮA LÒNG THÀNH PHỐ</p>
        </div>

        <!-- AUTH CARD -->
        <div class="auth-card">
            <h1 id="card-title">Đăng nhập</h1>
            <p class="auth-subtitle" id="card-subtitle">Nhập email để nhận mã OTP</p>

            <!-- Thông báo lỗi / thành công -->
            <div id="alert-msg" style="display:none; padding: 10px 14px; border-radius: 8px; margin-bottom: 16px; font-size: 14px;"></div>

            <!-- BƯỚC 1: Nhập Email -->
            <div id="step-email">
                <div class="input-group">
                    <div class="input-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <input type="email" id="input-email" class="login-input" placeholder="email@example.com">
                </div>
                <button id="btn-send-otp" class="btn-send-otp" onclick="sendOtp()">Gửi mã OTP</button>
            </div>

            <!-- BƯỚC 2: Nhập OTP (ẩn mặc định) -->
            <div id="step-otp" style="display:none;">
                <p style="font-size:13px; color:#94a3b8; margin-bottom:16px;">
                    Mã OTP đã được gửi đến <strong id="display-email" style="color:#e2e8f0;"></strong>
                    — <a href="#" onclick="backToEmail()" style="color:#60a5fa;">Đổi email</a>
                </p>
                <div class="input-group">
                    <div class="input-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0110 0v4"></path>
                        </svg>
                    </div>
                    <input type="text" id="input-otp" class="login-input" placeholder="Nhập mã 6 số" maxlength="6" style="letter-spacing: 8px; font-size: 20px; text-align: center;">
                </div>
                <button id="btn-verify-otp" class="btn-send-otp" onclick="verifyOtp()">Xác nhận & Đăng nhập</button>
                <p style="font-size:12px; color:#64748b; text-align:center; margin-top:12px;">
                    Không nhận được mã? <a href="#" onclick="sendOtp()" style="color:#60a5fa;">Gửi lại</a>
                </p>
            </div>

            <div class="social-divider"><span>HOẶC</span></div>

            <p style="font-size:14px; color:#94a3b8; text-align:center;">
                Chưa có tài khoản? <a href="{{ route('register') }}" style="color:#60a5fa; font-weight:600;">Đăng ký ngay</a>
            </p>

            <!-- Policy Footer -->
            <div class="auth-policy">
                Bằng việc tiếp tục, bạn đồng ý với<br>
                <a href="#">Điều khoản dịch vụ</a> và <a href="#">Chính sách bảo mật</a> của chúng tôi.
            </div>
        </div>

    </section>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function showAlert(message, isError = true) {
        const alert = document.getElementById('alert-msg');
        alert.style.display = 'block';
        alert.style.background = isError ? 'rgba(239,68,68,0.15)' : 'rgba(34,197,94,0.15)';
        alert.style.color = isError ? '#f87171' : '#4ade80';
        alert.style.border = isError ? '1px solid rgba(239,68,68,0.3)' : '1px solid rgba(34,197,94,0.3)';
        alert.textContent = message;
    }

    function setLoading(btnId, loading) {
        const btn = document.getElementById(btnId);
        btn.disabled = loading;
        btn.textContent = loading ? 'Đang xử lý...' : (btnId === 'btn-send-otp' ? 'Gửi mã OTP' : 'Xác nhận & Đăng nhập');
    }

    // Gửi OTP
    async function sendOtp() {
        const email = document.getElementById('input-email').value.trim();
        if (!email) { showAlert('Vui lòng nhập địa chỉ email.'); return; }

        setLoading('btn-send-otp', true);
        document.getElementById('alert-msg').style.display = 'none';

        try {
            const res = await fetch('{{ route("client.send_otp") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ email })
            });
            const data = await res.json();

            if (data.success) {
                // Chuyển sang bước nhập OTP
                document.getElementById('step-email').style.display = 'none';
                document.getElementById('step-otp').style.display = 'block';
                document.getElementById('display-email').textContent = email;
                document.getElementById('card-subtitle').textContent = 'Nhập mã OTP từ email của bạn';
                showAlert(data.message, false);
            } else {
                showAlert(data.message || 'Có lỗi xảy ra, vui lòng thử lại.');
            }
        } catch (e) {
            showAlert('Không thể kết nối máy chủ, vui lòng thử lại.');
        } finally {
            setLoading('btn-send-otp', false);
        }
    }

    // Xác nhận OTP
    async function verifyOtp() {
        const email = document.getElementById('input-email').value.trim();
        const otp   = document.getElementById('input-otp').value.trim();
        if (!otp || otp.length !== 6) { showAlert('Vui lòng nhập đủ mã 6 số.'); return; }

        setLoading('btn-verify-otp', true);
        document.getElementById('alert-msg').style.display = 'none';

        try {
            const res = await fetch('{{ route("client.verify_otp") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ email, otp })
            });
            const data = await res.json();

            if (data.success) {
                showAlert('Đăng nhập thành công! Đang chuyển hướng...', false);
                setTimeout(() => window.location.href = data.redirect, 1000);
            } else {
                showAlert(data.message || 'Mã OTP không hợp lệ.');
            }
        } catch (e) {
            showAlert('Không thể kết nối máy chủ, vui lòng thử lại.');
        } finally {
            setLoading('btn-verify-otp', false);
        }
    }

    // Quay lại nhập email
    function backToEmail() {
        document.getElementById('step-otp').style.display = 'none';
        document.getElementById('step-email').style.display = 'block';
        document.getElementById('input-otp').value = '';
        document.getElementById('card-subtitle').textContent = 'Nhập email để nhận mã OTP';
        document.getElementById('alert-msg').style.display = 'none';
    }

    // Cho phép nhấn Enter để submit
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            if (document.getElementById('step-otp').style.display !== 'none') {
                verifyOtp();
            } else {
                sendOtp();
            }
        }
    });
</script>

</body>
</html>
