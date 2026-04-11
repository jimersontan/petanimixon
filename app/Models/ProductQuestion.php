<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductQuestion extends Model
{
    protected $table = 'product_questions';

    protected $fillable = [
        'product_id',
        'user_id',
        'product_id_field',
        'question_text',
        'answer_text',
        'display_order',
        'is_active',
        'view_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'view_count' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnanswered($query)
    {
        return $query->whereNull('answer_text')->orWhere('answer_text', '');
    }

    public function scopeAnswered($query)
    {
        return $query->whereNotNull('answer_text')->where('answer_text', '!=', '');
    }
}
