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
            // Customer: either customer_id (existing) or new customer fields
            'customer_id' => 'nullable|exists:customers,id',
            'customer_last_name' => 'nullable|string|max:255',
            'customer_first_name' => 'nullable|string|max:255',
            'customer_new_email' => 'nullable|email|max:255|unique:customers,email',
            'customer_account_id' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_country' => 'nullable|string|max:255',
            
            // Booking info
            'booking_date' => 'required|date',
            'staff_id' => 'nullable|exists:staff,id',
            
            // Rooms
            'room_ids' => 'required|array|min:1',
            'room_ids.*' => 'exists:rooms,id',
            'checkin_dates.*' => 'nullable|date',
            'checkout_dates.*' => 'nullable|date',
            'hourly_prices.*' => 'nullable|numeric|min:0',
            'daily_prices.*' => 'nullable|numeric|min:0',
            
            // Payment
            'total_service_amount' => 'nullable|numeric|min:0',
            'total_room_amount' => 'nullable|numeric|min:0',
            'surcharge_amount' => 'nullable|numeric|min:0',
            'final_amount' => 'nullable|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.exists' => 'Khách hàng không tồn tại',
            'booking_date.required' => 'Vui lòng chọn ngày đặt phòng',
            'booking_date.date' => 'Ngày đặt phòng không hợp lệ',
            'room_ids.required' => 'Vui lòng chọn ít nhất một phòng',
            'room_ids.min' => 'Vui lòng chọn ít nhất một phòng',
            'customer_new_email.unique' => 'Email này đã tồn tại trong hệ thống',
        ];
    }
}
