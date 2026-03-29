<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập | Urban Luxe Hotel</title>
    <meta name="description" content="Đăng nhập vào tài khoản Urban Luxe để quản lý đặt phòng và nhận các ưu đãi đặc quyền.">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/client/login.css'])
</head>
<body>

    <section class="login-section" style="background-image: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.7)), url('{{ asset('img/backgroundhomepage.png') }}'); background-size: cover; background-position: center;">
        
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

        <!-- AUTH CARD (ĐĂNG NHẬP) -->
        <div class="auth-card">
            <h1>Đăng nhập</h1>
            <p class="auth-subtitle">Nhập email để nhận OTP</p>

            <form action="#" method="GET">
                <!-- Input with Mail Icon -->
                <div class="input-group">
                    <div class="input-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <input type="email" class="login-input" placeholder="unknown@example.com">
                </div>

                <!-- Thông báo lỗi tĩnh y mẫu -->
                <div class="error-msg">
                    <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM10 9v4m0-7v.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span>Địa chỉ email này chưa được đăng ký. Vui lòng kiểm tra lại chính tả hoặc tạo tài khoản mới.</span>
                </div>

                <button type="submit" class="btn-send-otp">Gửi OTP</button>
            </form>

            <div class="social-divider">
                <span>HOẶC TIẾP TỤC VỚI</span>
            </div>

            <!-- Các nút hình tròn -->
            <div class="social-icons-row">
                <div class="icon-circle">
                    <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
                        <path d="M12.152 6.896c-.948 0-2.415-1.078-3.96-1.04-2.04.027-3.91 1.183-4.961 3.014-2.117 3.675-.546 9.103 1.519 12.09 1.013 1.454 2.208 3.09 3.792 3.039 1.52-.065 2.09-.987 3.935-.987 1.831 0 2.35.987 3.96.948 1.637-.026 2.676-1.48 3.676-2.948 1.156-1.688 1.636-3.325 1.662-3.415-.039-.013-3.182-1.221-3.22-4.857-.026-3.04 2.48-4.494 2.597-4.559-1.429-2.09-3.623-2.324-4.39-2.376-2-.156-3.675 1.09-4.61 1.09zM15.53 3.83c.843-1.012 1.4-2.427 1.245-3.83-1.207.052-2.674.805-3.532 1.818-.78.896-1.454 2.338-1.273 3.714.415.039 2.532-.676 3.559-1.701"></path>
                    </svg>
                </div>
                <div class="icon-circle">
                    <svg width="24" height="24" fill="#1877F2" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path>
                    </svg>
                </div>
            </div>

            <!-- Policy Footer -->
            <div class="auth-policy">
                Bằng việc tiếp tục, bạn đồng ý với<br>
                <a href="#">Điều khoản dịch vụ</a> và <a href="#">Chính sách bảo mật</a> của chúng tôi.
            </div>

        </div>

    </section>

</body>
</html>
