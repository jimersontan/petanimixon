<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerPayout extends Model
{
    protected $table = 'seller_payouts';

    protected $fillable = [
        'seller_id',
        'payout_amount',
        'payout_method',
        'payout_status',
        'bank_account_details',
        'transaction_reference',
        'notes',
    ];

    protected $casts = [
        'payout_amount' => 'decimal:2',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
