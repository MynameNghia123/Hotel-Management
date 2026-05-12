<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    public $timestamps = false;

    protected $fillable = ['chat_session_id', 'role', 'content'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Mỗi tin nhắn thuộc về một phiên chat.
     */
    public function chatSession(): BelongsTo
    {
        return $this->belongsTo(ChatSession::class);
    }
}
