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

        $orders = Order::query()
            ->where('user_id', $user->id)
            ->with(['orderItems.product'])
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('frontend.orders', [
            'orders' => $orders,
        ]);
    }
}
