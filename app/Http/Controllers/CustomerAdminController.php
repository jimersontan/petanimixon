<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;

class CustomerAdminController extends Controller
{
    /**
     * List customers with basic stats.
     */
    public function index(Request $request)
    {
        $days = (int) $request->get('days', 30);
        $from = now()->subDays($days);

        $stats = [
            'total_customers' => User::where('is_admin', false)->count(),
            'new_this_month' => User::where('is_admin', false)
                ->where('created_at', '>=', now()->subMonth())
                ->count(),
            'active_customers' => User::where('is_admin', false)
                ->where('account_status', 'active')
                ->count(),
            'avg_clv' => Order::whereHas('user', function ($q) {
                $q->where('is_admin', false);
            })->avg('total_amount'),
        ];

        $customersQuery = User::where('is_admin', false)
            ->withCount('orders')
            // alias not supported on some MariaDB versions, compute raw and rename later
            ->withSum('orders', 'total_amount');

        if ($request->has('days')) {
            $customersQuery->where('created_at', '>=', $from);
        }

        $customers = $customersQuery
            ->orderByDesc('created_at')
            ->paginate(15);

        // rename the sum column to total_spent for the view convenience
        if ($customers instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $customers->getCollection()->transform(function ($c) {
                $c->total_spent = $c->orders_total_amount_sum ?? 0;
                return $c;
            });
        }

        return view('customers_admin', compact('stats', 'customers', 'days'));
    }
}
