<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Traits\RoleBasedAuthorization;

class AnalyticsAdminController extends Controller
{
    use RoleBasedAuthorization;

    /**
     * Display analytics dashboard.
     * Main Admin: sees comprehensive all-system analytics
     * Supervisor: sees category-specific analytics (can be filtered by category assignment)
     */
    public function index(Request $request)
    {
        // Supervisor can view analytics but may have category restrictions
        $this->ensureManagerOrAbove('Only Main Admin and Supervisor can view analytics.');
        $days = (int) $request->get('days', 30);
        $from = now()->subDays($days);

        $query = Order::query();
        if ($request->has('days')) {
            $query->where('created_at', '>=', $from);
        }

        $totalOrders = (clone $query)->count();
        $totalRevenue = (clone $query)->sum('total_amount');

        $stats = [
            'orders' => $totalOrders,
            'revenue' => $totalRevenue,
        ];

        return view('analytics_admin', [
            'stats' => $stats,
            'days' => $days,
        ]);
    }
}
