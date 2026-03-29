@extends('client.layouts.master')

@section('title', 'Nhà Hàng & Ẩm Thực | Urban Luxe Hotel')
@section('meta_description', 'Khám phá tinh hoa ẩm thực tại nhà hàng của Urban Luxe. Thực đơn phong phú từ các đầu bếp hàng đầu trong không gian sang trọng.')

@push('styles')
@vite(['resources/css/client/dining.css'])
@endpush

@section('content')
<section class="dining-section">
    
    <!-- 1. Hero Banner KHÔNG CẮT ẢNH -->
    <div class="dining-banner">
        <img src="{{ asset('img/dining.png') }}" class="main-banner" alt="Dining Banner">
        <div class="banner-content">
            <h5 class="banner-subtitle">ẨM THỰC ĐẶC TRƯNG</h5>
            <h1 class="banner-title">Ẩm Thực</h1>
            <p class="banner-desc">
                Bản giao hương của hương vị trong không gian sang trọng và tinh tế nhất. 
                Trải nghiệm nghệ thuật ẩm thực đỉnh cao vượt qua mọi sự kỳ vọng.
            </p>
            <div class="banner-actions">
                <a href="#" class="btn-luxury-gold">XEM THỰC ĐƠN</a>
                <a href="#" class="btn-luxury-outline">PHÒNG RIÊNG</a>
            </div>
        </div>
    </div>

    <!-- 2. Seasonal Creations Section (Nền Đen) -->
    <div class="seasonal-section">
        <div class="dining-container">
            <div class="seasonal-grid">
                
                <!-- Cột trái: Ảnh Chef's Table -->
                <div class="seasonal-left">
                    <h2 class="banner-title" style="font-size: 4rem; text-align: left; margin-bottom: 20px;">Sáng Tạo Theo Mùa</h2>
                    <p style="color: #94a3b8; line-height: 1.8; margin-bottom: 40px; max-width: 500px;">
                        Bếp trưởng của chúng tôi tuyển chọn thực đơn thay đổi theo mùa, tìm kiếm những nguyên liệu địa phương tốt nhất để tạo ra những món ăn vừa hiện đại vừa mang giá trị trường tồn.
                    </p>
                    
                    <div class="seasonal-image-wrapper shadow-lg">
                        <img src="{{ asset('img/dining2.png') }}" alt="Chef's Table">
                        <div class="chef-overlay">
                            <h6 class="chef-subtitle">BÀN TIỆC BẾP TRƯỞNG</h6>
                            <h4 class="chef-title">Hành trình ẩm thực riêng tư<br>và tinh tế.</h4>
                        </div>
                    </div>
                </div>

                <!-- Cột phải: Tasting Menu -->
                <div class="seasonal-right">
                    <span class="menu-header-gold">THỰC ĐƠN THƯỞNG THỨC</span>
                    
                    <div class="menu-list">
                        <!-- Món 1 -->
                        <div class="menu-item">
                            <div class="menu-item-info">
                                <h4>Sò Điệp Hokkaido</h4>
                                <p>Yuzu kosho, chanh ngón tay, củ cải muối, dầu ngò hoang.</p>
                            </div>
                            <span class="menu-item-price">$32</span>
                        </div>

                        <!-- Món 2 -->
                        <div class="menu-item">
                            <div class="menu-item-info">
                                <h4>Thịt Bò Wagyu Tartare</h4>
                                <p>Lòng đỏ trứng xông khói, sốt nụ tầm xuân, hành phi giòn, bánh mì chua.</p>
                            </div>
                            <span class="menu-item-price">$45</span>
                        </div>

                        <!-- Món 3 -->
                        <div class="menu-item">
                            <div class="menu-item-info">
                                <h4>Cá Tuyết Đen Sốt Miso</h4>
                                <p>Cải chíp cháy cạnh, dashi gừng, vừng giòn.</p>
                            </div>
                            <span class="menu-item-price">$58</span>
                        </div>

                        <!-- Món 4 -->
                        <div class="menu-item">
                            <div class="menu-item-info">
                                <h4>Ravioli Tôm Hùm</h4>
                                <p>Sốt kem nhụy hoa nghệ tây, trứng cá tầm, hẹ, vỏ chanh.</p>
                            </div>
                            <span class="menu-item-price">$64</span>
                        </div>

                        <!-- Món 5 -->
                        <div class="menu-item">
                            <div class="menu-item-info">
                                <h4>Cơm Risotto Nấm Truffle</h4>
                                <p>Gạo Acquerello, nấm rừng, bọt phô mai parmesan, nấm truffle đen tươi.</p>
                            </div>
                            <span class="menu-item-price">$48</span>
                        </div>

                        <!-- Món 6 -->
                        <div class="menu-item">
                            <div class="menu-item-info">
                                <h4>Quả Cầu Socola Đen</h4>
                                <p>Nhân hạt phỉ, lá vàng, sốt caramel ấm.</p>
                            </div>
                            <span class="menu-item-price">$28</span>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

</section>
@endsection
