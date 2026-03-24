<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductAdminController extends Controller
{
    /**
     * Display a list of products with stats.
     */
    private function prepareProductList(Request $request)
    {
        $days = (int) $request->get('days', 30);
        $from = now()->subDays($days);

        $status = $request->get('status', 'all');

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
        if ($status !== 'all') {
            $productsQuery->where('product_status', $status);
        }
        if ($request->has('days')) {
            $productsQuery->where('created_at', '>=', $from);
        }

        if ($request->filled('brand')) {
            if ($request->brand === 'unbranded') {
                $productsQuery->where(function($q) {
                    $q->whereNull('brand_name')->orWhere('brand_name', '');
                });
            } else {
                $productsQuery->where('brand_name', $request->brand);
            }
        }

        $products = $productsQuery
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $categories = \App\Models\Category::where('is_active', true)->orderBy('category_name')->get();
        $brands = \App\Models\Brand::where('is_active', true)->orderBy('name')->get();
        $animal_types = \Illuminate\Support\Facades\DB::table('animal_types')->orderBy('animal_type')->get();

        $selectedBrand = $request->get('brand', '');

        return compact('stats', 'products', 'days', 'status', 'categories', 'brands', 'animal_types', 'selectedBrand');
    }

    public function index(Request $request)
    {
        return view('inventory_admin', $this->prepareProductList($request));
    }

    public function readOnlyIndex(Request $request)
    {
        return view('products_readonly', $this->prepareProductList($request));
    }

    /**
     * Show form to create a new product.
     */
    public function create()
    {
        $categories = \App\Models\Category::where('is_active', true)->orderBy('category_name')->get();
        $brands = \App\Models\Brand::where('is_active', true)->orderBy('name')->get();
        $animal_types = \Illuminate\Support\Facades\DB::table('animal_types')->orderBy('animal_type')->get();
        return view('products.create', compact('categories', 'brands', 'animal_types'));
    }

    /**
     * Persist a new product to the database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'animal_type_id' => 'required|integer|exists:animal_types,id',
            'animal_category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|unique:products,sku',
            'stock' => 'nullable|integer|min:0',
            'image' => 'nullable|image|max:4096',
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'brand_name' => 'nullable|string',
            'product_status' => 'required|in:active,draft,out_of_stock',
        ]);
        if (($data['brand_name'] ?? '') === '' || ($data['brand_name'] ?? null) === null) {
            $data['brand_name'] = ''; // empty string, not null (column doesn't allow null)
        }
        // handle product image upload
        if ($request->hasFile('image')) {
            $data['animal_image_url'] = $request->file('image')->store('products', 'public');
        }

        // Look up the name of the animal type to save it in animal_type column
        if (!empty($data['animal_type_id'])) {
            $animalType = \Illuminate\Support\Facades\DB::table('animal_types')->find($data['animal_type_id']);
            if ($animalType) {
                $data['animal_type'] = $animalType->animal_type;
            }
        }
        unset($data['animal_type_id']);

        $product = Product::create($data + ['seller_id' => 0]);

        // create a simple default variant using stock & price if stock provided
        if (!empty($data['stock'])) {
            $product->variants()->create([
                'variant_name' => 'Default',
                'variant_quantity' => $data['stock'],
                'uom' => null,
                'variant_price' => $data['price'],
                'sku' => $data['sku'].'-VAR',
                'specifications' => null,
                'low_stock_threshold' => null,
                'product_status' => $data['product_status'],
            ]);
        }

        return redirect()->route('inventory.admin')->with('success', 'Product created');
    }

    /**
     * Edit form for an existing product.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = \App\Models\Category::where('is_active', true)->orderBy('category_name')->get();
        $brands = \App\Models\Brand::where('is_active', true)->orderBy('name')->get();
        $animal_types = \Illuminate\Support\Facades\DB::table('animal_types')->orderBy('animal_type')->get();
        return view('products.edit', compact('product', 'categories', 'brands', 'animal_types'));
    }

    /**
     * Update a product.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'animal_type_id' => 'required|integer|exists:animal_types,id',
            'animal_category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'stock' => 'nullable|integer|min:0',
            'image' => 'nullable|image|max:4096',
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'brand_name' => 'nullable|string',
            'product_status' => 'required|in:active,draft,out_of_stock',
        ]);
        if (($data['brand_name'] ?? '') === '' || $data['brand_name'] === null) {
            $data['brand_name'] = ''; // use empty string, not null (column doesn't allow null)
        }
        if (array_key_exists('stock', $data) && $data['stock'] === 0) {
            $data['product_status'] = 'out_of_stock';
        }
        if ($request->hasFile('image')) {
            $data['animal_image_url'] = $request->file('image')->store('products', 'public');
        }

        // Look up the name of the animal type to save it in animal_type column
        if (!empty($data['animal_type_id'])) {
            $animalType = \Illuminate\Support\Facades\DB::table('animal_types')->find($data['animal_type_id']);
            if ($animalType) {
                $data['animal_type'] = $animalType->animal_type;
            }
        }
        unset($data['animal_type_id']);

        $product->update($data);

        // optionally sync stock to the first variant if exists or create one
        if ($data['stock'] !== null) {
            $variant = $product->variants()->first();
            if ($variant) {
                $variant->update([
                    'variant_quantity' => $data['stock'],
                    'variant_price' => $data['price'],
                    'product_status' => $data['product_status'],
                ]);
            } else {
                $product->variants()->create([
                    'variant_name' => 'Default',
                    'variant_quantity' => $data['stock'],
                    'uom' => null,
                    'variant_price' => $data['price'],
                    'sku' => $data['sku'].'-VAR',
                    'specifications' => null,
                    'low_stock_threshold' => null,
                    'product_status' => $data['product_status'],
                ]);
            }
        }
        return redirect()->route('inventory.admin')->with('success', 'Product updated');
    }

    /**
     * Delete a product.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        // Instead of hard-deleting, mark as draft so it can be edited later
        $product->update(['product_status' => 'draft']);
        return redirect()->route('inventory.admin')->with('success', 'Product moved to draft');
    }
}
