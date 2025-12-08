<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'reference_type',
        'reference_id',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Notification types
     */
    const TYPE_REGISTRATION_APPROVED = 'registration_approved';
    const TYPE_REGISTRATION_REJECTED = 'registration_rejected';
    const TYPE_ITEM_APPROVED = 'item_approved';
    const TYPE_ITEM_REJECTED = 'item_rejected';
    const TYPE_AUCTION_STARTED = 'auction_started';
    const TYPE_AUCTION_ENDED = 'auction_ended';
    const TYPE_OUTBID = 'outbid';
    const TYPE_AUCTION_WON = 'auction_won';
    const TYPE_AUCTION_LOST = 'auction_lost';
    const TYPE_PAYMENT_RECEIVED = 'payment_received';
    const TYPE_SYSTEM = 'system';

    /**
     * Get the user this notification belongs to
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for recent notifications
     */
    public function scopeRecent($query, int $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Mark as read
     */
    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Create notification for user
     */
    public static function createForUser(
        int $userId,
        string $title,
        string $message,
        string $type = self::TYPE_SYSTEM,
        ?string $referenceType = null,
        ?int $referenceId = null
    ): self {
        return self::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'is_read' => false,
        ]);
    }
}
