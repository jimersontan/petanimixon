<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductAdminController extends Controller
{
    /**
     * Display a list of products with stats.
     */
    public function index(Request $request)
    {
        $days = (int) $request->get('days', 30);
        $from = now()->subDays($days);

        // by default stats are for all-time, but we can optionally filter by creation date
        $base = Product::query();
        if ($request->has('days')) {
            $base->where('created_at', '>=', $from);
        }

        // total and active easy
        $total = (clone $base)->count();
        $active = (clone $base)->where('product_status', 'active')->count();

        // low and out of stock must inspect variants since products no longer have a stock column
        $lowStockQuery = (clone $base)->whereHas('variants', function ($q) {
            $q->where('variant_quantity', '<', 10);
        });
        $outOfStockQuery = (clone $base)->whereHas('variants', function ($q) {
            $q->where('variant_quantity', 0);
        });

        $stats = [
            'total_products' => $total,
            'active_products' => $active,
            'low_stock' => $lowStockQuery->count(),
            'out_of_stock' => $outOfStockQuery->count(),
        ];

        // include variants so the stock accessor doesn't hit the database repeatedly
        $productsQuery = Product::with(['category', 'variants']);
        if ($request->has('days')) {
            $productsQuery->where('created_at', '>=', $from);
        }

        $products = $productsQuery
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('products_admin', compact('stats', 'products', 'days'));
    }

    /**
     * Show form to create a new product.
     */
    public function create()
    {
        $categories = \App\Models\Category::where('is_active', true)->orderBy('category_name')->get();
        $brands = \App\Models\Brand::where('is_active', true)->orderBy('name')->get();
        $animalTypes = \DB::table('animal_types')->orderBy('animal_type')->get();
        return view('products.create', compact('categories', 'brands', 'animalTypes'));
    }

    /**
     * Persist a new product to the database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'animal_type_id' => 'required|exists:animal_types,id',
            'animal_category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|unique:products,sku',
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'brand_name' => 'nullable|string',
            'product_status' => 'required|in:active,draft,out_of_stock',
        ]);

        Product::create($data + ['seller_id' => 0]);

        return redirect()->route('products.admin')->with('success', 'Product created');
    }

    /**
     * Edit form for an existing product.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = \App\Models\Category::where('is_active', true)->orderBy('category_name')->get();
        $brands = \App\Models\Brand::where('is_active', true)->orderBy('name')->get();
        $animalTypes = \DB::table('animal_types')->orderBy('animal_type')->get();
        return view('products.edit', compact('product', 'categories', 'brands', 'animalTypes'));
    }

    /**
     * Update a product.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'animal_type_id' => 'required|exists:animal_types,id',
            'animal_category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'brand_name' => 'nullable|string',
            'product_status' => 'required|in:active,draft,out_of_stock',
        ]);

        $product->update($data);
        return redirect()->route('products.admin')->with('success', 'Product updated');
    }

    /**
     * Delete a product.
     */
    public function destroy($id)
    {
        Product::destroy($id);
        return redirect()->route('products.admin')->with('success', 'Product deleted');
    }
}
