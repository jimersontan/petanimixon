<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'user_id', 'rating', 'comment', 'images',
    ];

    protected $casts = [
        'images' => 'array',
        'rating' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(ReviewReply::class)->orderBy('created_at');
    }

    public function likes()
    {
        return $this->hasMany(ReviewLike::class);
    }

    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function getImageUrlsAttribute()
    {
        if (empty($this->images)) return [];
        return collect($this->images)->map(function ($path) {
            if (str_starts_with($path, 'http')) return $path;
            return asset('storage/' . $path);
        })->toArray();
    }
}
