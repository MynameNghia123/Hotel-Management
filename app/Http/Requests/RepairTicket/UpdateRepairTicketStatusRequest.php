<?php

namespace App\Http\Requests\RepairTicket;

use App\Enums\RepairTicketStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRepairTicketStatusRequest extends FormRequest
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
                Rule::enum(RepairTicketStatus::class),
            ],
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Trạng thái là bắt buộc',
            'status.enum' => 'Trạng thái không hợp lệ',
            'notes.max' => 'Ghi chú không được vượt quá 1000 ký tự',
        ];
    }

    /**
     * Validate status transition from current to new status
     * Returns array with success flag and error message if validation fails
     */
    public static function validateTransition($ticket, $newStatusValue)
    {
        // Get the new status enum value
        $newStatus = RepairTicketStatus::tryFrom($newStatusValue);
        if (! $newStatus) {
            return [
                'success' => false,
                'message' => 'Trạng thái không hợp lệ',
            ];
        }

        // Validate status transition
        $currentStatus = $ticket->status;
        $allowedTransitions = $currentStatus->allowedTransitions();

        if (! in_array($newStatus, $allowedTransitions)) {
            return [
                'success' => false,
                'message' => sprintf(
                    'Không thể chuyển từ %s sang %s',
                    $currentStatus->label(),
                    $newStatus->label()
                ),
            ];
        }

        return [
            'success' => true,
            'status' => $newStatus,
        ];
    }
}
