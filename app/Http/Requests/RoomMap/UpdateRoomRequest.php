<?php

namespace App\Http\Requests\RoomMap;

use Illuminate\Foundation\Http\FormRequest;

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
            'status' => 'nullable|string|in:available,maintenance,occupied,blocked'
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
            'status.in' => 'Trạng thái không hợp lệ'
        ];
    }
}
