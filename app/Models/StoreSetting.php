<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    protected $table = 'store_settings';

    protected $fillable = [
        'store_name',
        'store_email',
        'store_phone',
        'store_url',
        'store_description',
        'store_logo_path',
        'timezone',
        'default_currency',
        'extra',
    ];

    protected $casts = [
        'extra' => 'array',
    ];

    /**
     * Full public URL for the store logo.
     */
    public function getLogoFullUrlAttribute(): string
    {
        $raw = $this->store_logo_path;

        if (empty($raw)) {
            return asset('images/logo.png');
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
