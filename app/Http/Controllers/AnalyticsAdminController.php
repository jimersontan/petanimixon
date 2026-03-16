<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AnalyticsAdminController extends Controller
{
    /**
     * Display basic analytics. For now this mirrors revenue metrics.
     */
    public function index(Request $request)
    {
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
