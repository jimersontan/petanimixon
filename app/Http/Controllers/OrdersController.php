<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    /**
     * Display orders list and stats (from database).
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
                }, 'courier', 'rider'])
                ->orderByDesc('created_at')
                ->paginate(15)
                ->appends($request->query());

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

    /**
     * Display the specified order detail page.
     */
    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.product', 'shippingAddress', 'courier', 'rider', 'statusHistory.changedByUser'])
            ->findOrFail($id);

        $activeRiders = User::where('user_type', 'rider')->where('account_status', 'active')->get();

        return view('order_detail', compact('order', 'activeRiders'));
    }

    /**
     * Advance the order status to the next step.
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $nextStatus = $order->getNextStatus();
        
        if (!$nextStatus) {
            return back()->with('error', 'Cannot advance status further.');
        }

        // Constraints
        if ($order->isCourier() && $nextStatus === Order::STATUS_IN_TRANSIT && !$order->tracking_number) {
            return back()->with('error', 'Please enter a tracking number before in-transit.');
        }

        $order->update(['order_status' => $nextStatus]);
        $order->recordStatusChange($nextStatus, Auth::id(), "Status manually updated by admin.");

        // Notifications
        if ($nextStatus === Order::STATUS_DELIVERED) {
            $order->update(['payment_status' => Order::PAYMENT_PAID]);
            $order->notifyOrderDelivered();
            \App\Events\OrderDelivered::dispatch($order);
        }

        return back()->with('success', 'Order status updated to ' . $order->status_label);
    }

    /**
     * Assign a rider to a local order.
     */
    public function assignRider(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if (!$order->isLocal()) {
            return back()->with('error', 'Can only assign riders to local deliveries.');
        }

        $request->validate([
            'rider_id' => 'required|exists:users,id',
        ]);

        $order->update([
            'rider_id' => $request->rider_id,
            'order_status' => Order::STATUS_ASSIGNED_TO_RIDER,
        ]);

        // Force reload rider reference
        $order->load('rider');

        $order->recordStatusChange(Order::STATUS_ASSIGNED_TO_RIDER, Auth::id(), 'Assigned to rider ' . $order->rider->full_name);
        $order->notifyRiderAssigned();

        UserNotification::createNotification(
            $order->rider_id,
            'delivery',
            'New delivery assignment',
            "Order {$order->display_id} is ready for pickup.",
            '🛵',
            '#059669',
            $order->id,
            'Order',
            ['assigned_by' => Auth::id()]
        );

        return back()->with('success', 'Rider assigned successfully.');
    }

    /**
     * Save tracking number for courier order.
     */
    public function saveTracking(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if (!$order->isCourier()) {
            return back()->with('error', 'Can only add tracking numbers to courier shipments.');
        }

        $request->validate([
            'tracking_number' => 'required|string|max:255',
        ]);

        $order->update([
            'tracking_number' => $request->tracking_number,
        ]);

        $order->recordStatusChange($order->order_status, Auth::id(), 'Tracking number added: ' . $request->tracking_number);

        return back()->with('success', 'Tracking number saved.');
    }
}
