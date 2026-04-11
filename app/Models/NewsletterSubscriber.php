<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $table = 'newsletter_subscribers';

    protected $fillable = [
        'subscriber_id',
        'email',
        'first_name',
        'subscription_status',
        'subscription_source',
        'unsubscribed_date',
        'user_id',
        'subscription_date',
    ];
}
