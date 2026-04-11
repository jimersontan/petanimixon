<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalType extends Model
{
    protected $table = 'animal_types';

    protected $fillable = ['animal_type', 'status', 'image_url', 'sort_order', 'life_stages'];

    protected $casts = [
        'life_stages' => 'array',
    ];

    /**
     * Products that belong to this animal type (many-to-many).
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_animal_types')
                    ->withPivot('life_stage')
                    ->withTimestamps();
    }
}
