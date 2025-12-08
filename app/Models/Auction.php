<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'opened_by',
        'start_time',
        'end_time',
        'current_price',
        'total_bids',
        'status',
        'winner_id',
        'final_price',
        'commission_amount',
        'payment_status',
        'paid_at',
        'closed_at',
        'closed_by',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'current_price' => 'decimal:2',
        'final_price' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'closed_at' => 'datetime',
        'total_bids' => 'integer',
    ];

    /**
     * Get the item being auctioned
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get who opened the auction
     */
    public function openedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    /**
     * Get who closed the auction
     */
    public function closedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    /**
     * Get the winner
     */
    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    /**
     * Get all bids for this auction
     */
    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class)->orderBy('amount', 'desc');
    }

    /**
     * Get the winning bid
     */
    public function winningBid()
    {
        return $this->hasOne(Bid::class)->where('is_winning', true);
    }

    /**
     * Scope for active auctions
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('end_time', '>', now());
    }

    /**
     * Scope for scheduled auctions
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    /**
     * Scope for ended auctions
     */
    public function scopeEnded($query)
    {
        return $query->where('status', 'ended');
    }

    /**
     * Scope for auctions that need to be started
     */
    public function scopeNeedsToStart($query)
    {
        return $query->where('status', 'scheduled')
            ->where('start_time', '<=', now());
    }

    /**
     * Scope for auctions that need to be ended
     */
    public function scopeNeedsToEnd($query)
    {
        return $query->where('status', 'active')
            ->where('end_time', '<=', now());
    }

    /**
     * Check if auction is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && $this->end_time > now();
    }

    /**
     * Check if auction is ended
     */
    public function isEnded(): bool
    {
        return $this->status === 'ended';
    }

    /**
     * Get time remaining as string
     */
    public function getTimeRemainingAttribute(): ?string
    {
        if (!$this->isActive()) {
            return null;
        }
        
        $diff = now()->diff($this->end_time);
        
        if ($diff->days > 0) {
            return $diff->format('%d hari %h jam');
        } elseif ($diff->h > 0) {
            return $diff->format('%h jam %i menit');
        } else {
            return $diff->format('%i menit %s detik');
        }
    }

    /**
     * Calculate winner using stored procedure
     */
    public function calculateWinner(): array
    {
        $result = DB::select('CALL calculate_auction_winner(?)', [$this->id]);
        $this->refresh();
        
        return [
            'winner_id' => $result[0]->winner_id ?? null,
            'final_price' => $result[0]->final_price ?? null,
            'commission_amount' => $result[0]->commission_amount ?? null,
        ];
    }
}
