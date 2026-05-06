<?php

namespace App\Http\Requests\RepairTicket;

use App\Enums\RepairTicketStatus;
use Illuminate\Foundation\Http\FormRequest;

class StoreRepairTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_id' => 'required|exists:rooms,id',
            'reported_date' => 'required|date',
            'issue_description' => 'required|string|max:1000',
            'technician_note' => 'nullable|string|max:1000',
            'repair_cost' => 'nullable|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'room_id.required' => 'Phòng là bắt buộc',
            'room_id.exists' => 'Phòng không tồn tại',
            'reported_date.required' => 'Ngày báo cáo là bắt buộc',
            'reported_date.date' => 'Ngày báo cáo phải là ngày hợp lệ',
            'issue_description.required' => 'Mô tả vấn đề là bắt buộc',
            'issue_description.max' => 'Mô tả vấn đề không được vượt quá 1000 ký tự',
            'repair_cost.numeric' => 'Chi phí sửa chữa phải là số',
            'repair_cost.min' => 'Chi phí sửa chữa phải lớn hơn hoặc bằng 0',
        ];
    }

    public function passedValidation(): void
    {
        $this->merge([
            'status' => RepairTicketStatus::PENDING->value,
        ]);
    }
}
