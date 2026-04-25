<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'category_name',
        'parent_category_id',
        'is_active',
        'description',
        'image_url',
        'sort_order',
        'is_featured',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'animal_category_id');
    }

    /**
     * Parent category for hierarchical lists.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    /**
     * Full public URL for the category image.
     * Normalizes stored paths (e.g. "categories/abc.jpg", "/storage/categories/abc.jpg").
     */
    public function getImageFullUrlAttribute(): string
    {
        $raw = $this->attributes['image_url'] ?? null;

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
