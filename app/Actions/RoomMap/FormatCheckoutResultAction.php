<?php

namespace App\Actions\RoomMap;

class FormatCheckoutResultAction
{
    private const VAT_RATE = 0.1;

    public function execute(array $result, int $fallbackRoomId): array
    {
        $invoiceRoomId = (int) (($result['processed_room_ids'][0] ?? $fallbackRoomId));
        $subtotal = (float) ($result['subtotal'] ?? 0);
        $vatAmount = $subtotal * self::VAT_RATE;
        $grandTotal = $subtotal + $vatAmount;

        return [
            'invoice_room_id' => $invoiceRoomId,
            'processed_room_ids' => $result['processed_room_ids'] ?? [],
            'processed_count' => (int) ($result['processed_count'] ?? 0),
            'pricing_mode' => $result['pricing_mode'] ?? null,
            'subtotal' => $subtotal,
            'vat_amount' => $vatAmount,
            'grand_total' => $grandTotal,
        ];
    }
}
