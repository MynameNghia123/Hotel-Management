<?php

namespace App\Http\Requests\RoomType;

use Illuminate\Foundation\Http\FormRequest;

class SyncEquipmentsRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'equipment_data' => 'nullable|array',
            'equipment_data.*.equipment_id' => 'integer|exists:equipments,id',
            'equipment_data.*.quantity' => 'integer|min:1'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'equipment_data.array' => 'Danh sách tài sản phải là một mảng.',
            'equipment_data.*.equipment_id.integer' => 'ID tài sản phải là một số nguyên.',
            'equipment_data.*.equipment_id.exists' => 'ID tài sản không tồn tại.',
            'equipment_data.*.quantity.integer' => 'Số lượng phải là một số nguyên.',
            'equipment_data.*.quantity.min' => 'Số lượng phải tối thiểu là 1.'
        ];
    }
}
