@extends('client.layouts.master')

@section('title', 'Hồ Sơ Cá Nhân | Urban Luxe Hotel')
@section('meta_description', 'Quản lý thông tin cá nhân và lịch sử đặt phòng của bạn tại Urban Luxe.')

@push('styles')
@vite(['resources/css/client/profile.css'])
@endpush

@section('content')
<!-- Hero Section -->
<section class="profile-hero" style="background-image: linear-gradient(rgba(15, 22, 36, 0.8), rgba(15, 22, 36, 0.8)), url('{{ asset('img/backgroundhomepage.png') }}');">
    <div class="container">
        <div class="member-badge">KHU VỰC THÀNH VIÊN</div>
        <h1>Chỉnh Sửa Hồ Sơ</h1>
        <p>Quản lý thông tin cá nhân và các tùy chọn của bạn.</p>
    </div>
</section>

<!-- Main Content -->
<section class="profile-content">
    <div class="profile-container">
        
        <!-- Sidebar Navigation -->
        <aside class="profile-sidebar">
            <nav class="sidebar-nav">
                <a href="{{ route('profile') }}" class="sidebar-nav-item active">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M8.5 7a4 4 0 110-8 4 4 0 010 8z"></path>
                    </svg>
                    Hồ Sơ
                </a>
                <a href="#" class="sidebar-nav-item">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Lịch Đặt Phòng
                </a>
            </nav>
        </aside>

        <!-- Main Form Area -->
        <div class="profile-card">
            <div class="card-header">
                <h2>Hồ Sơ Của Tôi</h2>
                <span class="required-text">Các trường có dấu <span>*</span> là bắt buộc</span>
            </div>

            <form action="#" method="POST">
                @csrf
                <div class="profile-form-grid">
                    <!-- Tên -->
                    <div class="form-group">
                        <label>TÊN <span>*</span></label>
                        <input type="text" class="profile-input" value="Thomas" placeholder="Nhập tên">
                    </div>

                    <!-- Họ -->
                    <div class="form-group">
                        <label>HỌ <span>*</span></label>
                        <input type="text" class="profile-input" value="Anderson" placeholder="Nhập họ">
                    </div>

                    <!-- Quốc gia -->
                    <div class="form-group full-width">
                        <label>QUỐC GIA / KHU VỰC <span>*</span></label>
                        <div style="position: relative;">
                            <select class="profile-input" style="appearance: none; cursor: pointer;">
                                <option value="vn">Việt Nam</option>
                                <option value="us" selected>Hoa Kỳ (United States)</option>
                                <option value="uk">Anh Quốc</option>
                                <option value="fr">Pháp</option>
                            </select>
                            <div style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #64748b;">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Số điện thoại -->
                    <div class="form-group full-width">
                        <label>SỐ ĐIỆN THOẠI <span>*</span></label>
                        <div class="phone-input-group">
                            <div class="country-code">
                                <span>US +1</span>
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                            <input type="text" class="profile-input phone-number" value="(555) 012-3456" placeholder="Nhập số điện thoại">
                        </div>
                        <div class="input-hint">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Số điện thoại đã được xác nhận để khôi phục tài khoản.
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-save">
                    Lưu Thay Đổi
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                </button>
            </form>
        </div>

    </div>
</section>
@endsection
