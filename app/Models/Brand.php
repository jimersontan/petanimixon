<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo_path', 'is_active', 'is_featured', 'description', 'website_url'];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Products that mention this brand name.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'brand_name', 'name');
    }

    /**
     * Full public URL for the brand logo.
     * Normalizes stored paths (e.g. "brands/abc.jpg", "/storage/brands/abc.jpg").
     */
    public function getLogoFullUrlAttribute(): string
    {
        $raw = $this->logo_path;

        if (empty($raw)) {
            return '';
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
