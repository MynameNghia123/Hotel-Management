<?php

namespace App\Http\Requests\RoomType;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRoomTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:room_types,code',
            'hourly_price' => 'required|numeric',
            'daily_price' => 'required|numeric',
            'adult_quantity' => 'required|integer',
            'child_quantity' => 'required|integer',
            'single_bed_quantity' => 'required|integer',
            'double_bed_quantity' => 'required|integer',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'description' => 'nullable|string',
        ];
    }
}
