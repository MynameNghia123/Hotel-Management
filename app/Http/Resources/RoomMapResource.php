<?php

namespace App\Http\Resources;

use App\Enums\RoomStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomMapResource extends JsonResource
{
    public function toArray($request): array
    {
        $statusValue = $this->getAttribute('room_map_status');
        $status = $statusValue
            ? RoomStatus::tryFrom((string) $statusValue)
            : ($this->status instanceof RoomStatus
                ? $this->status
                : RoomStatus::tryFrom((string) $this->status));

        $latestBookingDetail = $this->relationLoaded('roomMapBookingDetail')
            ? $this->getRelation('roomMapBookingDetail')
            : ($this->relationLoaded('bookingDetails')
                ? $this->bookingDetails->first()
                : $this->bookingDetails()
                    ->with('booking.customer')
                    ->orderByDesc('checkin_date')
                    ->first());

        return [
            'id' => $this->id,
            'name' => $this->name,
            'room_type_code' => strtoupper((string) ($this->roomType?->code ?? $this->roomType?->name ?? '')),
            'status' => $status?->value ?? (string) $this->status,
            'status_label' => $status?->label() ?? 'Không xác định',
            'card_class' => $status?->cardClass() ?? RoomStatus::EMPTY->cardClass(),
            'route_name' => $status?->routeName() ?? RoomStatus::OCCUPIED->routeName(),
            'booking_detail_id' => $latestBookingDetail?->id,
            'show_indicator' => $status !== RoomStatus::EMPTY,
            'is_empty' => $status === RoomStatus::EMPTY,
            'is_maintenance' => $status === RoomStatus::MAINTENANCE,
            'is_confirmed' => $status === RoomStatus::CONFIRMED,
            'guest_name' => $latestBookingDetail?->booking?->customer?->full_name,
            'checkin_at' => $latestBookingDetail?->formatted_checkin_at,
            'checkout_at' => $latestBookingDetail?->formatted_checkout_at,
        ];
    }
}
