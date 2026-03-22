<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class ClientOrdersController extends Controller
{
    /**
     * Show the current user's orders (customer-facing).
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Order::query()
            ->where('user_id', $user->id)
            ->with(['orderItems.product']);

        // Status filter
        $statusFilter = $request->get('status', 'all');
        if ($statusFilter !== 'all') {
            $query->where('order_status', $statusFilter);
        }

        $orders = $query
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        // Order summary stats
        $allOrders = Order::where('user_id', $user->id);
        $stats = [
            'total' => (clone $allOrders)->count(),
            'pending' => (clone $allOrders)->where('order_status', 'pending')->count(),
            'processing' => (clone $allOrders)->where('order_status', 'processing')->count(),
            'shipped' => (clone $allOrders)->where('order_status', 'shipped')->count(),
            'delivered' => (clone $allOrders)->where('order_status', 'delivered')->count(),
            'cancelled' => (clone $allOrders)->where('order_status', 'cancelled')->count(),
        ];

        // "You may also like" - random active products
        $recommendedProducts = \App\Models\Product::where('product_status', 'active')
            ->with('reviews')
            ->withCount('reviews')
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('frontend.orders', [
            'orders' => $orders,
            'stats' => $stats,
            'statusFilter' => $statusFilter,
            'recommendedProducts' => $recommendedProducts,
        ]);
    }
}
