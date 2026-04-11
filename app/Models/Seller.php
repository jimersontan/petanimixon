<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $table = 'sellers';

    protected $fillable = [
        'business_name',
        'business_email',
        'business_phone',
        'business_registration_number',
        'business_registration_number_type',
        'business_description',
        'store_name',
        'store_banner_url',
        'store_description',
        'verification_status',
        'verification_documents_url',
        'rating_average',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function payouts()
    {
        return $this->hasMany(SellerPayout::class);
    }
}
