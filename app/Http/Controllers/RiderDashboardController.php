<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Events\OrderDelivered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiderDashboardController extends Controller
{
    /**
     * Rider dashboard: stats, active delivery, available orders queue.
     */
    public function index()
    {
        $rider = Auth::user();

        // Today's stats
        $today = now()->startOfDay();
        $todayDeliveries = Order::where('rider_id', $rider->id)
            ->whereDate('created_at', today())
            ->count();

        $completedToday = Order::where('rider_id', $rider->id)
            ->where('order_status', Order::STATUS_DELIVERED)
            ->whereDate('rider_delivered_at', today())
            ->count();

        $totalDeliveries = Order::where('rider_id', $rider->id)
            ->where('order_status', Order::STATUS_DELIVERED)
            ->count();

        // Active delivery (out_for_delivery status for this rider)
        $activeDelivery = Order::where('rider_id', $rider->id)
            ->where('order_status', Order::STATUS_OUT_FOR_DELIVERY)
            ->with(['user', 'orderItems.product', 'shippingAddress'])
            ->first();

        // Available orders (pending/processing, no rider assigned)
        $availableOrders = Order::whereNull('rider_id')
            ->whereIn('order_status', [Order::STATUS_PENDING, Order::STATUS_PROCESSING])
            ->with(['user', 'shippingAddress'])
            ->orderBy('created_at', 'asc')
            ->take(10)
            ->get();

        // Pending pickup (assigned to rider, but not yet picked up)
        $pendingPickup = Order::where('rider_id', $rider->id)
            ->where('order_status', Order::STATUS_OUT_FOR_DELIVERY)
            ->whereNull('rider_picked_up_at')
            ->with(['user', 'orderItems.product', 'shippingAddress'])
            ->get();

        return view('rider.dashboard', [
            'rider' => $rider,
            'todayDeliveries' => $todayDeliveries,
            'completedToday' => $completedToday,
            'totalDeliveries' => $totalDeliveries,
            'activeDelivery' => $activeDelivery,
            'availableOrders' => $availableOrders,
            'pendingPickup' => $pendingPickup,
        ]);
    }

    /**
     * List available orders for pickup.
     */
    public function availableOrders()
    {
        $orders = Order::whereNull('rider_id')
            ->whereIn('order_status', [Order::STATUS_PENDING, Order::STATUS_PROCESSING])
            ->with(['user', 'orderItems.product', 'shippingAddress'])
            ->orderBy('created_at', 'asc')
            ->paginate(15);

        return view('rider.available_orders', [
            'orders' => $orders,
        ]);
    }

    /**
     * Rider accepts/claims an order.
     */
    public function acceptOrder($id)
    {
        $order = Order::where('id', $id)
            ->whereIn('order_status', [Order::STATUS_PENDING, Order::STATUS_PROCESSING])
            ->whereNull('rider_id')
            ->firstOrFail();

        $order->update([
            'rider_id' => Auth::id(),
            'order_status' => Order::STATUS_OUT_FOR_DELIVERY,
        ]);

        $order->refresh();
        $order->notifyRiderAssigned();

        return redirect()->route('rider.active')->with('success', 'Order accepted! Head to the store for pickup.');
    }

    /**
     * Show the rider's current active delivery.
     */
    public function activeDelivery()
    {
        $rider = Auth::user();

        $activeOrders = Order::where('rider_id', $rider->id)
            ->where('order_status', Order::STATUS_OUT_FOR_DELIVERY)
            ->with(['user', 'orderItems.product', 'shippingAddress'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('rider.active_delivery', [
            'activeOrders' => $activeOrders,
        ]);
    }

    /**
     * Mark order as picked up from store.
     */
    public function pickUp($id)
    {
        $order = Order::where('id', $id)
            ->where('rider_id', Auth::id())
            ->where('order_status', Order::STATUS_OUT_FOR_DELIVERY)
            ->firstOrFail();

        $order->update([
            'rider_picked_up_at' => now(),
        ]);

        $order->notifyRiderOutForDelivery();

        return redirect()->route('rider.active')->with('success', 'Order marked as picked up! Now deliver to customer.');
    }

    /**
     * Mark order as delivered.
     */
    public function deliver(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('rider_id', Auth::id())
            ->where('order_status', Order::STATUS_OUT_FOR_DELIVERY)
            ->firstOrFail();

        $order->update([
            'order_status' => Order::STATUS_DELIVERED,
            'payment_status' => Order::PAYMENT_PAID,
            'rider_delivered_at' => now(),
            'rider_notes' => $request->input('rider_notes', ''),
        ]);

        // Dispatch event to reduce stock for delivered order
        OrderDelivered::dispatch($order);

        $order->notifyOrderDelivered();

        return redirect()->route('rider.dashboard')->with('success', 'Delivery completed! Great job! 🎉');
    }

    /**
     * Delivery history.
     */
    public function history(Request $request)
    {
        $rider = Auth::user();

        $query = Order::where('rider_id', $rider->id)
            ->whereIn('order_status', [Order::STATUS_DELIVERED, Order::STATUS_CANCELLED])
            ->with(['user', 'orderItems.product', 'shippingAddress']);

        // Date filter
        $days = (int) $request->get('days', 30);
        if ($days > 0) {
            $query->where('created_at', '>=', now()->subDays($days));
        }

        $orders = $query->orderByDesc('rider_delivered_at')
            ->paginate(15)
            ->appends($request->query());

        // Stats
        $allTime = Order::where('rider_id', $rider->id);
        $stats = [
            'total' => (clone $allTime)->where('order_status', Order::STATUS_DELIVERED)->count(),
            'this_week' => (clone $allTime)->where('order_status', Order::STATUS_DELIVERED)
                ->where('rider_delivered_at', '>=', now()->startOfWeek())->count(),
            'this_month' => (clone $allTime)->where('order_status', Order::STATUS_DELIVERED)
                ->where('rider_delivered_at', '>=', now()->startOfMonth())->count(),
        ];

        return view('rider.history', [
            'orders' => $orders,
            'stats' => $stats,
            'days' => $days,
        ]);
    }

    /**
     * Read-only products view for riders to verify items.
     */
    public function products(Request $request)
    {
        $query = Product::where('product_status', 'active')
            ->with(['category', 'reviews']);

        if ($search = $request->get('search')) {
            $query->where('product_name', 'like', "%{$search}%");
        }

        $products = $query->orderBy('product_name')
            ->paginate(20)
            ->appends($request->query());

        return view('rider.products', [
            'products' => $products,
        ]);
    }
}
