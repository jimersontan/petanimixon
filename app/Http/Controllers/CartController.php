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

        // Check available stock
        $availableStock = $product->stock;
        $cartItem = $cart->items()->where('product_id', $product->id)->first();
        $alreadyInCart = $cartItem ? $cartItem->quantity : 0;
        $requestedTotal = $alreadyInCart + $request->quantity;

        if ($availableStock <= 0) {
            if ($request->expectsJson()) {
                return response()->json(['error' => "\"{$product->product_name}\" is currently out of stock."], 422);
            }
            return redirect()->back()->with('error', "\"{$product->product_name}\" is currently out of stock.");
        }

        if ($requestedTotal > $availableStock) {
            $canAdd = $availableStock - $alreadyInCart;
            if ($canAdd <= 0) {
                if ($request->expectsJson()) {
                    return response()->json(['error' => "You already have the maximum available stock of \"{$product->product_name}\" in your cart ({$availableStock} units)."], 422);
                }
                return redirect()->back()->with('error', "You already have the maximum available stock of \"{$product->product_name}\" in your cart ({$availableStock} units).");
            }
            if ($request->expectsJson()) {
                return response()->json(['error' => "Sorry, only {$availableStock} unit(s) of \"{$product->product_name}\" are available. You already have {$alreadyInCart} in your cart."], 422);
            }
            return redirect()->back()->with('error', "Sorry, only {$availableStock} unit(s) of \"{$product->product_name}\" are available. You already have {$alreadyInCart} in your cart.");
        }

        $unitPrice = $product->sale_price;

        if ($cartItem) {
            // Keep cart line price synced with current product sale/base price.
            $cartItem->unit_price = $unitPrice;
            $cartItem->quantity += $request->quantity;
            $cartItem->subtotal = $cartItem->quantity * $cartItem->unit_price;
            $cartItem->save();
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $request->quantity * $unitPrice
            ]);
        }

        $count = (int) $cart->items()->sum('quantity');

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Product added to cart!',
                'count' => $count,
            ]);
        }

        return redirect()->back()->with('message', 'Product added to cart!');
    }

    public function buyNow(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = (int) $request->quantity;

        if ($product->stock <= 0) {
            return redirect()->back()->with('error', "\"{$product->product_name}\" is currently out of stock.");
        }

        if ($quantity > $product->stock) {
            return redirect()->back()->with('error', "Sorry, only {$product->stock} unit(s) of \"{$product->product_name}\" are available.");
        }

        $cart = $this->getOrCreateCart();

        // Buy now should checkout only the selected product.
        $cart->items()->delete();
        $unitPrice = $product->sale_price;
        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'subtotal' => $quantity * $unitPrice
        ]);

        return redirect()->route('checkout');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::findOrFail($id);
        $product = Product::find($cartItem->product_id);

        // Validate against available stock
        if ($product) {
            $availableStock = $product->stock;
            if ($request->quantity > $availableStock) {
                $msg = $availableStock > 0
                    ? "Sorry, only {$availableStock} unit(s) of \"{$product->product_name}\" are available."
                    : "\"{$product->product_name}\" is currently out of stock.";

                if ($request->expectsJson()) {
                    return response()->json(['error' => $msg], 422);
                }
                return redirect()->route('cart.index')->with('error', $msg);
            }
        }

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

        // Fallback for guests
        abort(403, 'Please login to use the cart.');
    }
}
