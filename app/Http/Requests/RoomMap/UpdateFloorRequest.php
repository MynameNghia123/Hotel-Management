<?php

namespace App\Http\Requests\RoomMap;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFloorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên tầng không được để trống',
            'name.string' => 'Tên tầng phải là text',
            'name.max' => 'Tên tầng tối đa 255 ký tự',
        ];
    }
}
