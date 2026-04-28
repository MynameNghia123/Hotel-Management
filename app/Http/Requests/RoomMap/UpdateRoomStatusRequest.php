<?php

namespace App\Http\Requests\RoomMap;

use App\Enums\RoomStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoomStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => [
                'required',
                'string',
                Rule::in([
                    RoomStatus::EMPTY->value,
                    RoomStatus::MAINTENANCE->value,
                ]),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Trạng thái phòng là bắt buộc.',
            'status.string' => 'Trạng thái phòng phải là chuỗi ký tự.',
            'status.in' => 'Trạng thái phòng không hợp lệ.',
        ];
    }
}
