@extends('admin.layouts.master')

@section('title', 'Bảng điều khiển | Urban Luxe Admin')

@section('content')
@php
    $upcomingGuests = $upcomingGuests ?? collect();
@endphp

<div style="display:flex; height:100vh; background:#f5f6fa;">

    {{-- SIDEBAR --}}
    
    @include('admin.layouts.sidebar')

    {{-- CONTENT --}}
    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

        {{-- HEADER --}}
        @include('admin.layouts.header')

        {{-- MAIN CONTENT --}}
        <div style="flex:1; overflow-y:auto; padding:28px 32px; display:flex; flex-direction:column; gap:22px;">

            {{-- ARRIVALS TABLE --}}
            <div style="background:#fff; border-radius:16px; border:1px solid #f1f3f7; box-shadow:0 1px 4px rgba(0,0,0,.04); overflow:hidden;">
                <div style="display:flex; align-items:center; justify-content:space-between; padding:22px 28px 18px;">
                    <div>
                        <h1 id="tab-title" style="font-size:17px; font-weight:800; color:#0f172a; margin:0 0 4px;">Danh Sách Khách Sẽ Đến</h1>
                        <p id="tab-desc" style="font-size:13px; color:#94a3b8; margin:0;">Danh sách khách hàng dự kiến nhận phòng sắp tới</p>
                    </div>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <a href="{{ route('admin.bookings.create') }}" style="display:flex; align-items:center; gap:6px; padding:8px 18px; background:#2a3f8a; color:#fff; border:none; border-radius:10px; font-size:12px; font-weight:700; cursor:pointer; box-shadow:0 3px 10px rgba(42,63,138,.25); text-decoration:none;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Đặt phòng mới
                        </a>
                    </div>
                </div>

                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr style="background:#f8f9fb; border-top:1px solid #f1f3f7; border-bottom:1px solid #f1f3f7;">
                                <th style="padding:12px 28px; text-align:left; font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em;">Số Phòng</th>
                                <th style="padding:12px 16px; text-align:left; font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em;">Mã ĐP</th>
                                <th style="padding:12px 16px; text-align:left; font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em;">Tên Khách</th>
                                <th style="padding:12px 16px; text-align:left; font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em;">Giờ Đến</th>
                                <th style="padding:12px 16px; text-align:left; font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em;">Trạng Thái</th>
                                <th style="padding:12px 28px; text-align:right; font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em;">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody id="dashboard-table-body">
                            @forelse ($upcomingGuests as $detail)
                                @php
                                    $booking = $detail->booking;
                                    $customer = $booking?->customer;
                                    $room = $detail->room;
                                    $statusEnum = \App\Enums\BookingStatus::tryFrom((string) ($booking?->status ?? ''));
                                    $statusStyle = match ($statusEnum?->value) {
                                        'confirmed' => 'background:#f0fdf4; color:#16a34a;',
                                        'pending' => 'background:#fff7ed; color:#ea580c;',
                                        default => 'background:#eff6ff; color:#2563eb;',
                                    };
                                    $checkinDate = $detail->checkin_date;
                                    $checkinLabel = $checkinDate?->isToday()
                                        ? 'Hôm nay'
                                        : ($checkinDate?->isTomorrow() ? 'Ngày mai' : $checkinDate?->format('d/m/Y'));
                                @endphp

                                <tr style="border-bottom:1px solid #f8f9fb;">
                                    <td style="padding:14px 28px;">
                                        <div style="display:flex; align-items:center; gap:10px;">
                                            <div style="width:34px; height:34px; border-radius:9px; background:#eff6ff; border:1px solid #bfdbfe; display:flex; align-items:center; justify-content:center; color:#3b82f6;">
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                                            </div>
                                            <div>
                                                <div style="font-size:14px; font-weight:700; color:#0f172a;">{{ $room?->name ?? 'Chưa gán phòng' }}</div>
                                                <div style="font-size:11px; color:#94a3b8; margin-top:2px;">{{ $room?->roomType?->name ?? 'Chưa có hạng phòng' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding:14px 16px; font-size:13px; color:#64748b; font-weight:500;">#BK-{{ $booking?->id ?? 'N/A' }}</td>
                                    <td style="padding:14px 16px;">
                                        <div style="display:flex; flex-direction:column; gap:2px;">
                                            <span style="font-size:13.5px; font-weight:700; color:#0f172a;">{{ $customer?->full_name ?: 'Khách chưa có tên' }}</span>
                                            <span style="font-size:11.5px; color:#94a3b8;">{{ $customer?->phone_number ?? $customer?->email ?? 'Chưa có liên hệ' }}</span>
                                        </div>
                                    </td>
                                    <td style="padding:14px 16px; font-size:13px; color:#64748b;">{{ $checkinDate?->format('H:i') ?? '--:--' }} · {{ $checkinLabel ?? '--' }}</td>
                                    <td style="padding:14px 16px;">
                                        <span style="padding:3px 10px; {{ $statusStyle }} border-radius:99px; font-size:11px; font-weight:700;">{{ $statusEnum?->label() ?? 'Không rõ' }}</span>
                                    </td>
                                    <td style="padding:14px 28px; text-align:right;">
                                        @if ($booking)
                                            <a href="{{ route('admin.bookings.show', $booking->id) }}" style="display:inline-flex; padding:5px 14px; background:#eff6ff; color:#2a3f8a; border:none; border-radius:8px; font-size:12px; font-weight:700; text-decoration:none;">Xem</a>
                                        @else
                                            <span style="font-size:12px; color:#94a3b8;">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align:center; padding:38px 28px; color:#94a3b8; font-size:13px;">
                                        Chưa có khách sắp đến.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="padding:14px 28px; display:flex; align-items:center; justify-content:space-between; border-top:1px solid #f8f9fb;">
                    <div style="font-size:13px; color:#64748b;">
                        Hiển thị <strong style="color:#0f172a;">{{ $upcomingGuests->count() }}</strong> khách sắp đến
                    </div>
                    <a href="{{ route('admin.bookings.index') }}" style="font-size:13px; color:#2a3f8a; font-weight:700; text-decoration:none;">Xem tất cả đặt phòng</a>
                </div>
            </div>

        </div>

        {{-- FOOTER --}}
        @include('admin.layouts.footer')

    </main>
</div>

@endsection
    
