@extends('admin.layouts.master')

@section('title', 'Quản lý loại phòng | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/rooms.css')
@endpush

@section('content')
    <div class="admin-layout">

        {{-- SIDEBAR --}}
        @include('admin.layouts.sidebar')

        {{-- CONTENT --}}
        <main class="admin-main">

            {{-- HEADER (Dùng chung với dashboard/bookings) --}}
            <header class="admin-header">
                <div class="admin-header-left">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6" />
                    </svg>
                    16819 &middot; Urban Luxe Hotel
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </div>
                <div class="admin-header-right">
                    <button class="admin-header-notification">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0" />
                        </svg>
                        <span class="admin-header-notification-dot"></span>
                    </button>
                    <div class="admin-header-divider"></div>
                    <div class="admin-header-user">
                        <div class="admin-header-user-info">
                            <div class="admin-header-user-name">Admin Đức</div>
                            <div class="admin-header-user-role">Quản lý cấp cao</div>
                        </div>
                        <img src="https://ui-avatars.com/api/?name=Admin+Duc&background=2a3f8a&color=fff&size=80"
                            class="admin-header-user-avatar" alt="Admin">
                    </div>
                </div>
            </header>

            {{-- MAIN CONTENT --}}
            <div class="admin-content">
                @if(session('success'))
                    <div
                        style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #c3e6cb;">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="rt-container">
                    <div class="rt-header">
                        <div>
                            <h1 class="rt-title">Danh sách phòng</h1>
                            <p class="rt-subtitle">Hệ thống quản trị khách sạn Urban Luxe - Quản lý danh mục loại phòng và
                                chính sách giá.</p>
                        </div>
                        <a href="{{ route('admin.rooms.create') }}" class="rt-btn-primary" style="text-decoration: none;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Thêm loại phòng mới
                        </a>
                    </div>

                    <div class="rt-toolbar">
                        <div class="rt-search-wrapper">
                            <div class="rt-search-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </div>
                            <input type="text" class="rt-search-input" placeholder="Tìm theo tên loại phòng (Room Type)...">
                        </div>
                        <div class="rt-filters">
                            <select class="rt-select">
                                <option>Tất cả trạng thái</option>
                                <option>Hoạt động</option>
                                <option>Ngừng kinh doanh</option>
                            </select>
                            <button class="rt-btn-filter">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="rt-table-wrapper">
                        <table class="rt-table">
                            <thead>
                                <tr>
                                    <th>TÊN LOẠI PHÒNG</th>
                                    <th>DIỆN TÍCH (M2)</th>
                                    <th>SỐ GIƯỜNG (BED/TYPE)</th>
                                    <th>GIÁ THEO GIỜ</th>
                                    <th>GIÁ THEO NGÀY</th>
                                    <th>SỐ LƯỢNG</th>
                                    <th style="text-align: right;">HÀNH ĐỘNG</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roomTypes as $type)
                                    <tr>
                                        <td>
                                            <div class="rt-type-info">
                                                <div class="rt-name">{{ $type->name }}</div>
                                                <div class="rt-code">{{ $type->code }}</div>
                                            </div>
                                        </td>
                                        <td><span class="rt-area">{{ number_format($type->width * $type->height, 1) }}</span>
                                        </td>
                                        <td>
                                            <div class="rt-beds">
                                                <div class="rt-bed-item">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2.5">
                                                        <path
                                                            d="M7 17v-4M17 17v-4M3 8v9M21 8v9M3 11h18M5 8h14a2 2 0 012 2v1h-18v-1a2 2 0 012-2z" />
                                                    </svg>
                                                    {{ $type->single_bed_quantity }}
                                                </div>
                                                <div class="rt-bed-item">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2.5">
                                                        <rect x="3" y="11" width="18" height="8" rx="2" />
                                                        <path d="M7 11V7a2 2 0 012-2h6a2 2 0 012 2v4M11 11v4" />
                                                    </svg>
                                                    {{ $type->double_bed_quantity }}
                                                </div>
                                            </div>
                                        </td>
                                        <td><span
                                                class="rt-price-hour">{{ number_format($type->hourly_price, 0, ',', '.') }}₫</span>
                                        </td>
                                        <td><span
                                                class="rt-price-day">{{ number_format($type->daily_price, 0, ',', '.') }}₫</span>
                                        </td>
                                        <td>
                                            <div class="rt-quantity">{{ $type->rooms_count }}</div>
                                        </td>
                                        <td>
                                            <div class="rt-actions">

                                                <a href="{{ route('admin.rooms.edit', $type->id) }}" class="rt-btn-action edit"
                                                    title="Chỉnh sửa">
                                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path>
                                                        <path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.rooms.destroy', $type->id) }}" method="POST"
                                                    style="display:inline-block;"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa loại phòng này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="rt-btn-action delete" title="Xóa"
                                                        style="border:none; cursor:pointer;">
                                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path
                                                                d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2">
                                                            </path>
                                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align: center; padding: 2rem; color: #888;">
                                            Chưa có loại phòng nào. Hãy thêm mới!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="rt-footer">
                        <div class="rt-info">Hiển thị 1 đến 4 trên 12 loại phòng</div>
                        <div class="rt-pagination">
                            <button class="rt-page-btn disabled">&lt;</button>
                            <button class="rt-page-btn active">1</button>
                            <button class="rt-page-btn">2</button>
                            <button class="rt-page-btn">3</button>
                            <button class="rt-page-btn">&gt;</button>
                        </div>
                    </div>
                </div>

                {{-- FOOTER --}}
                @include('admin.layouts.footer')

        </main>
    </div>
@endsection