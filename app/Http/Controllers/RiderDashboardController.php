<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\UserNotification;
use App\Events\OrderDelivered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        // Current assignment: either waiting for pickup or already out for delivery
        $activeDelivery = Order::where('rider_id', $rider->id)
            ->whereIn('order_status', [Order::STATUS_RIDER_CONFIRMED, Order::STATUS_OUT_FOR_DELIVERY])
            ->with(['user', 'orderItems.product', 'shippingAddress'])
            ->orderByRaw("CASE WHEN order_status = ? THEN 0 ELSE 1 END", [Order::STATUS_RIDER_CONFIRMED])
            ->first();

        // Available orders: pool of local orders ready for dispatch (unassigned OR assigned to this rider)
        $availableOrders = Order::where('order_status', Order::STATUS_ASSIGNED_TO_RIDER)
            ->where('shipping_type', 'local')
            ->where(function($q) use ($rider) {
                $q->whereNull('rider_id')
                  ->orWhere('rider_id', $rider->id);
            })
            ->with(['user', 'shippingAddress', 'orderItems'])
            ->orderBy('created_at', 'asc')
            ->take(10)
            ->get();

        return view('rider.dashboard', [
            'rider' => $rider,
            'todayDeliveries' => $todayDeliveries,
            'completedToday' => $completedToday,
            'totalDeliveries' => $totalDeliveries,
            'activeDelivery' => $activeDelivery,
            'availableOrders' => $availableOrders,
        ]);
    }

    public function availableOrders()
    {
        $rider = Auth::user();

        $hasCurrentAssignment = false; // Kept for backwards compatibility if needed, but not restricting

        $orders = Order::where('order_status', Order::STATUS_ASSIGNED_TO_RIDER)
            ->where('shipping_type', 'local')
            ->where(function($q) use ($rider) {
                $q->whereNull('rider_id')
                  ->orWhere('rider_id', $rider->id);
            })
            ->with(['user', 'orderItems.product', 'shippingAddress'])
            ->orderBy('created_at', 'asc')
            ->paginate(15);

        return view('rider.available_orders', [
            'orders' => $orders,
            'hasCurrentAssignment' => $hasCurrentAssignment,
        ]);
    }

    public function acceptOrder($id)
    {
        $order = Order::where('id', $id)
            ->where('order_status', Order::STATUS_ASSIGNED_TO_RIDER)
            ->where(function($q) {
                $q->whereNull('rider_id')
                  ->orWhere('rider_id', Auth::id());
            })
            ->firstOrFail();

        // Auto-assign this rider to the order
        $order->update([
            'rider_id' => Auth::id(),
            'order_status' => Order::STATUS_RIDER_CONFIRMED,
        ]);

        $order->recordStatusChange(Order::STATUS_RIDER_CONFIRMED, Auth::id(), 'Rider ' . Auth::user()->full_name . ' claimed and confirmed pickup via Rider App.');

        $order->refresh();
        $order->notifyRiderAssigned();
        $this->notifyAdminsAboutRiderUpdate(
            $order,
            'Rider confirmed pickup task',
            Auth::user()->full_name . " claimed order {$order->display_id}.",
            '🛵',
            '#0ea5e9'
        );

        return redirect()->route('rider.active')->with('success', 'Order claimed! Head to the store for pickup. 🎉');
    }

    /**
     * Show the rider's current active delivery.
     */
    public function activeDelivery()
    {
        $rider = Auth::user();

        $activeOrders = Order::where('rider_id', $rider->id)
            ->whereIn('order_status', [Order::STATUS_RIDER_CONFIRMED, Order::STATUS_OUT_FOR_DELIVERY])
            ->with(['user', 'orderItems.product', 'shippingAddress'])
            ->orderByRaw("CASE WHEN order_status = ? THEN 0 ELSE 1 END", [Order::STATUS_RIDER_CONFIRMED])
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
            ->where('order_status', Order::STATUS_RIDER_CONFIRMED)
            ->with('shippingAddress')
            ->firstOrFail();

        // Store location: Pet Markt-PH Store, Libertad, Butuan City
        $storeLat = 8.9475;
        $storeLng = 125.5406;

        // Calculate estimated delivery time based on distance
        $destCoords = $this->getDestinationCoords($order);
        $distanceKm = $this->haversineDistance($storeLat, $storeLng, $destCoords[0], $destCoords[1]);

        $baseMinutes = 30; // standard delivery
        $speedKmPerMin = 0.5; // km per minute
        $etaMinutes = max($baseMinutes, (int) ceil($distanceKm / $speedKmPerMin));
        // Cap at reasonable max (for same-city deliveries)
        $etaMinutes = min($etaMinutes, 120);

        $order->update([
            'order_status' => Order::STATUS_OUT_FOR_DELIVERY,
            'rider_picked_up_at' => now(),
            'delivery_started_at' => now(),
            'estimated_delivery_minutes' => $etaMinutes,
            'rider_lat' => $storeLat,
            'rider_lng' => $storeLng,
        ]);

        $order->recordStatusChange(Order::STATUS_OUT_FOR_DELIVERY, Auth::id(), 'Rider picked up order from store.');

        $order->notifyRiderOutForDelivery();
        $this->notifyAdminsAboutRiderUpdate(
            $order,
            'Order is now out for delivery',
            Auth::user()->full_name . " picked up order {$order->display_id} from the store.",
            '📦',
            '#2563eb'
        );

        return redirect()->route('rider.active')->with('success', 'Order picked up! ETA: ~' . $etaMinutes . ' min. Deliver to customer now.');
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

        // Get destination coords so we can set final position
        $destCoords = $this->getDestinationCoords($order);

        $proofPath = null;
        if ($request->hasFile('delivery_proof')) {
            $proofPath = $request->file('delivery_proof')->store('delivery_proofs', 'public');
        }

        $order->update([
            'order_status' => Order::STATUS_DELIVERED,
            'payment_status' => Order::PAYMENT_PAID,
            'rider_delivered_at' => now(),
            'rider_notes' => $request->input('rider_notes', ''),
            'delivery_proof_image' => $proofPath,
            'rider_lat' => $destCoords[0],
            'rider_lng' => $destCoords[1],
            'estimated_delivery_minutes' => 0,
        ]);

        $order->recordStatusChange(Order::STATUS_DELIVERED, Auth::id(), 'Rider delivered order to customer.');

        // Dispatch event to reduce stock for delivered order
        OrderDelivered::dispatch($order);

        $order->notifyOrderDelivered();
        $this->notifyAdminsAboutRiderUpdate(
            $order,
            'Delivery completed',
            Auth::user()->full_name . " delivered order {$order->display_id}.",
            '✅',
            '#10b981'
        );

        return redirect()->route('rider.dashboard')->with('success', 'Delivery completed! Great job! 🎉');
    }

    protected function notifyAdminsAboutRiderUpdate(Order $order, string $title, string $message, string $icon, string $color): void
    {
        $adminIds = User::where('is_admin', true)->pluck('id');

        foreach ($adminIds as $adminId) {
            UserNotification::createNotification(
                $adminId,
                'delivery',
                $title,
                $message,
                $icon,
                $color,
                $order->id,
                'Order',
                ['rider_id' => Auth::id()]
            );
        }
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

    /**
     * AJAX: Update rider's GPS location for live tracking.
     */
    public function updateLocation(Request $request, $id)
    {
        $request->validate([
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
        ]);

        $order = Order::where('id', $id)
            ->where('rider_id', Auth::id())
            ->where('order_status', Order::STATUS_OUT_FOR_DELIVERY)
            ->firstOrFail();

        // Update rider position
        $order->update([
            'rider_lat' => $request->lat,
            'rider_lng' => $request->lng,
        ]);

        // Recalculate ETA based on current position
        if ($order->delivery_started_at) {
            $destCoords = $this->getDestinationCoords($order);
            $remainingKm = $this->haversineDistance($request->lat, $request->lng, $destCoords[0], $destCoords[1]);
            $speedKmPerMin = 0.5;
            $newEta = max(1, (int) ceil($remainingKm / $speedKmPerMin));

            // Calculate how many minutes elapsed since delivery started
            $elapsedMin = now()->diffInMinutes($order->delivery_started_at);
            $order->update([
                'estimated_delivery_minutes' => $elapsedMin + $newEta,
            ]);
        }

        return response()->json([
            'success' => true,
            'eta' => $order->fresh()->formatted_eta,
            'progress' => $order->fresh()->getDeliveryProgressPercent(),
        ]);
    }

    /**
     * Calculate distance between two GPS points using Haversine formula.
     */
    private function haversineDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $R = 6371; // Earth radius in km
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;
        return $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    /**
     * Get destination coordinates from the order's shipping address city.
     */
    private function getDestinationCoords(Order $order): array
    {
        $city = strtolower(trim(optional($order->shippingAddress)->city_municipality ?? 'butuan'));

        // Philippine city coordinates lookup
        $coords = [
            'manila' => [14.5995, 120.9842],
            'quezon city' => [14.6760, 121.0437],
            'cebu' => [10.3157, 123.8854],
            'cebu city' => [10.3157, 123.8854],
            'davao' => [7.1907, 125.4553],
            'davao city' => [7.1907, 125.4553],
            'butuan' => [8.9475, 125.5406],
            'butuan city' => [8.9475, 125.5406],
            'cagayan de oro' => [8.4542, 124.6319],
            'cagayan de oro city' => [8.4542, 124.6319],
            'zamboanga' => [6.9214, 122.0790],
            'zamboanga city' => [6.9214, 122.0790],
            'iloilo' => [10.7202, 122.5621],
            'iloilo city' => [10.7202, 122.5621],
            'makati' => [14.5547, 121.0244],
            'makati city' => [14.5547, 121.0244],
            'taguig' => [14.5176, 121.0509],
            'taguig city' => [14.5176, 121.0509],
            'pasig' => [14.5764, 121.0851],
            'pasig city' => [14.5764, 121.0851],
            'caloocan' => [14.6488, 120.9842],
            'caloocan city' => [14.6488, 120.9842],
            'surigao' => [9.7572, 125.5138],
            'surigao city' => [9.7572, 125.5138],
            'bacolod' => [10.6840, 122.9563],
            'bacolod city' => [10.6840, 122.9563],
            'general santos' => [6.1164, 125.1716],
            'general santos city' => [6.1164, 125.1716],
            'nasipit' => [8.9953, 125.4987],
            'cabadbaran' => [9.1233, 125.5339],
            'san francisco' => [8.5000, 125.9833],
            'bayugan' => [8.7167, 125.7500],
            'prosperidad' => [8.6000, 125.9167],
            'buenavista' => [8.9833, 125.4087],
            'carmen' => [9.0333, 125.6833],
            'las nieves' => [8.9500, 125.6333],
            'santiago' => [8.9667, 125.5667],
        ];

        // Try exact match first
        if (isset($coords[$city])) {
            return $coords[$city];
        }

        // Try partial match
        foreach ($coords as $name => $latLng) {
            if (str_contains($city, $name) || str_contains($name, $city)) {
                return $latLng;
            }
        }

        // Default: offset from store location for unknown cities
        return [8.9575, 125.5506];
    }
}
