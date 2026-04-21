<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'customer_name' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'booking_date' => 'required|date',
            'staff_id' => 'nullable|exists:staff,id',
            'room_ids' => 'required|array|min:1',
            'room_ids.*' => 'exists:rooms,id',
            'checkin_dates.*' => 'required|date',
            'checkout_dates.*' => 'required|date',
            'hourly_prices.*' => 'nullable|numeric|min:0',
            'daily_prices.*' => 'nullable|numeric|min:0',
            'total_service_amount' => 'nullable|numeric|min:0',
            'total_room_amount' => 'nullable|numeric|min:0',
            'surcharge_amount' => 'nullable|numeric|min:0',
            'final_amount' => 'nullable|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'Vui lòng chọn khách hàng hoặc nhập thông tin mới',
            'customer_id.exists' => 'Khách hàng không tồn tại',
            'booking_date.required' => 'Vui lòng chọn ngày đặt phòng',
            'booking_date.date' => 'Ngày đặt phòng không hợp lệ',
            'room_ids.required' => 'Vui lòng chọn ít nhất một phòng',
            'room_ids.min' => 'Vui lòng chọn ít nhất một phòng',
        ];
    }
}
