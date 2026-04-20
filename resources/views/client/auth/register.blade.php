<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng ký thành viên | Urban Luxe Hotel</title>
    <!-- ... -->
    <meta name="description" content="Tham gia cộng đồng Urban Luxe để nhận ưu đãi.">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/client/register.css'])
</head>
<body>

    <section class="register-section" style="background-image: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.7)), url('{{ asset('img/backgroundhomepage.png') }}'); background-size: cover; background-position: center;">
        
        <a href="{{ route('home') }}" class="back-home-link">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5"></path>
                <path d="M12 19l-7-7 7-7"></path>
            </svg>
            Quay lại trang web
        </a>
        
        <div class="auth-brand">
            <!-- Brand Logo Area -->
            <div class="brand-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3" y="10" width="8" height="12" fill="#2563eb" rx="1" />
                    <rect x="13" y="4" width="8" height="18" fill="white" rx="1" />
                </svg>
            </div>
            <h2 class="brand-name">Urban Luxe</h2>
            <p class="brand-tagline">CHỐN BÌNH YÊN GIỮA LÒNG THÀNH PHỐ</p>
        </div>

        <div class="auth-card">
            <header class="auth-header">
                <h1>Đăng ký</h1>
            </header>

            <!-- Khung báo lỗi -->
            <div id="alert-msg" style="display:none; padding: 10px 14px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; text-align: left;"></div>

            <form onsubmit="handleRegister(event)">
                <div class="form-grid">
                    <div class="form-group">
                        <label>TÊN <span style="color: red;">*</span></label>
                        <input type="text" id="first_name" class="form-input" placeholder="Ví dụ: Anh" required>
                    </div>
                    <div class="form-group">
                        <label>HỌ <span style="color: red;">*</span></label>
                        <input type="text" id="last_name" class="form-input" placeholder="Ví dụ: Nguyễn" required>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>SỐ ĐIỆN THOẠI</label>
                        <input type="text" id="phone_number" class="form-input" placeholder="0912 345 678">
                    </div>
                    <div class="form-group">
                        <label>ĐỊA CHỈ EMAIL <span style="color: red;">*</span></label>
                        <input type="email" id="email" class="form-input" placeholder="email@example.com" required>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 30px;">
                    <label>QUỐC GIA</label>
                    <div style="position: relative;">
                        <select id="country" class="form-input">
                            <option value="">Chọn Quốc Gia</option>
                            <option value="Vietnam">Việt Nam</option>
                            <option value="United States">Hoa Kỳ</option>
                            <option value="United Kingdom">Anh Quốc</option>
                            <option value="France">Pháp</option>
                        </select>
                        <div style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #64748b; display: flex; align-items: center;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <button type="submit" id="btn-register" class="btn-auth-submit">Tạo tài khoản</button>
            </form>

            <div class="social-divider">
                <span>HOẶC TIẾP TỤC VỚI</span>
            </div>

            <div class="social-buttons">
                <button class="btn-social">
                    <svg width="18" height="18" fill="white" viewBox="0 0 24 24"><path d="M12.152 6.896c-.948 0-2.415-1.078-3.96-1.04-2.04.027-3.91 1.183-4.961 3.014-2.117 3.675-.546 9.103 1.519 12.09 1.013 1.454 2.208 3.09 3.792 3.039 1.52-.065 2.09-.987 3.935-.987 1.831 0 2.35.987 3.96.948 1.637-.026 2.676-1.48 3.676-2.948 1.156-1.688 1.636-3.325 1.662-3.415-.039-.013-3.182-1.221-3.22-4.857-.026-3.04 2.48-4.494 2.597-4.559-1.429-2.09-3.623-2.324-4.39-2.376-2-.156-3.675 1.09-4.61 1.09zM15.53 3.83c.843-1.012 1.4-2.427 1.245-3.83-1.207.052-2.674.805-3.532 1.818-.78.896-1.454 2.338-1.273 3.714.415.039 2.532-.676 3.559-1.701"></path></svg>
                    Apple
                </button>
                <button class="btn-social">
                    <svg width="18" height="18" fill="#1877F2" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path></svg>
                    Facebook
                </button>
            </div>

            <p class="signin-footer">Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a></p>

        </div>

    </section>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function showAlert(message, isError = true) {
            const alert = document.getElementById('alert-msg');
            alert.style.display = 'block';
            alert.style.background = isError ? 'rgba(239,68,68,0.1)' : 'rgba(34,197,94,0.1)';
            alert.style.color = isError ? '#ef4444' : '#22c55e';
            alert.style.border = isError ? '1px solid rgba(239,68,68,0.2)' : '1px solid rgba(34,197,94,0.2)';
            
            // Xử lý xuống dòng nếu tin nhắn là một mảng lỗi
            if (Array.isArray(message)) {
                alert.innerHTML = message.join('<br>');
            } else {
                alert.innerHTML = message;
            }
        }

        async function handleRegister(event) {
            event.preventDefault(); // Ngăn form tải lại trang
            
            const btn = document.getElementById('btn-register');
            btn.disabled = true;
            btn.textContent = 'Đang xử lý...';
            document.getElementById('alert-msg').style.display = 'none';

            // Lấy dữ liệu
            const data = {
                first_name: document.getElementById('first_name').value.trim(),
                last_name: document.getElementById('last_name').value.trim(),
                phone_number: document.getElementById('phone_number').value.trim(),
                email: document.getElementById('email').value.trim(),
                country: document.getElementById('country').value,
            };

            try {
                const response = await fetch('{{ route("client.register") }}', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();

                if (response.ok && result.success) {
                    showAlert('Đăng ký thành công! Đang tự động đăng nhập...', false);
                    setTimeout(() => window.location.href = result.redirect, 1500);
                } else {
                    // Hiển thị lỗi Validation của Laravel (Vd: Email đã tồn tại)
                    if (result.errors) {
                        const errorMessages = Object.values(result.errors).flat();
                        showAlert(errorMessages);
                    } else {
                        showAlert(result.message || 'Có lỗi xảy ra, vui lòng thử lại sau.');
                    }
                }
            } catch (error) {
                showAlert('Không thể kết nối máy chủ, vui lòng thử lại.');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Tạo tài khoản';
            }
        }
    </script>
</body>
</html>
