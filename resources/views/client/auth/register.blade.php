<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký thành viên | Urban Luxe Hotel</title>
    <meta name="description" content="Tham gia cộng đồng Urban Luxe để nhận ưu đãi đặt phòng tốt nhất và trải nghiệm dịch vụ khách sạn 5 sao đẳng cấp.">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Link CSS Tĩnh -->
    @vite(['resources/css/client/register.css'])
</head>
<body>

    <section class="register-section" style="background-image: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.7)), url('{{ asset('img/backgroundhomepage.png') }}'); background-size: cover; background-position: center;">
        
        <!-- Brand Logo Area -->
        <div class="auth-brand">
            <div class="brand-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3" y="10" width="8" height="12" fill="#2563eb" rx="1" />
                    <rect x="13" y="4" width="8" height="18" fill="white" rx="1" />
                </svg>
            </div>
            <h2 class="brand-name">Urban Luxe</h2>
            <p class="brand-tagline">CHỐN BÌNH YÊN GIỮA LÒNG THÀNH PHỐ</p>
        </div>

        <!-- AUTH CARD (KHUNG ĐĂNG KÝ) -->
        <div class="auth-card">
            <header class="auth-header">
                <h1>Đăng ký</h1>
            </header>

            <form action="#" method="">
                @csrf
                <!-- Grid 2 Cột: Tên và Họ -->
                <div class="form-grid">
                    <div class="form-group">
                        <label>TÊN</label>
                        <input type="text" class="form-input" placeholder="Tên của bạn">
                    </div>
                    <div class="form-group">
                        <label>HỌ</label>
                        <input type="text" class="form-input" placeholder="Họ của bạn">
                    </div>
                </div>

                <!-- Grid 2 Cột: SĐT và Email -->
                <div class="form-grid">
                    <div class="form-group">
                        <label>SỐ ĐIỆN THOẠI</label>
                        <input type="text" class="form-input" placeholder="+84 (000) 000-0000">
                    </div>
                    <div class="form-group">
                        <label>ĐỊA CHỈ EMAIL</label>
                        <input type="email" class="form-input" placeholder="email@gmail.com">
                    </div>
                </div>

                <!-- Quốc gia -->
                <div class="form-group" style="margin-bottom: 30px;">
                    <label>QUỐC GIA</label>
                    <div style="position: relative;">
                        <select class="form-input">
                            <option value="">Chọn Quốc Gia</option>
                            <option value="vn">Việt Nam</option>
                            <option value="us">Hoa Kỳ</option>
                            <option value="uk">Anh Quốc</option>
                            <option value="fr">Pháp</option>
                        </select>
                        <div style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #64748b; display: flex; align-items: center;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-auth-submit">Tạo tài khoản</button>
            </form>

            <div class="social-divider">
                <span>HOẶC TIẾP TỤC VỚI</span>
            </div>

            <!-- Social Buttons -->
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

            <p class="signin-footer">Đã có tài khoản? <a href="#">Đăng nhập</a></p>

        </div>

    </section>

</body>
</html>
