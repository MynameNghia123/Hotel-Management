@extends('admin.layouts.master')

@section('title', 'Quản lý đặt lịch | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/bookings.css')
@endpush

@section('content')
<div style="display:flex; height:100vh; background:#f5f6fa;">

    {{-- SIDEBAR --}}
    @include('admin.layouts.sidebar')

    {{-- CONTENT --}}
    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

        {{-- HEADER --}}
        @include('admin.layouts.header')

        {{-- MAIN CONTENT --}}
        <div style="flex:1; overflow-y:auto; padding:28px 32px; display:flex; flex-direction:column; background:#f8fafc;">
            {{-- FLASH MESSAGES --}}
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible" style="margin-bottom: 16px;">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible" style="margin-bottom: 16px;">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <div class="bk-container">
                <div class="bk-header">
                    <div>
                        <h1 class="bk-title">Quản lý đặt lịch</h1>
                        <p class="bk-subtitle">Hệ thống quản trị khách sạn Urban Luxe - Quản lý đặt lịch khách hàng.</p>
                    </div>
                    <a href="{{ route('admin.bookings.create') }}" style="text-decoration: none;">
                        <button class="bk-btn-primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                            Tạo đặt phòng mới
                        </button>
                    </a>
                </div>

                <div class="bk-toolbar">
                    <form method="get" class="d-flex gap-3" style="flex: 1;">
                        <div class="bk-search">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" name="filters[search]" value="{{ request('filters.search') }}" placeholder="Tìm theo Tên khách / Mã đặt phòng...">
                        </div>
                        <div class="bk-filters">
                            <select class="bk-select" name="filters[status]" onchange="this.form.submit()">
                                <option value="">Tất cả trạng thái ({{ $bookings->total() }})</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->value }}" {{ request('filters.status') === $status->value ? 'selected' : '' }}>
                                        {{ $status->label() }} ({{ $statusCounts[$status->value] ?? 0 }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>

                <div class="bk-table-wrapper">
                    <table class="bk-table">
                        <thead>
                            <tr>
                                <th>MÃ ĐẶT PHÒNG</th>
                                <th>KHÁCH HÀNG</th>
                                <th>CHECK-IN</th>
                                <th>CHECK-OUT</th>
                                <th>TỔNG TIỀN</th>
                                <th>TRẠNG THÁI</th>
                                <th>THAO TÁC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bookings as $booking)
                                <tr>
                                    <td class="bk-id">#{{ $booking->id }}</td>
                                    <td>
                                        <div class="bk-customer-name">{{ $booking->customer->first_name . " " .$booking->customer->last_name  }}</div>
                                        <div class="bk-customer-phone">{{ $booking->customer->phone_number ?? 'N/A' }}</div>
                                    </td>

                                    <td class="bk-date">
                                        @if ($booking->bookingDetails->first())
                                            {{ $booking->bookingDetails->first()->checkin_date->format('d/m/Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="bk-date">
                                        @if ($booking->bookingDetails->first())
                                            {{ $booking->bookingDetails->first()->checkout_date->format('d/m/Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="bk-price">{{ number_format($booking->final_amount, 0, ',', '.') }} đ</td>
                                    <td>
                                        @php
                                            // dd($booking->status);
                                            $statusEnum = \App\Enums\BookingStatus::from($booking->status);
                                            $badgeClass = match($statusEnum->value) {
                                                'pending' => 'pending',
                                                'confirmed' => 'confirmed',
                                                'occupied' => 'staying',
                                                'paid' => 'paid',
                                                'cancelled' => 'cancelled',
                                                default => 'pending'
                                            };
                                        @endphp
                                        <span class="bk-badge {{ $badgeClass }}">{{ $statusEnum->label() }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="bk-btn-action" title="Xem chi tiết">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 40px; color: #94a3b8;">
                                        Không có đặt phòng nào
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <x-pagination :paginator="$bookings" />
                </div>
            </div>
        </div>
        @include('admin.layouts.footer')
    </main>
   
</div>

@endsection
