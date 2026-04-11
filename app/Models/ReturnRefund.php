<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnRefund extends Model
{
    protected $table = 'return_refunds';

    protected $fillable = [
        'order_item_id',
        'seller_id',
        'return_refund_id',
        'return_reason',
        'return_reason_description',
        'return_type',
        'refund_amount',
        'refund_status',
        'admin_notes',
        'received_at',
        'proof_of_delivery_url',
        'return_shipping_address_url',
        'seller_response',
        'seller_response_date',
    ];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Get the order through the order item.
     */
    public function getOrderAttribute()
    {
        return $this->orderItem ? $this->orderItem->order : null;
    }
}
