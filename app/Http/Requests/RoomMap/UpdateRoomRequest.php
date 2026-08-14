<?php

namespace App\Http\Requests\RoomMap;

use App\Enums\RoomStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoomRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'room_type_id' => 'required|integer|exists:room_types,id',
            'floor_id' => 'required|integer|exists:floors,id',
            'status' => ['nullable', 'string', Rule::in(array_map(fn (RoomStatus $status) => $status->value, RoomStatus::cases()))],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Số phòng không được để trống',
            'name.string' => 'Số phòng phải là text',
            'name.max' => 'Số phòng tối đa 255 ký tự',
            'room_type_id.required' => 'Loại phòng không được để trống',
            'room_type_id.integer' => 'Loại phòng phải là số',
            'room_type_id.exists' => 'Loại phòng không tồn tại',
            'floor_id.required' => 'Tầng không được để trống',
            'floor_id.integer' => 'Tầng phải là số',
            'floor_id.exists' => 'Tầng không tồn tại',
            'status.in' => 'Trạng thái không hợp lệ',
        ];
    }
}
