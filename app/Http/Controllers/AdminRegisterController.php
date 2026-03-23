<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminRegisterController extends Controller
{
    /**
     * Show the administrator registration page.
     */
    public function show()
    {
        return view('admin_register');
    }

    /**
     * Handle a registration request for an administrator account.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_requests,email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // store pending admin request
        \App\Models\AdminRequest::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'status' => 'pending',
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Your request has been submitted and is awaiting approval.',
            ]);
        }

        return redirect()->route('admin.register')->with('success', 'Request submitted – please wait for an administrator to approve it.');
    }
}
