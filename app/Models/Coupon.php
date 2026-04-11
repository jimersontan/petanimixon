<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';

    protected $fillable = [
        'coupon_id',
        'coupon_code',
        'coupon_name',
        'description',
        'discount_type',
        'discount_amount',
        'usage_limit_per_user',
        'max_usage_limit',
        'valid_from',
        'valid_until',
        'is_active',
        'applicable_categories',
        'min_order_value',
        'featured_product_id',
        'show_on_homepage',
    ];

    protected $casts = [
        'discount_amount' => 'decimal:2',
        'min_order_value' => 'decimal:2',
        'is_active' => 'boolean',
        'show_on_homepage' => 'boolean',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    public function featuredProduct()
    {
        return $this->belongsTo(Product::class, 'featured_product_id');
    }

    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    /**
     * Scope: only active coupons within valid date ranges.
     */
    public function scopeValid($query)
    {
        return $query->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now());
    }

    /**
     * Check if this coupon has reached its global usage limit.
     */
    public function hasReachedMaxUsage(): bool
    {
        if (is_null($this->max_usage_limit)) {
            return false;
        }
        return $this->usages()->count() >= $this->max_usage_limit;
    }

    /**
     * Check if the given user has exceeded their per-user limit.
     */
    public function hasUserExceededLimit(int $userId): bool
    {
        if (is_null($this->usage_limit_per_user)) {
            return false;
        }
        return $this->usages()->where('user_id', $userId)->count() >= $this->usage_limit_per_user;
    }

    /**
     * Calculate the discount for a given subtotal.
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($this->min_order_value && $subtotal < (float) $this->min_order_value) {
            return 0;
        }

        if ($this->discount_type === 'percent' || $this->discount_type === 'percentage') {
            return round($subtotal * (float) $this->discount_amount / 100, 2);
        }

        return (float) $this->discount_amount;
    }
}
