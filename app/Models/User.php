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
        'pet_type',
        'wants_promos',
        'wants_tips',
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
        'wants_promos' => 'boolean',
        'wants_tips' => 'boolean',
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
     * Record from admin_users for this admin user.
     */
    public function adminProfile()
    {
        return $this->hasOne(AdminUser::class, 'user_id');
    }

    /**
     * Helper to check whether this is an active admin user.
     */
    public function isAdmin(): bool
    {
        $isAdminFlag = ! empty($this->is_admin) || ($this->user_type ?? '') === 'admin';
        if (! $isAdminFlag) {
            return false;
        }

        $profile = $this->adminProfile;
        if ($profile && $profile->is_active === false) {
            return false;
        }

        return true;
    }

    /**
     * Return normalized admin role.
     *
     * - main_admin: top-level admin (previously called super_admin)
     * - supervisor: mid-tier manager
     * - staff_admin: day-to-day staff
     */
    public function adminRole(): ?string
    {
        $type = $this->adminProfile->admin_type ?? null;
        if (! $type) {
            return null;
        }

        if ($type === 'super_admin') {
            return 'main_admin';
        }

        return $type;
    }

    public function isMainAdmin(): bool
    {
        return $this->adminRole() === 'main_admin';
    }

    public function isSupervisor(): bool
    {
        $role = $this->adminRole();
        return in_array($role, ['supervisor', 'main_admin'], true);
    }

    public function isStaffAdmin(): bool
    {
        $role = $this->adminRole();
        return in_array($role, ['staff_admin', 'supervisor', 'main_admin'], true);
    }
}
