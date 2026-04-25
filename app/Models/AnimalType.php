<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalType extends Model
{
    protected $table = 'animal_types';

    protected $fillable = ['animal_type', 'status', 'image_url', 'sort_order', 'life_stages'];

    protected $casts = [
        'life_stages' => 'array',
    ];

    /**
     * Products that belong to this animal type (many-to-many).
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_animal_types')
                    ->withPivot('life_stage')
                    ->withTimestamps();
    }

    public function getImageFullUrlAttribute(): string
    {
        $raw = $this->getRawOriginal('image_url') ?? $this->attributes['image_url'] ?? null;

        if (empty($raw)) {
            return asset('images/placeholder.png');
        }

        $raw = str_replace('\\', '/', trim((string) $raw));

        if (strpos($raw, 'http://') === 0 || strpos($raw, 'https://') === 0) {
            return $raw;
        }

        $raw = ltrim($raw, '/');
        if (strpos($raw, 'storage/') === 0) {
            $raw = substr($raw, strlen('storage/'));
        } elseif (strpos($raw, 'public/') === 0) {
            $raw = substr($raw, strlen('public/'));
        }

        return asset('storage/' . ltrim($raw, '/'));
    }
}
