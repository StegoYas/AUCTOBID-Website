<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_id',
        'user_id',
        'amount',
        'is_winning',
        'is_auto_bid',
        'ip_address',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_winning' => 'boolean',
        'is_auto_bid' => 'boolean',
    ];

    /**
     * Get the auction this bid belongs to
     */
    public function auction(): BelongsTo
    {
        return $this->belongsTo(Auction::class);
    }

    /**
     * Get the bidder
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Alias for user relationship
     */
    public function bidder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Check if this is the winning bid
     */
    public function isWinning(): bool
    {
        return $this->is_winning === true;
    }

    /**
     * Format amount for display
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}
