<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RiderAdminController extends Controller
{
    /**
     * Admin: List all riders.
     */
    public function index()
    {
        $riders = User::where('user_type', 'rider')
            ->withCount(['riderOrders as total_deliveries' => function ($q) {
                $q->where('order_status', Order::STATUS_DELIVERED);
            }])
            ->withCount(['riderOrders as active_deliveries' => function ($q) {
                $q->where('order_status', Order::STATUS_OUT_FOR_DELIVERY);
            }])
            ->orderByDesc('created_at')
            ->paginate(15);

        // Stats
        $totalRiders = User::where('user_type', 'rider')->count();
        $activeRiders = User::where('user_type', 'rider')->where('account_status', 'active')->count();
        $deliveriesToday = Order::where('order_status', Order::STATUS_DELIVERED)
            ->whereDate('rider_delivered_at', today())
            ->whereNotNull('rider_id')
            ->count();

        return view('riders_admin', [
            'riders' => $riders,
            'totalRiders' => $totalRiders,
            'activeRiders' => $activeRiders,
            'deliveriesToday' => $deliveriesToday,
        ]);
    }

    /**
     * Admin: Show create rider form.
     */
    public function create()
    {
        return view('riders_admin', ['showCreateModal' => true]);
    }

    /**
     * Admin: Store a new rider.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'] ?? null,
            'password' => Hash::make($validated['password']),
            'user_type' => 'rider',
            'account_status' => 'active',
            'email_verified_at' => now(),
        ]);

        return redirect()->route('riders.admin')->with('success', 'Rider account created successfully!');
    }

    /**
     * Admin: Edit rider form.
     */
    public function edit($id)
    {
        $rider = User::where('id', $id)->where('user_type', 'rider')->firstOrFail();

        return view('riders_admin', [
            'editRider' => $rider,
            'showEditModal' => true,
        ]);
    }

    /**
     * Admin: Update rider details.
     */
    public function update(Request $request, $id)
    {
        $rider = User::where('id', $id)->where('user_type', 'rider')->firstOrFail();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $rider->id,
            'phone_number' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);

        $rider->first_name = $validated['first_name'];
        $rider->last_name = $validated['last_name'];
        $rider->email = $validated['email'];
        $rider->phone_number = $validated['phone_number'] ?? $rider->phone_number;

        if (!empty($validated['password'])) {
            $rider->password = Hash::make($validated['password']);
        }

        $rider->save();

        return redirect()->route('riders.admin')->with('success', 'Rider updated successfully!');
    }

    /**
     * Admin: Toggle rider active/inactive status.
     */
    public function toggleStatus($id)
    {
        $rider = User::where('id', $id)->where('user_type', 'rider')->firstOrFail();

        $rider->account_status = $rider->account_status === 'active' ? 'suspended' : 'active';
        $rider->save();

        $status = $rider->account_status === 'active' ? 'activated' : 'deactivated';
        return redirect()->route('riders.admin')->with('success', "Rider {$status} successfully!");
    }
}
