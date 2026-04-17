@extends('admin.layouts.master')

@section('title', 'Quản lý khách hàng | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/customers.css')
@endpush

@section('content')
    <div class="admin-layout">

        {{-- SIDEBAR --}}
        @include('admin.layouts.sidebar')

        {{-- CONTENT --}}
        <main class="admin-main">

            {{-- HEADER (Dùng chung bộ khung thống nhất) --}}
            <header class="admin-header">
                <div class="admin-header-left">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6" />
                    </svg>
                    16819 &middot; Urban Luxe Hotel
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </div>
                <div class="admin-header-right">
                    <div class="admin-header-date">
                        <span class="admin-header-date-label">Ngày làm việc</span>
                        <div class="admin-header-date-value">24 Tháng 05, 2024</div>
                    </div>
                    <button class="admin-header-notification">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0" />
                        </svg>
                        <span class="admin-header-notification-dot"></span>
                    </button>
                    <div class="admin-header-avatar">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=dcfce7&color=16a34a&size=80"
                            alt="Admin User">
                    </div>
                </div>
            </header>

            {{-- MAIN CONTENT AREA --}}
            <div class="admin-content">

                @if(session('success'))
                    <div
                        style="background: #dcfce7; color: #15803d; padding: 16px; border-radius: 12px; margin-bottom: 24px; border: 1px solid #bbf7d0; display: flex; align-items: center; gap: 12px; font-weight: 600;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="cs-container">
                    <div class="cs-header">
                        <div>
                            <h1 class="cs-title">Quản lý khách hàng</h1>
                            <p class="cs-subtitle">Hệ thống quản trị khách sạn Urban Luxe - Quản lý danh sách khách hàng
                                chuyên nghiệp.</p>
                        </div>
                        <a href="{{ route('admin.customers.create') }}" class="cs-btn-primary"
                            style="text-decoration: none;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <line x1="19" y1="8" x2="19" y2="14"></line>
                                <line x1="16" y1="11" x2="22" y2="11"></line>
                            </svg>
                            Thêm khách hàng mới
                        </a>
                    </div>

                    <div class="cs-toolbar">
                        <form method="GET" action="{{ route('admin.customers.index') }}" class="cs-search-wrapper">
                            <div class="cs-search-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </div>
                            <input type="text" name="filter[search]" class="cs-search-input" placeholder="Tìm theo Tên/Email/SĐT..." value="{{ request('filter.search') }}" onkeyup="if(event.key==='Enter') this.form.submit();">
                            <button type="submit" style="display:none;"></button>
                        </form>

                        <div class="cs-filters">
                            <form method="GET" action="{{ route('admin.customers.index') }}" style="display: flex; gap: 10px; align-items: center;">
                                <input type="hidden" name="filter[search]" value="{{ request('filter.search') }}">
                                <select name="filter[country]" class="cs-select" onchange="this.form.submit();">
                                    <option value="">Quốc gia (Tất cả)</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country }}" {{ request('filter.country') == $country ? 'selected' : '' }}>
                                            {{ $country }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                            <button class="cs-btn-action" style="color: #94a3b8;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="cs-table-wrapper">
                        <table class="cs-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>HỌ</th>
                                    <th>TÊN</th>
                                    <th>SỐ ĐIỆN THOẠI</th>
                                    <th>QUỐC GIA</th>
                                    <th>EMAIL</th>
                                    <th style="text-align: right;">THAO TÁC</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $customer)
                                    <tr>
                                        <td>CUS-{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $customer->last_name }}</td>
                                        <td class="cs-name-main">{{ $customer->first_name }}</td>
                                        <td>{{ $customer->phone_number }}</td>
                                        <td>{{ $customer->country }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>
                                            <div class="cs-actions">
                                                <a href="{{ route('admin.customers.show', $customer->id) }}" class="cs-btn-action view" title="Xem chi tiết">
                                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('admin.customers.edit', $customer->id) }}"
                                                    class="cs-btn-action edit" title="Chỉnh sửa">
                                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path>
                                                        <path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.customers.destroy', $customer->id) }}"
                                                    method="POST" style="display:inline-block;"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="cs-btn-action delete" title="Xóa"
                                                        style="border:none; background:none; cursor:pointer; padding:0;">
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
                                        <td colspan="8" style="text-align: center; padding: 2rem; color: #64748b;">Chưa có khách
                                            hàng nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
                <x-pagination :paginator="$customers" />
            </div>

            {{-- FOOTER --}}
            @include('admin.layouts.footer')

        </main>
    </div>
@endsection