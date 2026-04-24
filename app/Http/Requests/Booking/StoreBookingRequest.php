<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Decode JSON string fields sent from hidden inputs before validation
     */
    protected function prepareForValidation(): void
    {
        $merge = [];

        // room_ids: "[1,2,3]" → [1,2,3]
        if ($this->has('room_ids') && is_string($this->room_ids)) {
            $decoded = json_decode($this->room_ids, true);
            $merge['room_ids'] = is_array($decoded) ? $decoded : [];
        }

        // checkin_dates: "[\"2026-04-24\",...]" → [...]
        if ($this->has('checkin_dates') && is_string($this->checkin_dates)) {
            $decoded = json_decode($this->checkin_dates, true);
            $merge['checkin_dates'] = is_array($decoded) ? $decoded : [];
        }

        // checkout_dates
        if ($this->has('checkout_dates') && is_string($this->checkout_dates)) {
            $decoded = json_decode($this->checkout_dates, true);
            $merge['checkout_dates'] = is_array($decoded) ? $decoded : [];
        }

        // booking_date: default to today if not provided
        if (empty($this->booking_date)) {
            $merge['booking_date'] = now()->toDateString();
        }

        $this->merge($merge);
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
            'booking_date' => 'nullable|date',
            'staff_id' => 'nullable|exists:staff,id',
            
            // Rooms
            'room_ids'        => 'required|array|min:1',
            'room_ids.*'      => 'exists:rooms,id',
            'checkin_dates'   => 'nullable|array',
            'checkin_dates.*' => 'nullable|date',
            'checkout_dates'   => 'nullable|array',
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
