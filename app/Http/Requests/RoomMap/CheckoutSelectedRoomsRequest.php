<?php

namespace App\Http\Requests\RoomMap;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutSelectedRoomsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'selected_room_ids' => ['required', 'array', 'min:1'],
            'selected_room_ids.*' => ['required', 'integer', 'min:1'],
            'pricing_mode' => ['required', 'in:hourly,daily'],
        ];
    }

    public function messages(): array
    {
        return [
            'selected_room_ids.required' => 'Vui lòng chọn phòng cần thanh toán.',
            'selected_room_ids.array' => 'Danh sách phòng phải là mảng.',
            'selected_room_ids.min' => 'Phải chọn ít nhất 1 phòng.',
            'selected_room_ids.*.required' => 'ID phòng là bắt buộc.',
            'selected_room_ids.*.integer' => 'ID phòng phải là số nguyên.',
            'selected_room_ids.*.min' => 'ID phòng phải lớn hơn 0.',
            'pricing_mode.required' => 'Mô hình giá là bắt buộc.',
            'pricing_mode.in' => 'Mô hình giá phải là "hourly" hoặc "daily".',
        ];
    }
}
