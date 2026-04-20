<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chào mừng đến với Urban Luxe</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f0ece6; font-family: 'Inter', sans-serif; -webkit-font-smoothing: antialiased; }

        .shell { max-width: 620px; margin: 0 auto; padding: 36px 16px 48px; }

        /* ── PRE-HEADER ── */
        .pre-header {
            text-align: center;
            margin-bottom: 12px;
        }
        .pre-header span {
            font-size: 10px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #a08c5b;
        }

        /* ── CARD WRAPPER ── */
        .card { background: #fff; border-radius: 4px; overflow: hidden; box-shadow: 0 8px 48px rgba(0,0,0,0.10); }

        /* ── HERO ── */
        .hero {
            position: relative;
            background: #0d1b2a;
            padding: 60px 48px 52px;
            text-align: center;
            overflow: hidden;
        }
        /* Pattern overlay */
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                repeating-linear-gradient(45deg, rgba(212,175,55,0.03) 0, rgba(212,175,55,0.03) 1px, transparent 0, transparent 50%);
            background-size: 20px 20px;
        }
        /* Gold glow */
        .hero::after {
            content: '';
            position: absolute;
            top: -80px; left: 50%;
            transform: translateX(-50%);
            width: 320px; height: 320px;
            background: radial-gradient(circle, rgba(212,175,55,0.18) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-eyebrow {
            position: relative;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .eyebrow-line { width: 28px; height: 1px; background: rgba(212,175,55,0.5); }
        .eyebrow-text { font-size: 9px; color: #d4af37; letter-spacing: 5px; text-transform: uppercase; }

        .hero-title {
            position: relative;
            z-index: 1;
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 44px;
            font-weight: 400;
            color: #fff;
            letter-spacing: 2px;
            line-height: 1.15;
            margin-bottom: 6px;
        }
        .hero-title em {
            font-style: italic;
            color: #d4af37;
        }

        .hero-sub {
            position: relative;
            z-index: 1;
            font-size: 10px;
            color: rgba(212,175,55,0.55);
            letter-spacing: 5px;
            text-transform: uppercase;
            margin-bottom: 28px;
        }

        .hero-stars {
            position: relative;
            z-index: 1;
            color: #d4af37;
            font-size: 13px;
            letter-spacing: 7px;
        }

        /* ── GOLD STRIPE ── */
        .stripe {
            height: 4px;
            background: linear-gradient(90deg, #8b6914 0%, #d4af37 25%, #f5e17a 50%, #d4af37 75%, #8b6914 100%);
        }

        /* ── BODY ── */
        .body { padding: 48px 52px 40px; }

        .salute {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 22px;
            font-weight: 400;
            color: #0d1b2a;
            margin-bottom: 6px;
        }
        .salute-role {
            font-size: 10px;
            color: #d4af37;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 22px;
        }

        .body-text {
            font-size: 14px;
            color: #6b6377;
            line-height: 1.9;
            margin-bottom: 38px;
        }

        /* ── CARD DIVIDER ── */
        .section-label {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        .section-label span {
            font-size: 10px;
            color: #b0a090;
            letter-spacing: 3px;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #ede8df;
        }

        /* ── MEMBER CARD ── */
        .member-card {
            border: 1px solid #ede8df;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 38px;
        }
        .member-card-header {
            background: linear-gradient(135deg, #0d1b2a 0%, #1a3355 100%);
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .mc-logo {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 15px;
            color: #fff;
            letter-spacing: 2px;
        }
        .mc-badge {
            font-size: 9px;
            color: #d4af37;
            border: 1px solid rgba(212,175,55,0.4);
            border-radius: 20px;
            padding: 3px 10px;
            letter-spacing: 2px;
        }

        .member-card-body { padding: 20px 24px; }

        .mc-row {
            display: flex;
            gap: 0;
            border-bottom: 1px solid #f5f0ea;
        }
        .mc-row:last-child { border-bottom: none; }

        .mc-field {
            flex: 1;
            padding: 12px 0;
        }
        .mc-field + .mc-field {
            border-left: 1px solid #f5f0ea;
            padding-left: 20px;
        }
        .mc-field-label {
            font-size: 9px;
            color: #c0b8a8;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .mc-field-value {
            font-size: 14px;
            color: #0d1b2a;
            font-weight: 500;
        }

        /* ── PERKS ── */
        .perks {
            display: flex;
            gap: 12px;
            margin-bottom: 40px;
        }
        .perk-box {
            flex: 1;
            background: #faf8f5;
            border: 1px solid #ede8df;
            border-radius: 10px;
            padding: 18px 14px;
            text-align: center;
        }
        .perk-icon { font-size: 22px; margin-bottom: 8px; display: block; }
        .perk-title { font-size: 12px; font-weight: 600; color: #0d1b2a; margin-bottom: 4px; }
        .perk-desc  { font-size: 11px; color: #a09890; line-height: 1.5; }

        /* ── CTA ── */
        .cta-wrap { text-align: center; margin-bottom: 38px; }
        .cta-btn {
            display: inline-block;
            background: #0d1b2a;
            color: #d4af37 !important;
            text-decoration: none;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
            padding: 16px 44px;
            border-radius: 3px;
        }
        .cta-note {
            font-size: 12px;
            color: #c0b8a8;
            margin-top: 12px;
        }

        /* ── FINE PRINT ── */
        .fine-print {
            font-size: 11px;
            color: #c8c0b4;
            line-height: 1.8;
            text-align: center;
            border-top: 1px solid #f0ece6;
            padding-top: 24px;
        }

        /* ── FOOTER ── */
        .footer {
            background: #0d1b2a;
            padding: 32px 52px;
            text-align: center;
        }
        .footer-name {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 16px;
            color: #d4af37;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .footer-divider {
            width: 40px;
            height: 1px;
            background: rgba(212,175,55,0.25);
            margin: 0 auto 12px;
        }
        .footer-text {
            font-size: 11px;
            color: rgba(255,255,255,0.28);
            line-height: 1.8;
        }
    </style>
</head>
<body>
<div class="shell">

    <!-- Pre-header -->
    <div class="pre-header">
        <span>Thư xác nhận tài khoản thành viên</span>
    </div>

    <div class="card">

        <!-- ── HERO ── -->
        <div class="hero">
            <div class="hero-eyebrow">
                <div class="eyebrow-line"></div>
                <span class="eyebrow-text">Est. 2024 · Premium Collection</span>
                <div class="eyebrow-line"></div>
            </div>
            <div class="hero-title">Urban <em>Luxe</em></div>
            <div class="hero-sub">Hotel &amp; Resort</div>
            <div class="hero-stars">★ ★ ★ ★ ★</div>
        </div>

        <!-- Gold stripe -->
        <div class="stripe"></div>

        <!-- ── BODY ── -->
        <div class="body">

            <div class="salute">Xin chào, {{ $customer->first_name }} {{ $customer->last_name }}!</div>
            <div class="salute-role">New Member · Urban Luxe</div>

            <p class="body-text">
                Chúng tôi trân trọng chào đón bạn trở thành thành viên chính thức của
                <strong style="color:#0d1b2a;">Urban Luxe Hotel &amp; Resort</strong>.
                Tài khoản của bạn đã sẵn sàng — hãy để chúng tôi mang đến trải nghiệm
                nghỉ dưỡng đẳng cấp 5 sao dành riêng cho bạn.
            </p>

            <!-- Member Card -->
            <div class="section-label">
                <span>Thông tin thành viên</span>
            </div>

            <div class="member-card">
                <div class="member-card-header">
                    <span class="mc-logo">Urban Luxe</span>
                    <span class="mc-badge">Classic Member</span>
                </div>
                <div class="member-card-body">
                    <div class="mc-row">
                        <div class="mc-field">
                            <div class="mc-field-label">Họ &amp; Tên</div>
                            <div class="mc-field-value">{{ $customer->first_name }} {{ $customer->last_name }}</div>
                        </div>
                        <div class="mc-field">
                            <div class="mc-field-label">Ngày tham gia</div>
                            <div class="mc-field-value">{{ now()->format('d/m/Y') }}</div>
                        </div>
                    </div>
                    <div class="mc-row">
                        <div class="mc-field">
                            <div class="mc-field-label">Email</div>
                            <div class="mc-field-value">{{ $customer->email }}</div>
                        </div>
                    </div>
                    @if($customer->phone_number || $customer->country)
                    <div class="mc-row">
                        @if($customer->phone_number)
                        <div class="mc-field">
                            <div class="mc-field-label">Điện thoại</div>
                            <div class="mc-field-value">{{ $customer->phone_number }}</div>
                        </div>
                        @endif
                        @if($customer->country)
                        <div class="mc-field">
                            <div class="mc-field-label">Quốc gia</div>
                            <div class="mc-field-value">{{ $customer->country }}</div>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Perks -->
            <div class="section-label">
                <span>Quyền lợi thành viên</span>
            </div>

            <div class="perks">
                <div class="perk-box">
                    <span class="perk-icon">🏨</span>
                    <div class="perk-title">Đặt phòng ưu tiên</div>
                    <div class="perk-desc">Truy cập phòng cao cấp, giá ưu đãi riêng</div>
                </div>
                <div class="perk-box">
                    <span class="perk-icon">🔐</span>
                    <div class="perk-title">Đăng nhập OTP</div>
                    <div class="perk-desc">Bảo mật tuyệt đối, không cần mật khẩu</div>
                </div>
                <div class="perk-box">
                    <span class="perk-icon">🎁</span>
                    <div class="perk-title">Ưu đãi thành viên</div>
                    <div class="perk-desc">Khuyến mãi &amp; quà tặng hàng tháng</div>
                </div>
            </div>

            <!-- CTA -->
            <div class="cta-wrap">
                <a href="{{ url('/') }}" class="cta-btn">Khám Phá Ngay</a>
                <div class="cta-note">Trải nghiệm dịch vụ 5 sao của Urban Luxe</div>
            </div>

            <!-- Fine print -->
            <div class="fine-print">
                Nếu bạn không đăng ký tài khoản này, vui lòng bỏ qua email.<br>
                Email này được gửi tự động — vui lòng không trả lời.
            </div>

        </div>

        <!-- ── FOOTER ── -->
        <div class="footer">
            <div class="footer-name">Urban Luxe</div>
            <div class="footer-divider"></div>
            <div class="footer-text">
                &copy; {{ date('Y') }} Urban Luxe Hotel &amp; Resort. All rights reserved.<br>
                Luxury is not a privilege — it's an experience we craft for you.
            </div>
        </div>

    </div><!-- /card -->
</div>
</body>
</html>
