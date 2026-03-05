<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'password',
        'is_admin',
        'email_verified_at',
        'user_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Full name for display.
     */
    public function getFullNameAttribute(): string
    {
        if (! empty($this->first_name) || ! empty($this->last_name)) {
            return trim($this->first_name . ' ' . $this->last_name) ?: $this->email;
        }
        return $this->name ?? $this->email;
    }

    /**
     * Related admin profile (row in admin_users).
     */
    public function adminProfile()
    {
        return $this->hasOne(AdminUser::class, 'user_id');
    }
}
