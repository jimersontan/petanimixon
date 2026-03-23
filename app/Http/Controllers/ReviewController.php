<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewLike;
use App\Models\ReviewReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Store a new review for a product.
     */
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
            'review_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $images = [];
        if ($request->hasFile('review_images')) {
            foreach (array_slice($request->file('review_images'), 0, 4) as $img) {
                $images[] = $img->store('reviews', 'public');
            }
        }

        Review::create([
            'product_id' => $productId,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'images' => !empty($images) ? $images : null,
        ]);

        return redirect()->back()->with('message', 'Review submitted successfully!');
    }

    /**
     * Toggle like on a review.
     */
    public function toggleLike($reviewId)
    {
        $existing = ReviewLike::where('review_id', $reviewId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            ReviewLike::create([
                'review_id' => $reviewId,
                'user_id' => Auth::id(),
            ]);
            $liked = true;
        }

        $count = ReviewLike::where('review_id', $reviewId)->count();

        return response()->json(['liked' => $liked, 'count' => $count]);
    }

    /**
     * Store a reply to a review.
     */
    public function reply(Request $request, $reviewId)
    {
        $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        ReviewReply::create([
            'review_id' => $reviewId,
            'user_id' => Auth::id(),
            'reply' => $request->reply,
        ]);

        return redirect()->back()->with('message', 'Reply posted!');
    }
}
