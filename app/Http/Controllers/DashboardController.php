<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with real metrics.
     */
    public function index()
    {
        $now = Carbon::now();
        $startOfYear = $now->copy()->startOfYear();

        // Metric cards
        $totalRevenue = Order::where('payment_status', Order::PAYMENT_PAID)->sum('total_amount');
        $totalOrders = Order::count();
        $newCustomers = User::where('is_admin', false)->count();
        $totalProducts = Product::count();
        $avgOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders, 2) : 0;
        
        $pendingOrdersCount = Order::where('order_status', 'pending')->count();
        $pendingOrdersRevenue = Order::where('order_status', 'pending')->sum('total_amount');
        
        $processingCount = Order::whereIn('order_status', ['confirmed', 'preparing'])->count();
        $processingRevenue = Order::whereIn('order_status', ['confirmed', 'preparing'])->sum('total_amount');
        
        $transitCount = Order::whereIn('order_status', ['out_for_delivery', 'shipped', 'in_transit', 'assigned_to_rider', 'rider_confirmed', 'handed_to_courier'])->count();
        $transitRevenue = Order::whereIn('order_status', ['out_for_delivery', 'shipped', 'in_transit', 'assigned_to_rider', 'rider_confirmed', 'handed_to_courier'])->sum('total_amount');
        
        $completedCount = Order::where('order_status', 'delivered')->count();
        $completedRevenue = Order::where('order_status', 'delivered')->sum('total_amount');

        // Top products (by quantity sold)
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.product_name', 'products.animal_image_url', 'products.price', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.id', 'products.product_name', 'products.animal_image_url', 'products.price')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get()
            ->map(function($product) {
                $raw = $product->animal_image_url;
                if (empty($raw)) {
                    $product->image_url = asset('images/placeholder.png');
                } elseif (strpos($raw, 'http') === 0) {
                    $product->image_url = $raw;
                } else {
                    $raw = str_replace('\\', '/', trim((string) $raw));
                    $raw = ltrim($raw, '/');
                    if (strpos($raw, 'storage/') === 0) $raw = substr($raw, 8);
                    elseif (strpos($raw, 'public/') === 0) $raw = substr($raw, 7);
                    $product->image_url = asset('storage/' . ltrim($raw, '/'));
                }
                return $product;
            });

        // Recent orders (last 5)
        $recentOrders = Order::with('user')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // Low stock products (stock <= 10, computed from variants)
        $lowStock = Product::withSum('variants', 'variant_quantity')
            ->get()
            ->filter(function ($product) {
                $stock = $product->variants_sum_variant_quantity ?? 0;
                return $stock > 0 && $stock <= 10;
            })
            ->sortBy('variants_sum_variant_quantity')
            ->take(5);

        // Calculate weekly revenue data for the chart
        $weeklyData = [];
        $weeklyLabels = [];
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $week = 1;
        $cursor = $startOfMonth->copy();
        while ($cursor->lte($endOfMonth)) {
            $weekEnd = $cursor->copy()->addDays(6)->min($endOfMonth);
            $rev = Order::where('payment_status', Order::PAYMENT_PAID)
                ->whereBetween('created_at', [$cursor, $weekEnd->copy()->endOfDay()])
                ->sum('total_amount');
            
            // Push the raw amount data for chart mapping
            $weeklyData[] = round($rev, 2); 
            $weeklyLabels[] = 'Week ' . $week;
            
            $cursor = $weekEnd->copy()->addDay();
            $week++;
        }
        $weeklyRevenueData = json_encode(['labels' => $weeklyLabels, 'data' => $weeklyData]);

        // Delivery Performance Metrics
        $deliveredOrders = Order::whereNotNull('rider_delivered_at')->whereNotNull('delivery_started_at')->get();
        $totalDeliveryTime = 0;
        $onTimeDeliveries = 0;

        foreach ($deliveredOrders as $order) {
            $taken = $order->delivery_started_at->diffInMinutes($order->rider_delivered_at);
            $totalDeliveryTime += $taken;
            
            $estimatedWait = (int) $order->estimated_delivery_minutes > 0 ? $order->estimated_delivery_minutes : 60;
            if ($taken <= $estimatedWait + 5) { // 5 mins grace period
                $onTimeDeliveries++;
            }
        }

        $avgDeliveryTime = $deliveredOrders->count() > 0 ? round($totalDeliveryTime / $deliveredOrders->count()) : 0;
        $onTimeRate = $deliveredOrders->count() > 0 ? round(($onTimeDeliveries / $deliveredOrders->count()) * 100) : 100;
        
        $activeRiders = Order::whereNotNull('rider_id')
            ->whereIn('order_status', ['out_for_delivery', 'in_transit', 'assigned_to_rider', 'rider_confirmed'])
            ->distinct('rider_id')
            ->count('rider_id');

        $totalCancelled = Order::where('order_status', 'cancelled')->count();
        $successRate = ($completedCount + $totalCancelled) > 0 
            ? round(($completedCount / ($completedCount + $totalCancelled)) * 100) 
            : 100;

        return view('dashboard_admin', compact(
            'totalRevenue', 'totalOrders', 'newCustomers', 'totalProducts', 'avgOrderValue',
            'pendingOrdersCount', 'pendingOrdersRevenue', 'processingCount', 'processingRevenue',
            'transitCount', 'transitRevenue', 'completedCount', 'completedRevenue',
            'topProducts', 'recentOrders', 'lowStock', 'weeklyRevenueData',
            'avgDeliveryTime', 'onTimeRate', 'activeRiders', 'successRate'
        ));
    }

    /**
     * API: Return revenue chart data (monthly/weekly/daily) from real orders.
     */
    public function chartData(Request $request)
    {
        $type = $request->get('type', 'monthly');
        $now = Carbon::now();

        if ($type === 'monthly') {
            // Revenue per month for current year
            $data = [];
            $labels = [];
            for ($m = 1; $m <= 12; $m++) {
                $start = Carbon::create($now->year, $m, 1)->startOfMonth();
                $end = $start->copy()->endOfMonth();
                $rev = Order::where('payment_status', Order::PAYMENT_PAID)
                    ->whereBetween('created_at', [$start, $end])
                    ->sum('total_amount');
                $data[] = round($rev / 1000, 1); // in thousands
                $labels[] = $start->format('M');
            }
        } elseif ($type === 'weekly') {
            // Revenue per week for current month
            $data = [];
            $labels = [];
            $startOfMonth = $now->copy()->startOfMonth();
            $endOfMonth = $now->copy()->endOfMonth();
            $week = 1;
            $cursor = $startOfMonth->copy();
            while ($cursor->lte($endOfMonth)) {
                $weekEnd = $cursor->copy()->addDays(6)->min($endOfMonth);
                $rev = Order::where('payment_status', Order::PAYMENT_PAID)
                    ->whereBetween('created_at', [$cursor, $weekEnd->copy()->endOfDay()])
                    ->sum('total_amount');
                $data[] = round($rev / 1000, 1);
                $labels[] = 'Week ' . $week;
                $cursor = $weekEnd->copy()->addDay();
                $week++;
            }
        } elseif ($type === '3days') {
            // Revenue for last 3 days
            $data = [];
            $labels = [];
            for ($d = 2; $d >= 0; $d--) {
                $day = $now->copy()->subDays($d);
                $rev = Order::where('payment_status', Order::PAYMENT_PAID)
                    ->whereDate('created_at', $day->toDateString())
                    ->sum('total_amount');
                $data[] = round($rev / 1000, 1);
                $labels[] = $day->format('D, M d');
            }
        } else {
            // Revenue per day for current week
            $data = [];
            $labels = [];
            $startOfWeek = $now->copy()->startOfWeek(\Carbon\CarbonInterface::MONDAY);
            for ($d = 0; $d < 7; $d++) {
                $day = $startOfWeek->copy()->addDays($d);
                $rev = Order::where('payment_status', Order::PAYMENT_PAID)
                    ->whereDate('created_at', $day->toDateString())
                    ->sum('total_amount');
                $data[] = round($rev / 1000, 1);
                $labels[] = $day->format('D');
            }
        }

        return response()->json([
            'data' => $data,
            'labels' => $labels,
        ]);
    }

    /**
     * API endpoint to get low/no stock alerts for the admin header notification bell.
     */
    public function stockAlerts()
    {
        // Out of stock (0 stock)
        $outOfStock = Product::whereHas('variants', function ($q) {
            $q->where('variant_quantity', 0);
        })->where('product_status', '!=', 'draft')
        ->select('id', 'product_name')
        ->get()
        ->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->product_name,
                'type' => 'out_of_stock',
                'message' => 'Out of stock'
            ];
        });

        // Low stock (1-5 stock)
        $lowStock = Product::whereHas('variants', function ($q) {
            $q->whereBetween('variant_quantity', [1, 5]);
        })->where('product_status', '!=', 'draft')
        ->select('id', 'product_name')
        ->get()
        ->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->product_name,
                'type' => 'low_stock',
                'message' => 'Low stock'
            ];
        });
        
        $allAlerts = $outOfStock->concat($lowStock);
        
        return response()->json([
            'count' => $allAlerts->count(),
            'alerts' => $allAlerts
        ]);
    }
}
