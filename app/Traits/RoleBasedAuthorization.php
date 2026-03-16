<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

/**
 * RoleBasedAuthorization Trait
 * Provides role-based authorization methods for controllers
 */
trait RoleBasedAuthorization
{
    /**
     * Check if user is Main Admin
     */
    protected function isMainAdmin(): bool
    {
        return Auth::check() && Auth::user()->isMainAdmin();
    }

    /**
     * Check if user is Supervisor or above
     */
    protected function isSupervisor(): bool
    {
        return Auth::check() && Auth::user()->isSupervisor();
    }

    /**
     * Check if user is Staff Admin or above
     */
    protected function isStaffAdmin(): bool
    {
        return Auth::check() && Auth::user()->isStaffAdmin();
    }

    /**
     * Get current user role
     */
    protected function getUserRole(): ?string
    {
        return Auth::check() ? Auth::user()->adminRole() : null;
    }

    /**
     * Abort with 403 if not authorized
     */
    protected function authorizeRole($requiredRole): void
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        $userRole = Auth::user()->adminRole();
        
        if (is_array($requiredRole)) {
            if (!in_array($userRole, $requiredRole)) {
                abort(403, 'Unauthorized');
            }
        } else {
            if ($userRole !== $requiredRole) {
                abort(403, 'Unauthorized');
            }
        }
    }

    /**
     * Check if Staff Admin trying to access admin-only features
     * Staff can only manage products and handle orders
     */
    protected function ensureNotStaffAdmin($message = 'Staff Admin does not have access to this feature'): void
    {
        if ($this->getUserRole() === 'staff_admin') {
            abort(403, $message);
        }
    }

    /**
     * Ensure only Main Admin can access
     */
    protected function ensureMainAdmin($message = 'Only Main Admin can access this'): void
    {
        if (!$this->isMainAdmin()) {
            abort(403, $message);
        }
    }

    /**
     * Ensure only Main Admin or Supervisor can access
     */
    protected function ensureManagerOrAbove($message = 'This action requires Manager permissions or above'): void
    {
        if (!$this->isSupervisor()) {
            abort(403, $message);
        }
    }
}
