<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserAddress;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Services\MockPaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Initialize checkout from cart selection
     */
    public function initCheckout(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'integer|exists:cart_items,id'
        ]);

        session(['checkout_items' => $request->selected_items]);
        return redirect()->route('checkout');
    }

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

        $checkoutItems = session('checkout_items', []);
        
        if (empty($checkoutItems)) {
            return redirect()->route('cart.index')->with('error', 'Please select items to checkout.');
        }

        // Filter cart items to only contain the selected ones
        $cart->setRelation('items', $cart->items->whereIn('id', $checkoutItems));

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Selected items are no longer available in your cart.');
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
            'shipping_type' => 'required|string|in:local,courier',
        ]);

        $cart = Cart::where('user_id', Auth::id())
            ->where('cart_status', 'active')
            ->with('items.product')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('message', 'Your cart is empty.');
        }

        $checkoutItems = session('checkout_items', []);
        
        if (empty($checkoutItems)) {
            return redirect()->route('cart.index')->with('error', 'Please select items to checkout.');
        }

        // Filter cart items to only contain the selected ones
        $cart->setRelation('items', $cart->items->whereIn('id', $checkoutItems));

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Selected items are no longer available in your cart.');
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

            // ── Stock Validation ──────────────────────────────
            // Check every cart item has enough stock before proceeding
            foreach ($cart->items as $item) {
                $product = $item->product;
                if (!$product) continue;

                $availableStock = $product->stock; // sum of variant quantities
                if ($item->quantity > $availableStock) {
                    $name = $product->product_name;
                    $msg = $availableStock > 0
                        ? "Sorry, only {$availableStock} unit(s) of \"{$name}\" are in stock. Please reduce your quantity."
                        : "\"{$name}\" is currently out of stock. Please remove it from your cart.";
                    return redirect()->route('cart.index')->with('error', $msg);
                }
            }

            // Calculate amounts
            $subtotal = $cart->items->sum('subtotal');
            $shippingFee = $this->getShippingFee($request->shipping_type);
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
                'shipping_type' => $request->shipping_type,
                'discount_amount' => $discount,
                'voucher_code' => $request->voucher_code,
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => Order::PAYMENT_PENDING,
                'shipping_address_id' => $addressId,
            ]);

            // Save initial status to history
            $order->recordStatusChange(Order::STATUS_PENDING, Auth::id(), 'Order placed by customer.');

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_amount' => $item->subtotal,
                ]);

                // ── Instant Stock Deduction ──────────────────
                // Reduce variant stock immediately when order is placed
                if ($item->product) {
                    $remaining = $item->quantity;
                    $variants = $item->product->variants()->orderBy('id')->get();

                    foreach ($variants as $variant) {
                        if ($remaining <= 0) break;

                        $deduct = min($remaining, $variant->variant_quantity);
                        $variant->update([
                            'variant_quantity' => max(0, $variant->variant_quantity - $deduct),
                        ]);
                        $remaining -= $deduct;
                    }
                }
            }

            // Record coupon usage if a valid coupon was applied
            if ($request->voucher_code) {
                $coupon = Coupon::where('coupon_code', strtoupper(trim($request->voucher_code)))->first();
                if ($coupon) {
                    CouponUsage::create([
                        'coupon_id' => $coupon->id,
                        'user_id' => Auth::id(),
                        'order_id' => $order->id,
                    ]);
                }
            }

            // Instead of marking cart as completed, delete the checked out items
            $itemIds = $cart->items->pluck('id')->toArray();
            \App\Models\CartItem::whereIn('id', $itemIds)->delete();
            
            // If the cart is now empty, we can mark it as completed
            if (\App\Models\CartItem::where('cart_id', $cart->id)->count() === 0) {
                $cart->update(['cart_status' => 'completed']);
            }

            session()->forget('checkout_items');

            $order->notifyOrderPlaced();

            // Handle GCash / online payment via gateway
            if ($request->payment_method === 'gcash') {
                $gateway = new MockPaymentGateway();
                $result = $gateway->createPayment($order);
                if ($result['success'] && $result['redirect_url']) {
                    return redirect($result['redirect_url']);
                }
            }

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

        // Query the coupons table for a valid, active coupon
        $coupon = Coupon::where('coupon_code', $code)->first();

        if (!$coupon) {
            return response()->json(['valid' => false, 'message' => 'Invalid voucher code.']);
        }

        if (!$coupon->is_active) {
            return response()->json(['valid' => false, 'message' => 'This coupon is no longer active.']);
        }

        $now = now();
        if ($coupon->valid_from->isAfter($now) || $coupon->valid_until->isBefore($now)) {
            return response()->json(['valid' => false, 'message' => 'This coupon has expired.']);
        }

        if ($coupon->hasReachedMaxUsage()) {
            return response()->json(['valid' => false, 'message' => 'This coupon has reached its usage limit.']);
        }

        if (Auth::check() && $coupon->hasUserExceededLimit(Auth::id())) {
            return response()->json(['valid' => false, 'message' => 'You have already used this coupon the maximum number of times.']);
        }

        $discount = $coupon->calculateDiscount($subtotal);

        if ($discount <= 0 && $coupon->min_order_value) {
            return response()->json(['valid' => false, 'message' => 'Minimum order of ₱' . number_format((float) $coupon->min_order_value) . ' required.']);
        }

        $message = ($coupon->discount_type === 'percent' || $coupon->discount_type === 'percentage')
            ? (int) $coupon->discount_amount . '% off applied!'
            : '₱' . number_format($discount) . ' discount applied!';

        return response()->json([
            'valid' => true,
            'discount' => $discount,
            'message' => $message,
            'free_shipping' => false,
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
            ->with(['orderItems.product', 'shippingAddress', 'rider'])
            ->firstOrFail();

        return view('frontend.order_tracking', compact('order'));
    }

    /**
     * JSON: Live tracking data endpoint polled by the map.
     */
    public function trackingData($order_id)
    {
        $order = Order::where('order_id', $order_id)
            ->where('user_id', Auth::id())
            ->with(['shippingAddress', 'rider'])
            ->firstOrFail();

        return response()->json([
            'status' => $order->order_status,
            'payment_status' => $order->payment_status,
            'rider' => $order->rider ? [
                'name' => $order->rider->full_name ?? $order->rider->first_name,
                'lat' => (float) $order->rider_lat,
                'lng' => (float) $order->rider_lng,
            ] : null,
            'eta' => $order->formatted_eta,
            'eta_minutes' => $order->estimated_delivery_minutes,
            'progress' => $order->getDeliveryProgressPercent(),
            'estimated_arrival' => optional($order->estimated_arrival)->format('g:i A'),
            'delivery_started_at' => optional($order->delivery_started_at)->toISOString(),
            'picked_up_at' => optional($order->rider_picked_up_at)->toISOString(),
            'delivered_at' => optional($order->rider_delivered_at)->toISOString(),
            'shipping_type' => $order->shipping_type,
        ]);
    }

    /**
     * Get shipping fee based on method and subtotal.
     */
    private function getShippingFee(string $type): float
    {
        if ($type === 'local') return 50.00;
        if ($type === 'courier') return 150.00; // Flat fee for demo, real implementation uses region API
        return 50.00;
    }

    /**
     * Get discount amount from voucher code — queries the coupons table.
     */
    private function getVoucherDiscount(?string $code, float $subtotal): float
    {
        if (!$code) return 0;

        $coupon = Coupon::where('coupon_code', strtoupper(trim($code)))
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->first();

        if (!$coupon) return 0;

        return $coupon->calculateDiscount($subtotal);
    }

    /**
     * Payment gateway callback — handles return from external payment.
     */
    public function paymentCallback(Request $request)
    {
        $orderId = $request->query('order_id');
        $status = $request->query('status');
        $reference = $request->query('reference');

        $order = Order::where('order_id', $orderId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            return redirect()->route('orders')->with('error', 'Order not found.');
        }

        if ($status === 'success') {
            $order->update([
                'payment_status' => Order::PAYMENT_PENDING,
                'payment_reference' => $reference,
            ]);
            return redirect()->route('checkout.success', $order->order_id);
        }

        // Payment failed
        $order->update(['payment_status' => 'failed']);
        return redirect()->route('checkout.success', $order->order_id)
            ->with('error', 'Payment could not be processed. Please try again.');
    }
}
