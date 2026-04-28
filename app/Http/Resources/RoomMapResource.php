<?php

namespace App\Http\Resources;

use App\Enums\RoomStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomMapResource extends JsonResource
{
    public function toArray($request): array
    {
        $status = $this->status instanceof RoomStatus
            ? $this->status
            : RoomStatus::tryFrom((string) $this->status);

        $latestBookingDetail = $this->relationLoaded('bookingDetails')
            ? $this->bookingDetails->first()
            : $this->bookingDetails()
                ->with('booking.customer')
                ->orderByDesc('checkin_date')
                ->first();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'room_type_code' => strtoupper((string) ($this->roomType?->code ?? $this->roomType?->name ?? '')),
            'status' => $status?->value ?? (string) $this->status,
            'status_label' => $status?->label() ?? 'Không xác định',
            'card_class' => $status?->cardClass() ?? RoomStatus::EMPTY->cardClass(),
            'route_name' => $status?->routeName() ?? RoomStatus::OCCUPIED->routeName(),
            'show_indicator' => $this->show_indicator,
            'is_empty' => $this->is_empty,
            'is_confirmed' => $status === RoomStatus::CONFIRMED,
            'guest_name' => $latestBookingDetail?->booking?->customer?->full_name,
            'checkin_at' => $latestBookingDetail?->formatted_checkin_at,
            'checkout_at' => $latestBookingDetail?->formatted_checkout_at,
        ];
    }
}
