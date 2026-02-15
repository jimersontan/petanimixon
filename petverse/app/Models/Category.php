<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'category_name',
        'parent_category_id',
        'is_active',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'animal_category_id');
    }
}
