<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Show the user's wishlist page.
     */
    public function index()
    {
        $items = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->orderByDesc('created_at')
            ->get();

        return view('frontend.wishlist', compact('items'));
    }

    /**
     * Toggle a product in the wishlist (AJAX).
     */
    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $existing = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Removed from wishlist.',
                'count' => Wishlist::where('user_id', Auth::id())->count(),
            ]);
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'status' => 'added',
            'message' => 'Added to wishlist!',
            'count' => Wishlist::where('user_id', Auth::id())->count(),
        ]);
    }

    /**
     * Remove a specific item from the wishlist.
     */
    public function remove($id)
    {
        Wishlist::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->route('wishlist.index')->with('success', 'Item removed from wishlist.');
    }
}
