<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu | Urban Luxe Hotel</title>
    <meta name="description" content="Khôi phục mật khẩu tài khoản Urban Luxe để tiếp tục đặt phòng.">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/client/forgot_password.css'])
</head>
<body>

<main class="auth-page">
    <section class="auth-section" style="background-image: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.7)), url('{{ asset('img/backgroundhomepage.png') }}'); background-size: cover; background-position: center;">
        <a href="{{ route('home') }}" class="back-home-link">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5"></path>
                <path d="M12 19l-7-7 7-7"></path>
            </svg>
            Quay lại trang web
        </a>
        <div class="auth-card">
            <!-- Branding -->
            <div class="auth-brand">
                <div class="brand-icon">
                    <i class="fas fa-key" style="color: #2563eb; font-size: 1.5rem;"></i>
                </div>
                <h1 class="brand-name">Urban Luxe</h1>
                <p class="brand-tagline">Quản lý đặt phòng</p>
            </div>

            <!-- Title -->
            <h1>Quên mật khẩu?</h1>
            <p class="auth-subtitle">Nhập địa chỉ email của bạn để nhận liên kết khôi phục mật khẩu mới.</p>

            <form action="#" class="auth-form">
                <!-- Email Input -->
                <div class="input-group">
                    <i class="far fa-envelope input-icon"></i>
                    <input type="email" placeholder="Địa chỉ email của bạn" class="auth-input" required>
                </div>

                <!-- Action Button -->
                <button type="submit" class="btn-primary-auth">Gửi yêu cầu</button>
            </form>

            <!-- Back to Login -->
            <a href="{{ route('login') }}" class="link-back-login">
                <i class="fas fa-arrow-left"></i>
                Quay lại đăng nhập
            </a>

            <!-- Footer -->
            <div class="auth-footer">
                <p>&copy; 2030 Urban Luxe Hotel. Bảo mật & An toàn.</p>
                <div style="margin-top: 10px;">
                    <a href="#">Điều khoản</a> • <a href="#">Hỗ trợ</a>
                </div>
            </div>
        </div>
    </section>
</main>

</body>
</html>
