<?php

namespace App\Models;

use App\Enums\RepairTicketStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepairTicket extends Model
{
    protected $table = 'maintenance_tickets';

    protected $fillable = [
        'room_id',
        'reported_date',
        'issue_description',
        'technician_note',
        'status',
        'repair_cost',
    ];

    protected $casts = [
        'status' => RepairTicketStatus::class,
        'reported_date' => 'date',
        'repair_cost' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the room that has the repair ticket
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
