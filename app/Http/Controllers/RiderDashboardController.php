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
            ->with('shippingAddress')
            ->firstOrFail();

        // Store location: PetMarkt-PH Store, Libertad, Butuan City
        $storeLat = 8.9475;
        $storeLng = 125.5406;

        // Calculate estimated delivery time based on shipping method and distance
        $destCoords = $this->getDestinationCoords($order);
        $distanceKm = $this->haversineDistance($storeLat, $storeLng, $destCoords[0], $destCoords[1]);

        // Base ETA by shipping method, scaled by distance
        $baseMinutes = ($order->shipping_method === 'express') ? 25 : 40;
        $speedKmPerMin = ($order->shipping_method === 'express') ? 0.8 : 0.5; // km per minute
        $etaMinutes = max($baseMinutes, (int) ceil($distanceKm / $speedKmPerMin));
        // Cap at reasonable max (for same-city deliveries)
        $etaMinutes = min($etaMinutes, 120);

        $order->update([
            'rider_picked_up_at' => now(),
            'delivery_started_at' => now(),
            'estimated_delivery_minutes' => $etaMinutes,
            'rider_lat' => $storeLat,
            'rider_lng' => $storeLng,
        ]);

        $order->notifyRiderOutForDelivery();

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

        $order->update([
            'order_status' => Order::STATUS_DELIVERED,
            'payment_status' => Order::PAYMENT_PAID,
            'rider_delivered_at' => now(),
            'rider_notes' => $request->input('rider_notes', ''),
            'rider_lat' => $destCoords[0],
            'rider_lng' => $destCoords[1],
            'estimated_delivery_minutes' => 0,
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
            $speedKmPerMin = ($order->shipping_method === 'express') ? 0.8 : 0.5;
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
