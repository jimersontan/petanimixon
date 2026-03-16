<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Traits\RoleBasedAuthorization;

class OrdersController extends Controller
{
    use RoleBasedAuthorization;

    /**
     * Display orders list and stats (from database).
     * Main Admin: sees all orders with full details
     * Supervisor: sees all orders, can approve/handle escalations
     * Staff Admin: sees all orders but limited capabilities
     */
    public function index(Request $request)
    {
        $days = (int) $request->get('days', 30);
        $from = now()->subDays($days);

        $emptyStats = [
            'total' => 0,
            'pending' => 0,
            'completed' => 0,
            'cancelled' => 0,
        ];

        try {
            $query = Order::query()->where('created_at', '>=', $from);

            $stats = [
                'total' => (clone $query)->count(),
                'pending' => (clone $query)->where('order_status', Order::STATUS_PENDING)->count(),
                'completed' => (clone $query)->where('order_status', Order::STATUS_DELIVERED)->count(),
                'cancelled' => (clone $query)->where('order_status', Order::STATUS_CANCELLED)->count(),
            ];

            $orders = Order::query()
                ->where('created_at', '>=', $from)
                ->with(['user', 'orderItems' => function ($q) {
                    $q->with(['product' => function ($q) {
                        $q->with('category');
                    }]);
                }])
                ->orderByDesc('created_at')
                ->paginate(15);

            return view('orders', [
                'orders' => $orders,
                'stats' => $stats,
                'days' => $days,
            ]);
        } catch (\Throwable $e) {
            $orders = new LengthAwarePaginator([], 0, 15, 1, ['path' => $request->url(), 'query' => $request->query()]);
            return view('orders', [
                'orders' => $orders,
                'stats' => $emptyStats,
                'days' => $days,
            ]);
        }
    }
}
