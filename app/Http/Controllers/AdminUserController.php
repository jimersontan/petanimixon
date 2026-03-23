<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    private const ROLES = [
        'main_admin' => 'Main Admin',
        'supervisor' => 'Supervisor',
        'staff_admin' => 'Staff Admin',
    ];

    private function ensureAdminManager()
    {
        if (! Auth::check()) {
            abort(403);
        }

        $user = Auth::user();
        if (! $user->isMainAdmin() && ! $user->isSupervisor()) {
            abort(403);
        }
    }

    /**
     * List admin users
     */
    public function index()
    {
        $this->ensureAdminManager();

        $admins = User::where(function ($query) {
            $query->where('is_admin', true)->orWhere('user_type', 'admin');
        })->with('adminProfile')->get();

        $roles = self::ROLES;
        return view('admin_users.index', compact('admins', 'roles'));
    }

    /**
     * Show form to create a new admin
     */
    public function create()
    {
        $this->ensureAdminManager();

        $roles = Auth::user()->isMainAdmin() ? self::ROLES : ['staff_admin' => 'Staff Admin'];
        return view('admin_users.create', compact('roles'));
    }

    /**
     * Store new admin
     */
    public function store(Request $request)
    {
        $this->ensureAdminManager();

        $allowedRoles = Auth::user()->isMainAdmin() ? array_keys(self::ROLES) : ['staff_admin'];
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:' . implode(',', $allowedRoles),
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['is_admin'] = true;
        $data['user_type'] = 'admin';

        $user = User::create($data);

        // Ensure admin profile exists with the chosen role.
        
        
        \App\Models\AdminUser::updateOrCreate(
            ['user_id' => $user->id],
            [
                'admin_user_id' => (string) $user->id,
                'admin_type' => $data['role'],
                'permissions' => null,
                'is_active' => true,
            ]
        );

        return redirect()->route('admin.users')->with('success', 'Admin user created.');
    }

    private function canManageAdmin(User $target): bool
    {
        $current = Auth::user();
        if ($current->isMainAdmin()) {
            return true;
        }

        // Supervisors can only manage staff-level admins.
        if ($current->isSupervisor()) {
            return $target->adminRole() === 'staff_admin';
        }

        return false;
    }

    /**
     * Show form to edit an existing admin
     */
    public function edit($id)
    {
        $this->ensureAdminManager();

        $user = User::findOrFail($id);
        if (! $this->canManageAdmin($user)) {
            abort(403);
        }

        $roles = self::ROLES;
        return view('admin_users.edit', compact('user', 'roles'));
    }

    /**
     * Update an existing admin
     */
    public function update(Request $request, $id)
    {
        $this->ensureAdminManager();

        $user = User::findOrFail($id);
        if (! $this->canManageAdmin($user)) {
            abort(403);
        }

        $allowedRoles = Auth::user()->isMainAdmin() ? array_keys(self::ROLES) : ['staff_admin'];

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required|in:' . implode(',', $allowedRoles),
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:6|confirmed';
        }

        $data = $request->validate($rules);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        \App\Models\AdminUser::updateOrCreate(
            ['user_id' => $user->id],
            ['admin_type' => $data['role']]
        );

        return redirect()->route('admin.users')->with('success', 'Admin user updated.');
    }

    /**
     * Show profile page for logged-in admin
     */
    public function profile()
    {
        $user = Auth::user();
        return view('admin_profile', compact('user'));
    }

    /**
     * Update profile of logged-in admin
     */
    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:6|confirmed';
        }

        $data = $request->validate($rules);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return back()->with('success', 'Profile updated.');
    }
}
