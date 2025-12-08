<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'condition_id',
        'name',
        'description',
        'starting_price',
        'minimum_bid_increment',
        'status',
        'rejection_reason',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'starting_price' => 'decimal:2',
        'minimum_bid_increment' => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    /**
     * Get the owner of this item
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Alias for user relationship
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the condition
     */
    public function condition(): BelongsTo
    {
        return $this->belongsTo(Condition::class);
    }

    /**
     * Get who approved this item
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get all images for this item
     */
    public function images(): HasMany
    {
        return $this->hasMany(ItemImage::class)->orderBy('sort_order');
    }

    /**
     * Get the primary image
     */
    public function primaryImage(): HasOne
    {
        return $this->hasOne(ItemImage::class)->where('is_primary', true);
    }

    /**
     * Get the auction for this item
     */
    public function auction(): HasOne
    {
        return $this->hasOne(Auction::class);
    }

    /**
     * Get all auctions (including history)
     */
    public function auctions(): HasMany
    {
        return $this->hasMany(Auction::class);
    }

    /**
     * Scope for pending items
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for approved items
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for items ready to auction
     */
    public function scopeReadyForAuction($query)
    {
        return $query->whereIn('status', ['approved']);
    }

    /**
     * Check if item is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if item is approved
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if item is auctioning
     */
    public function isAuctioning(): bool
    {
        return $this->status === 'auctioning';
    }
}
