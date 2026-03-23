<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cart->load('items.product');
        
        return view('frontend.cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = $this->getOrCreateCart();

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->subtotal = $cartItem->quantity * $cartItem->unit_price;
            $cartItem->save();
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'unit_price' => $product->price,
                'subtotal' => $request->quantity * $product->price
            ]);
        }

        return redirect()->route('cart.index')->with('message', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::findOrFail($id);
        $cartItem->quantity = $request->quantity;
        $cartItem->subtotal = $cartItem->quantity * $cartItem->unit_price;
        $cartItem->save();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Cart updated successfully', 'subtotal' => $cartItem->subtotal]);
        }

        return redirect()->route('cart.index')->with('message', 'Cart updated successfully!');
    }

    public function remove($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart.index')->with('message', 'Item removed from cart!');
    }

    public function clear()
    {
        $cart = $this->getOrCreateCart();
        $cart->items()->delete();

        return redirect()->route('cart.index')->with('message', 'Cart cleared!');
    }

    public function getCount()
    {
        $cart = $this->getOrCreateCart();
        return response()->json(['count' => $cart->items->sum('quantity')]);
    }

    private function getOrCreateCart()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->where('cart_status', 'active')->first();
            if (!$cart) {
                $cart = Cart::create([
                    'user_id' => Auth::id(),
                    'cart_id' => Str::uuid(),
                    'user_status' => 'customer',
                    'cart_status' => 'active'
                ]);
            }
            return $cart;
        }

        // Fallback for guests (could use session, but let's assume auth for now as per project context)
        abort(403, 'Please login to use the cart.');
    }
}
