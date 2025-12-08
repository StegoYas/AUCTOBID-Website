<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Condition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'quality_rating',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'quality_rating' => 'integer',
    ];

    /**
     * Get items with this condition
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Scope for active conditions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
