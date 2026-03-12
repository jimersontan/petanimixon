<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminRequest;
use App\Models\User;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

class AdminRequestController extends Controller
{
    /**
     * List all admin creation requests (pending, approved, declined).
     */
    public function index()
    {
        $requests = AdminRequest::orderBy('created_at', 'desc')->get();
        return view('admin_requests.index', compact('requests'));
    }

    /**
     * Approve a pending request by creating real admin user.
     */
    public function approve($id)
    {
        $req = AdminRequest::findOrFail($id);
        if ($req->status !== 'pending') {
            return back()->with('error', 'Request has already been processed.');
        }

        // check again that email is not already in users table
        if (User::where('email', $req->email)->exists()) {
            $req->status = 'declined';
            $req->save();
            return back()->with('error', 'Email already exists in user table; request declined.');
        }

        // build user data using same name splitting logic as before
        $userData = [
            'email' => $req->email,
            'password' => $req->password,
            'is_admin' => true,
            'user_type' => 'admin',
            'email_verified_at' => now(),
        ];
        if (\Schema::hasColumn('users', 'first_name')) {
            $parts = preg_split('/\s+/', trim($req->name), 2);
            $userData['first_name'] = $parts[0] ?? '';
            $userData['last_name'] = $parts[1] ?? '';
            if (\Schema::hasColumn('users', 'name')) {
                $userData['name'] = $req->name;
            }
        } else {
            $userData['name'] = $req->name;
        }

        $user = User::create($userData);
        if ($user) {
            AdminUser::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'admin_user_id' => (string) $user->id,
                    'admin_type' => 'staff',
                    'permissions' => null,
                    'is_active' => true,
                ]
            );
        }

        $req->status = 'approved';
        $req->save();

        return back()->with('success', 'Request approved and admin account created.');
    }

    /**
     * Decline a pending request.
     */
    public function decline($id)
    {
        $req = AdminRequest::findOrFail($id);
        if ($req->status !== 'pending') {
            return back()->with('error', 'Request has already been processed.');
        }
        $req->status = 'declined';
        $req->save();
        return back()->with('success', 'Request declined.');
    }
}
