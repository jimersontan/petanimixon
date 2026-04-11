<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    /**
     * Display the vouchers page.
     */
    public function index()
    {
        // Get some active coupons to display as featured/available
        $availableCoupons = Coupon::where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where('show_on_homepage', true)
            ->limit(4)
            ->get();

        return view('frontend.vouchers', compact('availableCoupons'));
    }

    /**
     * Activate a voucher and store it in the session.
     */
    public function activate(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|string',
        ]);

        $code = strtoupper(trim($request->voucher_code));

        if ($code === '___CLEAR___') {
            session()->forget('active_voucher');
            return response()->json(['success' => true, 'message' => 'Voucher removed.']);
        }
        
        // Find the coupon
        $coupon = Coupon::where('coupon_code', $code)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid voucher code. Please check for typos.'
            ]);
        }

        if (!$coupon->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'This voucher is no longer active.'
            ]);
        }

        $now = now();
        if ($coupon->valid_from->isAfter($now) || $coupon->valid_until->isBefore($now)) {
            return response()->json([
                'success' => false,
                'message' => 'This voucher has expired or is not yet valid.'
            ]);
        }

        if ($coupon->hasReachedMaxUsage()) {
            return response()->json([
                'success' => false,
                'message' => 'This voucher has reached its usage limit.'
            ]);
        }

        if (Auth::check() && $coupon->hasUserExceededLimit(Auth::id())) {
            return response()->json([
                'success' => false,
                'message' => 'You have already used this voucher the maximum number of times.'
            ]);
        }

        // It's valid! Store in session
        session(['active_voucher' => $code]);

        return response()->json([
            'success' => true,
            'message' => 'Voucher activated! 🐾 It will be automatically applied at checkout.',
            'code' => $code,
            'discount_type' => $coupon->discount_type,
            'discount_amount' => $coupon->discount_amount,
        ]);
    }
}
