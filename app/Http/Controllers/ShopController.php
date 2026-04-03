<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ShopController extends Controller
{
    /**
     * Show the main shop landing page.
     */
    public function index(Request $request)
    {
        $categories = Category::where('is_active', 1)->orderBy('category_name')->get();
        $featured = Product::where('is_featured', 1)->limit(12)->get();

        // Top 2 best-sellers by order count
        $bestSellers = Product::where('product_status', 'active')
            ->withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->limit(2)
            ->get();

        // Fill with random products if not enough best-sellers
        $randomProducts = Product::where('product_status', 'active')
            ->whereNotIn('id', $bestSellers->pluck('id'))
            ->inRandomOrder()
            ->limit(2)
            ->get();

        // Merge: best-sellers first, then random
        $heroProducts = $bestSellers->merge($randomProducts);

        return view('user_dashboard', [
            'categories' => $categories,
            'featuredProducts' => $featured,
            'heroProducts' => $heroProducts,
        ]);
    }

    /**
     * Show the shop page with all products and filtering.
     */
    public function shop(Request $request)
    {
        $query = Product::where('product_status', 'active');

        // Filter by brand
        if ($request->has('brand') && !empty($request->input('brand'))) {
            $query->where('brand_name', $request->input('brand'));
        }

        // Filter by pet type
        if ($request->has('pet_type') && !empty($request->input('pet_type'))) {
            $query->whereIn('animal_type', $request->input('pet_type'));
        }

        // Filter by category
        if ($request->has('category') && !empty($request->input('category'))) {
            $query->whereIn('animal_category_id', $request->input('category'));
        }

        // Filter by price range
        $priceMax = $request->input('price_max');
        if ($priceMax > 0) {
            $query->where('price', '<=', $priceMax);
        }

        // Filter by rating
        if ($request->has('rating') && $request->input('rating')) {
            $query->where('rating', '>=', $request->input('rating'));
        }

        // Filter by stock
        if ($request->input('in_stock')) {
            $query->whereHas('variants', function($q) {
                $q->where('variant_quantity', '>', 0);
            });
        }

        // Filter by sale
        if ($request->input('on_sale')) {
            $query->where('is_reduced', 1);
        }

        // Sort
        $sortBy = $request->input('sort', 'featured');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'best_sellers':
                $query->orderBy('sales_count', 'desc');
                break;
            default:
                $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(24);
        
        $categories = Category::where('is_active', true)
            ->withCount(['products' => function($q) {
                $q->where('product_status', 'active');
            }])
            ->orderBy('category_name')
            ->get();
            
        $brands = \App\Models\Brand::where('is_active', true)
            ->withCount(['products' => function($q) {
                $q->where('product_status', 'active');
            }])
            ->orderBy('name')
            ->get();
            
        $petTypes = Product::where('product_status', 'active')
            ->select('animal_type', \DB::raw('count(*) as count'))
            ->groupBy('animal_type')
            ->orderBy('animal_type')
            ->get();

        return view('frontend.shop', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'petTypes' => $petTypes,
        ]);
    }

    /**
     * Show the list of brands.
     */
    public function brands()
    {
        $brands = \App\Models\Brand::where('is_active', true)
            ->withCount(['products' => function($q) {
                $q->where('product_status', 'active');
            }])
            ->orderBy('name')
            ->get();

        $featuredBrand = \App\Models\Brand::where('is_active', true)
            ->where('is_featured', true)
            ->first() ?? $brands->first();

        return view('frontend.brands', compact('brands', 'featuredBrand'));
    }

    /**
     * Show the list of categories.
     */
    public function categories(Request $request)
    {
        $categories = Category::where('is_active', 1)->orderBy('sort_order')->get();
        return view('frontend.categories', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show a single category and its products.
     */
    public function showCategory($id)
    {
        $category = Category::with('products')->findOrFail($id);
        return view('frontend.category', [
            'category' => $category,
            'products' => $category->products()->limit(24)->get(),
        ]);
    }

    /**
     * Show a single product detail page.
     */
    public function showProduct($id)
    {
        $product = Product::with('category', 'variants')->findOrFail($id);

        $reviews = $product->reviews()
            ->with(['user', 'replies.user', 'likes'])
            ->orderByDesc('created_at')
            ->get();

        $reviewStats = [
            'count' => $reviews->count(),
            'average' => $reviews->count() ? round($reviews->avg('rating'), 1) : 0,
            'distribution' => collect([5, 4, 3, 2, 1])->mapWithKeys(function ($star) use ($reviews) {
                return [$star => $reviews->where('rating', $star)->count()];
            }),
        ];

        return view('frontend.product', [
            'product' => $product,
            'reviews' => $reviews,
            'reviewStats' => $reviewStats,
        ]);
    }

    /**
     * Return product modal content via AJAX.
     */
    public function productModal($id)
    {
        $product = Product::with('category', 'variants')->findOrFail($id);

        $reviews = $product->reviews()
            ->with(['user', 'replies.user', 'likes'])
            ->orderByDesc('created_at')
            ->get();

        $reviewStats = [
            'count' => $reviews->count(),
            'average' => $reviews->count() ? round($reviews->avg('rating'), 1) : 0,
            'distribution' => collect([5, 4, 3, 2, 1])->mapWithKeys(function ($star) use ($reviews) {
                return [$star => $reviews->where('rating', $star)->count()];
            }),
        ];

        return view('frontend.partials.product_modal_content', [
            'product' => $product,
            'reviews' => $reviews,
            'reviewStats' => $reviewStats,
        ]);
    }
}
