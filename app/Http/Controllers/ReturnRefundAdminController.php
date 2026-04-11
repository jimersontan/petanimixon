<?php

namespace App\Http\Controllers;

use App\Events\OrderNotificationEvent;
use App\Models\ReturnRefund;
use Illuminate\Http\Request;

class ReturnRefundAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = ReturnRefund::with(['orderItem.product', 'orderItem.order.user']);

        $statusFilter = $request->get('status', 'all');
        if ($statusFilter !== 'all') {
            $query->where('refund_status', $statusFilter);
        }

        $returns = $query->orderByDesc('created_at')->paginate(15)->appends($request->query());

        $stats = [
            'total' => ReturnRefund::count(),
            'pending' => ReturnRefund::where('refund_status', 'pending')->count(),
            'approved' => ReturnRefund::where('refund_status', 'approved')->count(),
            'rejected' => ReturnRefund::where('refund_status', 'rejected')->count(),
        ];

        return view('returns_admin', compact('returns', 'stats', 'statusFilter'));
    }

    public function approve(Request $request, $id)
    {
        $return = ReturnRefund::with('orderItem.order')->findOrFail($id);
        $return->update([
            'refund_status' => 'approved',
            'admin_notes' => $request->admin_notes,
            'received_at' => now(),
        ]);

        $order = $return->orderItem->order ?? null;
        if ($order && $order->user_id) {
            OrderNotificationEvent::dispatch($order, 'refund_processed');
        }

        return redirect()->route('returns.admin')->with('success', 'Return request approved.');
    }

    public function reject(Request $request, $id)
    {
        $return = ReturnRefund::findOrFail($id);
        $return->update([
            'refund_status' => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('returns.admin')->with('success', 'Return request rejected.');
    }
}
