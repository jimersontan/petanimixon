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
        $avgOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders, 2) : 0;

        // Top products (by quantity sold)
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.product_name', 'products.animal_image_url', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.id', 'products.product_name', 'products.animal_image_url')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

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

        return view('dashboard_admin', compact(
            'totalRevenue', 'totalOrders', 'newCustomers', 'avgOrderValue',
            'topProducts', 'recentOrders', 'lowStock'
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
        } else {
            // Revenue per day for current week
            $data = [];
            $labels = [];
            $startOfWeek = $now->copy()->startOfWeek(Carbon::MONDAY);
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
}
