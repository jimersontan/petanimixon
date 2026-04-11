<?php

namespace App\Http\Controllers;

use App\Models\ReturnRefund;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ReturnRefundController extends Controller
{
    /**
     * Show the user's return/refund history.
     */
    public function index()
    {
        $returns = ReturnRefund::whereHas('orderItem.order', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->with(['orderItem.product', 'orderItem.order'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('frontend.returns', compact('returns'));
    }

    /**
     * Show the return request form for a given order item.
     */
    public function create($orderItemId)
    {
        $orderItem = OrderItem::with(['product', 'order'])
            ->whereHas('order', fn($q) => $q->where('user_id', Auth::id()))
            ->findOrFail($orderItemId);

        // Only allow returns for delivered orders
        if ($orderItem->order->order_status !== 'delivered') {
            return back()->with('error', 'Returns can only be requested for delivered orders.');
        }

        // Check if there's already a return for this item
        $existingReturn = ReturnRefund::where('order_item_id', $orderItemId)->first();
        if ($existingReturn) {
            return back()->with('error', 'A return request already exists for this item.');
        }

        return view('frontend.return_request', compact('orderItem'));
    }

    /**
     * Submit a return/refund request.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_item_id' => 'required|exists:order_items,id',
            'return_reason' => 'required|string|max:255',
            'return_reason_description' => 'nullable|string|max:2000',
            'return_type' => 'required|in:refund,replacement',
        ]);

        $orderItem = OrderItem::with('order')
            ->whereHas('order', fn($q) => $q->where('user_id', Auth::id()))
            ->findOrFail($data['order_item_id']);

        if ($orderItem->order->order_status !== 'delivered') {
            return back()->with('error', 'Returns can only be requested for delivered orders.');
        }

        // Check for existing return
        if (ReturnRefund::where('order_item_id', $data['order_item_id'])->exists()) {
            return back()->with('error', 'A return request already exists for this item.');
        }

        ReturnRefund::create([
            'order_item_id' => $data['order_item_id'],
            'seller_id' => $orderItem->seller_id ?? 1,
            'return_refund_id' => 'RR-' . strtoupper(Str::random(10)),
            'return_reason' => $data['return_reason'],
            'return_reason_description' => $data['return_reason_description'],
            'return_type' => $data['return_type'],
            'refund_amount' => $orderItem->total_amount,
            'refund_status' => 'pending',
        ]);

        return redirect()->route('returns.index')->with('success', 'Return request submitted successfully.');
    }
}
