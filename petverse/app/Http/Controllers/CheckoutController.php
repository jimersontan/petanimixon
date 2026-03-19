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

        return view('frontend.checkout', compact('cart', 'addresses'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_address_id' => 'required_without:new_address',
            'payment_method' => 'required|string',
            'new_address' => 'sometimes|array',
            'new_address.recipient_name' => 'required_if:shipping_address_id,null',
            'new_address.phone_number' => 'required_if:shipping_address_id,null',
            'new_address.street_address' => 'required_if:shipping_address_id,null',
            'new_address.city_municipality' => 'required_if:shipping_address_id,null',
            'new_address.province' => 'required_if:shipping_address_id,null',
            'new_address.zip_code' => 'required_if:shipping_address_id,null',
        ]);

        $cart = Cart::where('user_id', Auth::id())
            ->where('cart_status', 'active')
            ->with('items.product')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('message', 'Your cart is empty.');
        }

        return DB::transaction(function () use ($request, $cart) {
            $addressId = $request->shipping_address_id;

            if ($request->has('new_address')) {
                $address = UserAddress::create([
                    'user_id' => Auth::id(),
                    'recipient_name' => $request->new_address['recipient_name'],
                    'phone_number' => $request->new_address['phone_number'],
                    'street_address' => $request->new_address['street_address'],
                    'city_municipality' => $request->new_address['city_municipality'],
                    'province' => $request->new_address['province'],
                    'zip_code' => $request->new_address['zip_code'],
                    'address' => $request->new_address['street_address'] . ', ' . $request->new_address['city_municipality'],
                ]);
                $addressId = $address->id;
            }

            $totalAmount = $cart->items->sum('subtotal');
            $orderId = 'ORD-' . strtoupper(Str::random(10));
            $orderNumber = mt_rand(100000, 999999);

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_id' => $orderId,
                'order_number' => $orderNumber,
                'order_status' => Order::STATUS_PENDING,
                'order_amount' => $totalAmount,
                'total_amount' => $totalAmount,
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

            // Mark cart as completed
            $cart->update(['cart_status' => 'completed']);

            return redirect()->route('checkout.success', $order->order_id);
        });
    }

    public function success($order_id)
    {
        $order = Order::where('order_id', $order_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('frontend.checkout_success', compact('order'));
    }
}
