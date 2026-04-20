<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mã Xác Thực OTP</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;600&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', Arial, sans-serif;
            background-color: #0f0f0f;
            padding: 40px 20px;
        }

        .wrapper {
            max-width: 580px;
            margin: 0 auto;
        }

        /* ── HEADER ── */
        .header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            border-radius: 16px 16px 0 0;
            padding: 40px 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 70% 30%, rgba(212, 175, 55, 0.08) 0%, transparent 60%);
        }

        .logo-line {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 8px;
        }

        .logo-divider {
            width: 40px;
            height: 1px;
            background: linear-gradient(90deg, transparent, #d4af37, transparent);
        }

        .logo-icon {
            color: #d4af37;
            font-size: 22px;
        }

        .hotel-name {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 26px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .hotel-tagline {
            font-size: 11px;
            color: #d4af37;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-top: 6px;
        }

        /* ── BODY ── */
        .body {
            background: #ffffff;
            padding: 48px 40px 36px;
        }

        .greeting {
            font-size: 15px;
            color: #444;
            line-height: 1.7;
            margin-bottom: 10px;
        }

        .description {
            font-size: 14px;
            color: #666;
            line-height: 1.8;
            margin-bottom: 36px;
        }

        .description strong {
            color: #1a1a2e;
        }

        /* ── OTP BOX ── */
        .otp-label {
            font-size: 11px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-align: center;
            margin-bottom: 14px;
        }

        .otp-box {
            background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%);
            border-radius: 12px;
            padding: 28px 20px;
            text-align: center;
            margin: 0 0 36px;
            position: relative;
            overflow: hidden;
        }

        .otp-box::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 50% 50%, rgba(212,175,55,0.12), transparent 70%);
        }

        .otp-code {
            font-family: 'Courier New', monospace;
            font-size: 44px;
            font-weight: 700;
            color: #d4af37;
            letter-spacing: 14px;
            text-shadow: 0 0 30px rgba(212,175,55,0.4);
            position: relative;
        }

        .otp-expiry {
            margin-top: 12px;
            font-size: 12px;
            color: rgba(255,255,255,0.55);
            position: relative;
        }

        .otp-expiry span {
            color: #f0b429;
        }

        /* ── STEPS ── */
        .steps-title {
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 16px;
        }

        .step {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 14px;
        }

        .step-num {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1a1a2e, #0f3460);
            color: #d4af37;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .step-text {
            font-size: 13px;
            color: #555;
            line-height: 1.6;
            padding-top: 4px;
        }

        /* ── DIVIDER ── */
        .divider {
            border: none;
            border-top: 1px solid #f0f0f0;
            margin: 32px 0;
        }

        /* ── WARNING ── */
        .warning-box {
            background: #fffbeb;
            border-left: 3px solid #d4af37;
            border-radius: 0 8px 8px 0;
            padding: 14px 16px;
            font-size: 13px;
            color: #7a6010;
            line-height: 1.6;
        }

        /* ── FOOTER ── */
        .footer {
            background: #1a1a2e;
            border-radius: 0 0 16px 16px;
            padding: 28px 40px;
            text-align: center;
        }

        .footer-brand {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 14px;
            color: #d4af37;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .footer-text {
            font-size: 12px;
            color: rgba(255,255,255,0.4);
            line-height: 1.7;
        }

        .footer-text a {
            color: rgba(212,175,55,0.7);
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="wrapper">

    <!-- HEADER -->
    <div class="header">
        <div class="logo-line">
            <div class="logo-divider"></div>
            <div class="logo-icon">✦</div>
            <div class="logo-divider"></div>
        </div>
        <div class="hotel-name">Urban Luxe</div>
        <div class="hotel-tagline">Premium Hotel &amp; Resort</div>
    </div>

    <!-- BODY -->
    <div class="body">
        <p class="greeting">Xin chào Quý khách,</p>
        <p class="description">
            Chúng tôi đã nhận được yêu cầu xác thực từ địa chỉ email của bạn.
            Vui lòng sử dụng mã OTP bên dưới để tiếp tục. Mã này có hiệu lực trong
            <strong>5 phút</strong> kể từ thời điểm gửi.
        </p>

        <!-- OTP CODE -->
        <div class="otp-label">Mã xác thực của bạn</div>
        <div class="otp-box">
            <div class="otp-code">{{ $otp }}</div>
            <div class="otp-expiry">Hết hạn sau <span>5 phút</span></div>
        </div>

        <!-- STEPS -->
        <p class="steps-title">Hướng dẫn sử dụng</p>

        <div class="step">
            <div class="step-num">1</div>
            <div class="step-text">Quay lại trang đăng nhập / đăng ký trên Website.</div>
        </div>
        <div class="step">
            <div class="step-num">2</div>
            <div class="step-text">Nhập mã <strong>{{ $otp }}</strong> vào ô xác thực OTP.</div>
        </div>
        <div class="step">
            <div class="step-num">3</div>
            <div class="step-text">Nhấn <strong>Xác nhận</strong> để hoàn tất đăng nhập.</div>
        </div>

        <hr class="divider">

        <!-- WARNING -->
        <div class="warning-box">
            ⚠️ Nếu bạn <strong>không thực hiện</strong> yêu cầu này, vui lòng bỏ qua email này.
            Không chia sẻ mã OTP với bất kỳ ai — chúng tôi sẽ không bao giờ hỏi mã của bạn.
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <div class="footer-brand">Urban Luxe Hotel</div>
        <div class="footer-text">
            Email này được gửi tự động, vui lòng không trả lời.<br>
            &copy; {{ date('Y') }} Urban Luxe Hotel. All rights reserved.
        </div>
    </div>

</div>
</body>
</html>
