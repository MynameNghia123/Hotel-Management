@extends('admin.layouts.master')

@section('title', 'Xem / Chỉnh sửa khách hàng | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/customers-show.css')
@endpush

@section('content')
<div class="cs-layout">
    @include('admin.layouts.sidebar')
    
    <main class="cs-main">
        @include('admin.layouts.header')
        
        <div class="cs-content-area" style="padding: 32px; background: #f8fafc; flex: 1; overflow-y: auto;">
            <div style="max-width: 1000px; margin: 0 auto;">
                
                <!-- THÔNG TIN CÁ NHÂN -->
                <div style="background: #fff; padding: 32px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #f1f3f7; margin-bottom: 24px;">
                    <hgroup style="margin-bottom: 24px;">
                        <h2 style="margin-top: 0; font-size: 20px; color: #1e293b; margin-bottom: 4px; font-weight: 700;">Xem chi tiết khách hàng</h2>
                        <p style="color: #64748b; font-size: 13px; margin: 0;">Mã khách hàng: CUS-{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</p>
                    </hgroup>

                    <div style="margin-bottom: 24px;">
                        <p style="color: #64748b; font-size: 12px; font-weight: 600; text-transform: uppercase; margin: 0 0 16px 0;">THÔNG TIN CÁ NHÂN</p>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 12px; text-transform: uppercase;">Họ</label>
                                <input type="text" value="{{ $customer->last_name }}" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; background: #f8fafc;" readonly>
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 12px; text-transform: uppercase;">Tên</label>
                                <input type="text" value="{{ $customer->first_name }}" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; background: #f8fafc;" readonly>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 12px; text-transform: uppercase;">Email</label>
                                <input type="email" value="{{ $customer->email }}" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; background: #f8fafc;" readonly>
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 12px; text-transform: uppercase;">Quốc gia</label>
                                <input type="text" value="{{ $customer->country }}" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; background: #f8fafc;" readonly>
                            </div>
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 12px; text-transform: uppercase;">Số điện thoại</label>
                            <input type="text" value="{{ $customer->phone_number }}" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; background: #f8fafc;" readonly>
                        </div>
                    </div>
                </div>

                <!-- LỊCH SỬ ĐẶT PHÒNG -->
                <div style="background: #fff; padding: 32px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #f1f3f7;">
                    <hgroup style="margin-bottom: 24px;">
                        <h3 style="margin-top: 0; font-size: 16px; color: #1e293b; font-weight: 700;">LỊCH SỬ ĐẶT PHÒNG</h3>
                    </hgroup>

                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid #e2e8f0; background: #f8fafc;">
                                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #64748b; font-size: 12px; text-transform: uppercase;">Mã Đặt Phòng</th>
                                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #64748b; font-size: 12px; text-transform: uppercase;">Ngày Đặt</th>
                                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #64748b; font-size: 12px; text-transform: uppercase;">Ngày Đi</th>
                                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #64748b; font-size: 12px; text-transform: uppercase;">Tiền Phòng</th>
                                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #64748b; font-size: 12px; text-transform: uppercase;">Tiền Dịch Vụ</th>
                                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #64748b; font-size: 12px; text-transform: uppercase;">Tổng Tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customer->bookings as $booking)
                                    @foreach($booking->bookingDetails as $detail)
                                        <tr style="border-bottom: 1px solid #e2e8f0;">
                                            <td style="padding: 12px; color: #2a3f8a; font-weight: 600;">#BK-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                                            <td style="padding: 12px; color: #475569;">{{ $booking->booking_date->format('d/m/Y') }}</td>
                                            <td style="padding: 12px; color: #475569;">{{ $detail->checkout_date->format('d/m/Y') }}</td>
                                            <td style="padding: 12px; color: #475569;">{{ number_format($booking->total_room_amount, 0, ',', '.') }} đ</td>
                                            <td style="padding: 12px; color: #475569;">{{ number_format($booking->total_service_amount, 0, ',', '.') }} đ</td>
                                            <td style="padding: 12px; color: #1e293b; font-weight: 600;">{{ number_format($booking->final_amount, 0, ',', '.') }} đ</td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr style="border-bottom: 1px solid #e2e8f0;">
                                        <td colspan="6" style="padding: 12px; text-align: center; color: #64748b;">Chưa có lịch sử đặt phòng</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 32px; border-top: 1px solid #f1f3f7; padding-top: 24px;">
                        <a href="{{ route('admin.customers.index') }}" style="padding: 10px 20px; border-radius: 10px; background: #fff; border: 1px solid #e2e8f0; color: #64748b; font-weight: 600; text-decoration: none; font-size: 14px;">Quay lại danh sách</a>
                        <a href="{{ route('admin.customers.edit', $customer->id) }}" style="padding: 10px 24px; border-radius: 10px; background: #2a3f8a; color: #fff; border: none; font-weight: 600; text-decoration: none; font-size: 14px; box-shadow: 0 4px 12px rgba(42, 63, 138, 0.2);">Chỉnh sửa</a>
                    </div>
                </div>

            </div>
        </div>
        
        @include('admin.layouts.footer')
    </main>
</div>
@endsection
