<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * List admin users
     */
    public function index()
    {
        $admins = User::where('is_admin', true)->get();
        return view('admin_users.index', compact('admins'));
    }

    /**
     * Show form to create a new admin
     */
    public function create()
    {
        return view('admin_users.create');
    }

    /**
     * Store new admin
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['is_admin'] = true;
        $user = User::create($data);

        return redirect()->route('admin.users')->with('success', 'Admin user created.');
    }

    /**
     * Show form to edit an existing admin
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin_users.edit', compact('user'));
    }

    /**
     * Update an existing admin
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

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
