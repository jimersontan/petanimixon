<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsAdminController extends Controller
{
    public function index(Request $request)
    {
        $days = (int) $request->query('days', 30);
        $startDate = Carbon::today()->subDays($days - 1); // e.g. last 30 days including today

        // Base order query for the period
        $ordersQuery = Order::where('created_at', '>=', $startDate)
            ->where('order_status', '!=', Order::STATUS_CANCELLED);

        // 1. Key Metrics
        $totalRevenue = (clone $ordersQuery)->sum('total_amount');
        $totalOrders = (clone $ordersQuery)->count();
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Total units sold in the period
        $totalUnitsSold = OrderItem::whereHas('order', function ($query) use ($startDate) {
            $query->where('created_at', '>=', $startDate)
                  ->where('order_status', '!=', Order::STATUS_CANCELLED);
        })->sum('quantity');

        $stats = [
            'revenue' => $totalRevenue,
            'orders' => $totalOrders,
            'avg_order_value' => $avgOrderValue,
            'units_sold' => $totalUnitsSold,
        ];

        // 2. Revenue Trend (Line Chart)
        $trendData = (clone $ordersQuery)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $chartLabels = [];
        $chartData = [];

        for ($i = 0; $i < $days; $i++) {
            $dateStr = $startDate->copy()->addDays($i)->format('Y-m-d');
            $chartLabels[] = Carbon::parse($dateStr)->format('M d');
            // Store raw number for Chart.js
            $chartData[] = isset($trendData[$dateStr]) ? (float) $trendData[$dateStr]->total : 0;
        }

        // 3. Sales by Category (Doughnut Chart)
        $categorySales = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.animal_category_id', '=', 'categories.id')
            ->where('orders.created_at', '>=', $startDate)
            ->where('orders.order_status', '!=', Order::STATUS_CANCELLED)
            ->select(
                'categories.category_name',
                DB::raw('SUM(order_items.unit_price * order_items.quantity) as total_revenue')
            )
            ->groupBy('categories.category_name')
            ->orderByDesc('total_revenue')
            ->get();

        $categoryLabels = $categorySales->pluck('category_name')->toArray();
        $categoryData = $categorySales->pluck('total_revenue')->toArray();

        // 4. Top Products Table
        $topProducts = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.created_at', '>=', $startDate)
            ->where('orders.order_status', '!=', Order::STATUS_CANCELLED)
            ->select(
                'product_id',
                DB::raw('SUM(quantity) as total_sold'),
                DB::raw('SUM(unit_price * quantity) as total_revenue')
            )
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product') // Eager load product model for names/images
            ->take(5)
            ->get();

        // 5. Recent Transactions
        $recentOrders = Order::with('user')
            ->where('order_status', '!=', Order::STATUS_CANCELLED)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('analytics_admin', compact(
            'days',
            'stats',
            'chartLabels',
            'chartData',
            'categoryLabels',
            'categoryData',
            'topProducts',
            'recentOrders'
        ));
    }
}
