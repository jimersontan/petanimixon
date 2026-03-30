<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Show the multi-step checkout page.
     */
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('cart_status', 'active')
            ->with('items.product')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('message', 'Your cart is empty.');
        }

        $addresses = UserAddress::where('user_id', Auth::id())->get();
        $subtotal = $cart->items->sum('subtotal');

        return view('frontend.checkout', compact('cart', 'addresses', 'subtotal'));
    }

    /**
     * Process the checkout — called from step 5 (Place Order).
     */
    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string|in:cod,gcash',
            'shipping_method' => 'required|string|in:standard,express,pickup',
        ]);

        $cart = Cart::where('user_id', Auth::id())
            ->where('cart_status', 'active')
            ->with('items.product')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('message', 'Your cart is empty.');
        }

        return DB::transaction(function () use ($request, $cart) {
            // Resolve address
            $addressId = $request->shipping_address_id;

            if (!$addressId && $request->has('new_address')) {
                $na = $request->new_address;
                $address = UserAddress::create([
                    'user_id' => Auth::id(),
                    'recipient_name' => $na['recipient_name'],
                    'phone_number' => $na['phone_number'],
                    'street_address' => $na['street_address'],
                    'city_municipality' => $na['city_municipality'],
                    'province' => $na['province'],
                    'zip_code' => $na['zip_code'] ?? '',
                    'region' => $na['region'] ?? '',
                    'barangay' => $na['barangay'] ?? '',
                    'address' => ($na['street_address'] ?? '') . ', ' . ($na['city_municipality'] ?? ''),
                ]);
                $addressId = $address->id;
            }

            // Calculate amounts
            $subtotal = $cart->items->sum('subtotal');
            $shippingFee = $this->getShippingFee($request->shipping_method, $subtotal);
            $discount = $this->getVoucherDiscount($request->voucher_code, $subtotal);
            $total = $subtotal + $shippingFee - $discount;

            $orderId = 'ORD-' . strtoupper(Str::random(10));
            $orderNumber = mt_rand(100000, 999999);

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_id' => $orderId,
                'order_number' => $orderNumber,
                'order_status' => Order::STATUS_PENDING,
                'order_amount' => $subtotal,
                'shipping_fee' => $shippingFee,
                'shipping_method' => $request->shipping_method,
                'discount_amount' => $discount,
                'voucher_code' => $request->voucher_code,
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => Order::PAYMENT_PENDING,
                'shipping_address_id' => $addressId,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_amount' => $item->subtotal,
                ]);
            }

            $cart->update(['cart_status' => 'completed']);

            return redirect()->route('checkout.success', $order->order_id);
        });
    }

    /**
     * AJAX: Validate and return voucher discount.
     */
    public function applyVoucher(Request $request)
    {
        $request->validate(['voucher_code' => 'required|string', 'subtotal' => 'required|numeric']);

        $code = strtoupper(trim($request->voucher_code));
        $subtotal = (float) $request->subtotal;

        // Simple built-in vouchers for demo
        $vouchers = [
            'PETLOVE10' => ['type' => 'percent', 'value' => 10, 'min' => 0],
            'SAVE50' => ['type' => 'fixed', 'value' => 50, 'min' => 500],
            'FREESHIP' => ['type' => 'fixed', 'value' => 0, 'min' => 0, 'free_shipping' => true],
            'WELCOME20' => ['type' => 'percent', 'value' => 20, 'min' => 300],
        ];

        if (!isset($vouchers[$code])) {
            return response()->json(['valid' => false, 'message' => 'Invalid voucher code.']);
        }

        $v = $vouchers[$code];
        if ($subtotal < $v['min']) {
            return response()->json(['valid' => false, 'message' => "Minimum order of ₱" . number_format($v['min']) . " required."]);
        }

        $discount = $v['type'] === 'percent' ? round($subtotal * $v['value'] / 100, 2) : $v['value'];

        return response()->json([
            'valid' => true,
            'discount' => $discount,
            'message' => $v['type'] === 'percent' ? "{$v['value']}% off applied!" : "₱" . number_format($discount) . " discount applied!",
            'free_shipping' => $v['free_shipping'] ?? false,
        ]);
    }

    /**
     * Order success page.
     */
    public function success($order_id)
    {
        $order = Order::where('order_id', $order_id)
            ->where('user_id', Auth::id())
            ->with(['orderItems.product', 'shippingAddress'])
            ->firstOrFail();

        return view('frontend.checkout_success', compact('order'));
    }

    /**
     * Order tracking page.
     */
    public function tracking($order_id)
    {
        $order = Order::where('order_id', $order_id)
            ->where('user_id', Auth::id())
            ->with(['orderItems.product', 'shippingAddress'])
            ->firstOrFail();

        return view('frontend.order_tracking', compact('order'));
    }

    /**
     * Get shipping fee based on method and subtotal.
     */
    private function getShippingFee(string $method, float $subtotal): float
    {
        if ($method === 'pickup') return 0;
        if ($method === 'express') return $subtotal >= 1500 ? 99 : 199;
        // standard
        if ($subtotal >= 1500) return 0;
        if ($subtotal >= 500) return 59;
        return 99;
    }

    /**
     * Get discount amount from voucher code.
     */
    private function getVoucherDiscount(?string $code, float $subtotal): float
    {
        if (!$code) return 0;

        $vouchers = [
            'PETLOVE10' => ['type' => 'percent', 'value' => 10, 'min' => 0],
            'SAVE50' => ['type' => 'fixed', 'value' => 50, 'min' => 500],
            'FREESHIP' => ['type' => 'fixed', 'value' => 0, 'min' => 0],
            'WELCOME20' => ['type' => 'percent', 'value' => 20, 'min' => 300],
        ];

        $code = strtoupper(trim($code));
        if (!isset($vouchers[$code])) return 0;

        $v = $vouchers[$code];
        if ($subtotal < $v['min']) return 0;

        return $v['type'] === 'percent' ? round($subtotal * $v['value'] / 100, 2) : $v['value'];
    }
}
