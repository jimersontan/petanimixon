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
}
