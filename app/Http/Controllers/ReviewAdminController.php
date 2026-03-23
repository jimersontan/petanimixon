<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewAdminController extends Controller
{
    /**
     * Show a paginated list of reviews along with dashboard stats.
     */
    public function index(Request $request)
    {
        $days = (int) $request->get('days', 30);
        $from = now()->subDays($days);

        $emptyStats = [
            'avg_rating' => 0,
            'total_reviews' => 0,
            'pending_reviews' => 0,
            'response_rate' => 0,
        ];

        try {
            $query = Review::query();
            if ($request->has('days')) {
                $query->where('created_at', '>=', $from);
            }

            $total = (clone $query)->count();
            $stats = [
                'avg_rating' => round((clone $query)->avg('rating') ?: 0, 1),
                'total_reviews' => $total,
                'pending_reviews' => (clone $query)->where('status', 'pending')->count(),
                'response_rate' => $total ? ((clone $query)->whereNotNull('seller_response')->count() / $total) * 100 : 0,
            ];

            $reviews = Review::with(['product', 'user'])
                ->when($request->has('days'), function ($q) use ($from) {
                    $q->where('created_at', '>=', $from);
                })
                ->orderByDesc('created_at')
                ->paginate(15);

            return view('reviews_admin', [
                'reviews' => $reviews,
                'stats' => $stats,
                'days' => $days,
            ]);
        } catch (\Throwable $e) {
            $reviews = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15, 1, ['path' => $request->url(), 'query' => $request->query()]);
            return view('reviews_admin', [
                'reviews' => $reviews,
                'stats' => $emptyStats,
                'days' => $days,
            ]);
        }
    }
}
