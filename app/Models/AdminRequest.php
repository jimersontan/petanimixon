<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRequest extends Model
{
    use HasFactory;

    protected $table = 'admin_requests';

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    /**
     * mark the password attribute as hashed when setting
     */
    public function setPasswordAttribute($value)
    {
        // if already hashed, leave alone
        if (\Illuminate\Support\Facades\Hash::needsRehash($value)) {
            $this->attributes['password'] = \Illuminate\Support\Facades\Hash::make($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }
}
