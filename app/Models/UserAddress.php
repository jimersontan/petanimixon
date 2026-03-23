<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $table = 'user_addresses';

    protected $fillable = [
        'user_id',
        'address',
        'address_type',
        'recipient_name',
        'phone_number',
        'street_address',
        'city_municipality',
        'province',
        'zip_code',
        'region',
        'barangay',
        'delivery_notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
