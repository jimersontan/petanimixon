<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo_url',
        'tracking_url',
        'is_active',
        'deliveries_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the full tracking URL for a given tracking number.
     */
    public function getTrackingLink(string $trackingNumber): string
    {
        return $this->tracking_url . $trackingNumber;
    }

    /**
     * Scope: only active couriers.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
