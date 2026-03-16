<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Traits\RoleBasedAuthorization;

class RevenueAdminController extends Controller
{
    use RoleBasedAuthorization;

    /**
     * Display revenue metrics.
     * Only Main Admin can view financial/revenue reports
     */
    public function index(Request $request)
    {
        $this->ensureMainAdmin('Only Main Admin can view revenue reports.');
        $days = (int) $request->get('days', 30);
        $from = now()->subDays($days);

        $query = Order::query();
        if ($request->has('days')) {
            $query->where('created_at', '>=', $from);
        }

        $totalOrders = (clone $query)->count();
        $totalRevenue = (clone $query)->sum('total_amount');
        $avgOrderValue = $totalOrders ? $totalRevenue / $totalOrders : 0;
        $refunds = (clone $query)->where('order_status', Order::STATUS_CANCELLED)->count();

        $stats = [
            'total_revenue' => $totalRevenue,
            'orders' => $totalOrders,
            'avg_order_value' => $avgOrderValue,
            'refunds' => $refunds,
        ];

        return view('revenue_admin', [
            'stats' => $stats,
            'days' => $days,
        ]);
    }
}
