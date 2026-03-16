<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Traits\RoleBasedAuthorization;

class ProductAdminController extends Controller
{
    use RoleBasedAuthorization;

    /**
     * Display a list of products with stats.
     */
    public function index(Request $request)
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

        $products = $productsQuery
            ->orderByDesc('created_at')
            ->paginate(15);

        $categories = \App\Models\Category::where('is_active', true)->orderBy('category_name')->get();
        $brands = \App\Models\Brand::where('is_active', true)->orderBy('name')->get();

        return view('products_admin', compact('stats', 'products', 'days', 'status', 'categories', 'brands'));
    }

    /**
     * Show form to create a new product.
     */
    public function create()
    {
        $categories = \App\Models\Category::where('is_active', true)->orderBy('category_name')->get();
        $brands = \App\Models\Brand::where('is_active', true)->orderBy('name')->get();
        return view('products.create', compact('categories', 'brands'));
    }

    /**
     * Persist a new product to the database.
     * Staff Admin can create products, Supervisors can create products, but it's restricted
     */
    public function store(Request $request)
    {
        // Staff Admin and Supervisor can create products, but Main Admin has full control
        // This is enforced by middleware, controller just validates data
        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'animal_type' => 'nullable|string|max:255',
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
        return view('products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update a product.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'animal_type' => 'nullable|string|max:255',
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
        return redirect()->route('products.admin')->with('success', 'Product updated');
    }

    /**
     * Delete a product.
     * Only Main Admin and Supervisor can delete products
     */
    public function destroy($id)
    {
        // Staff Admin should not be able to delete products
        $this->ensureNotStaffAdmin('Staff Admin cannot delete products. Only Main Admin and Supervisor can delete products.');
        
        $product = Product::findOrFail($id);
        // Instead of hard-deleting, mark as draft so it can be edited later
        $product->update(['product_status' => 'draft']);
        return redirect()->route('products.admin')->with('success', 'Product moved to draft');
    }
}
