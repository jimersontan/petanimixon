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

        return view('user_dashboard', [
            'categories' => $categories,
            'featuredProducts' => $featured,
        ]);
    }

    /**
     * Show the shop page with all products and filtering.
     */
    public function shop(Request $request)
    {
        $query = Product::where('is_active', 1);

        // Filter by pet type
        if ($request->has('pet_type') && !empty($request->input('pet_type'))) {
            $query->whereIn('pet_type', $request->input('pet_type'));
        }

        // Filter by category
        if ($request->has('category') && !empty($request->input('category'))) {
            $query->whereIn('category_id', $request->input('category'));
        }

        // Filter by price range
        $priceMin = $request->input('price_min', 0);
        if ($priceMin > 0) {
            $query->where('price', '>=', $priceMin);
        }

        // Filter by rating
        if ($request->has('rating') && $request->input('rating')) {
            $query->where('rating', '>=', $request->input('rating'));
        }

        // Filter by stock
        if ($request->input('in_stock')) {
            $query->where('stock', '>', 0);
        }

        // Filter by sale
        if ($request->input('on_sale')) {
            $query->where('is_on_sale', 1);
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
                $query->where('is_featured', 1)->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(24);
        $categories = Category::where('is_active', 1)->orderBy('category_name')->get();

        return view('frontend.shop', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the list of categories.
     */
    public function categories(Request $request)
    {
        $categories = Category::where('is_active', 1)->orderBy('category_name')->get();
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
        $product = Product::with('category')->findOrFail($id);
        return view('frontend.product', [
            'product' => $product,
        ]);
    }
}
