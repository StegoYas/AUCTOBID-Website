<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
    ];

    /**
     * Get a setting value
     */
    public static function getValue(string $key, mixed $default = null): mixed
    {
        $setting = self::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        return self::castValue($setting->value, $setting->type);
    }

    /**
     * Set a setting value
     */
    public static function setValue(string $key, mixed $value, string $type = 'string', ?string $description = null): void
    {
        self::updateOrCreate(
            ['key' => $key],
            [
                'value' => (string) $value,
                'type' => $type,
                'description' => $description,
            ]
        );
    }

    /**
     * Cast value based on type
     */
    protected static function castValue(string $value, string $type): mixed
    {
        return match ($type) {
            'integer', 'int' => (int) $value,
            'float', 'double', 'decimal' => (float) $value,
            'boolean', 'bool' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'json', 'array' => json_decode($value, true),
            default => $value,
        };
    }

    /**
     * Get typed value
     */
    public function getTypedValueAttribute(): mixed
    {
        return self::castValue($this->value, $this->type);
    }

    /**
     * Default settings
     */
    public static function getDefaults(): array
    {
        return [
            'commission_percentage' => [
                'value' => '5',
                'type' => 'float',
                'description' => 'Commission percentage taken from winning bid',
            ],
            'default_auction_duration' => [
                'value' => '7',
                'type' => 'integer',
                'description' => 'Default auction duration in days',
            ],
            'minimum_bid_increment' => [
                'value' => '10000',
                'type' => 'float',
                'description' => 'Default minimum bid increment in Rupiah',
            ],
            'max_item_images' => [
                'value' => '5',
                'type' => 'integer',
                'description' => 'Maximum number of images per item',
            ],
        ];
    }

    /**
     * Initialize default settings
     */
    public static function initializeDefaults(): void
    {
        foreach (self::getDefaults() as $key => $config) {
            if (!self::where('key', $key)->exists()) {
                self::create([
                    'key' => $key,
                    'value' => $config['value'],
                    'type' => $config['type'],
                    'description' => $config['description'],
                ]);
            }
        }
    }
}
