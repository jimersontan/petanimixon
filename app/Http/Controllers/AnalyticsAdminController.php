<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;

class AnalyticsAdminController extends Controller
{
    /**
     * Display rich analytics dashboard.
     */
    public function index(Request $request)
    {
        $days = (int) $request->get('days', 30);
        $from = now()->subDays($days);

        $query = Order::where('payment_status', Order::PAYMENT_PAID);
        if ($request->has('days')) {
            $query->where('created_at', '>=', $from);
        }

        $totalOrders = (clone $query)->count();
        $totalRevenue = (clone $query)->sum('total_amount');
        
        // Mock visitors based on orders
        $visitors = $totalOrders * mt_rand(15, 30);
        $conversionRate = $visitors > 0 ? ($totalOrders / $visitors) * 100 : 0;
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        $stats = [
            'orders' => $totalOrders,
            'revenue' => $totalRevenue,
            'visitors' => $visitors,
            'conversion_rate' => $conversionRate,
            'avg_order_value' => $avgOrderValue,
        ];

        // Top Selling Products
        $topProducts = OrderItem::select('product_id', \DB::raw('SUM(quantity) as total_sold'), \DB::raw('SUM(unit_price * quantity) as total_revenue'))
            ->whereHas('order', function($q) use ($from, $request) {
                $q->where('payment_status', Order::PAYMENT_PAID);
                if ($request->has('days')) {
                    $q->where('created_at', '>=', $from);
                }
            })
            ->with(['product' => function($q) {
                $q->select('id', 'product_name', 'animal_image_url');
            }])
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(6)
            ->get();
            
        // Sales By Category
        $salesByCategory = OrderItem::select('categories.category_name', \DB::raw('SUM(order_items.quantity) as total_sold'), \DB::raw('SUM(order_items.unit_price * order_items.quantity) as total_revenue'))
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.animal_category_id', '=', 'categories.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', Order::PAYMENT_PAID);
            
        if ($request->has('days')) {
            $salesByCategory->where('orders.created_at', '>=', $from);
        }
            
        $salesByCategory = $salesByCategory->groupBy('categories.category_name')
            ->orderByDesc('total_revenue')
            ->take(5)
            ->get();

        // Recent Orders
        $recentOrders = (clone $query)
            ->with(['user'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('analytics_admin', [
            'stats' => $stats,
            'days' => $days,
            'topProducts' => $topProducts,
            'salesByCategory' => $salesByCategory,
            'recentOrders' => $recentOrders
        ]);
    }
}
