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
            ->appends($request->query());

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
     * Persist a new product to the database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'animal_type_ids' => 'required|array',
            'animal_type_ids.*' => 'integer|exists:animal_types,id',
            'life_stages' => 'nullable|array',
            'animal_category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|unique:products,sku',
            'stock' => 'nullable|integer|min:0',
            'image' => 'nullable|image|max:4096',
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'brand_name' => 'nullable|string',
            'wet_or_dry' => 'nullable|in:wet,dry',
        ]);
        if (($data['brand_name'] ?? '') === '' || ($data['brand_name'] ?? null) === null) {
            $data['brand_name'] = ''; // empty string, not null (column doesn't allow null)
        }
        if (($data['short_description'] ?? '') === '' || ($data['short_description'] ?? null) === null) {
            $data['short_description'] = ''; // empty string, not null (column doesn't allow null)
        }
        // handle product image upload
        if ($request->hasFile('image')) {
            $data['animal_image_url'] = $request->file('image')->store('products', 'public');
        }

        // Calculate comma separated strings for backwards compatibility
        $animalTypeNames = [];
        $lifeStageNames = [];
        $syncData = [];
        foreach ($data['animal_type_ids'] as $id) {
            $at = \Illuminate\Support\Facades\DB::table('animal_types')->find($id);
            if ($at) {
                $animalTypeNames[] = $at->animal_type;
                $stage = $data['life_stages'][$id] ?? null;
                if ($stage) {
                    $lifeStageNames[] = ucfirst($stage);
                }
                $syncData[$id] = ['life_stage' => $stage];
            }
        }
        $data['animal_type'] = implode(', ', $animalTypeNames);
        $data['life_stage'] = implode(', ', array_unique(array_filter($lifeStageNames)));
        
        unset($data['animal_type_ids']);
        // Auto-assign status based on stock
        if (isset($data['stock'])) {
            $data['product_status'] = ((int) $data['stock'] > 0) ? 'active' : 'out_of_stock';
        } else {
            $data['product_status'] = 'out_of_stock';
        }

        $product = Product::create($data + ['seller_id' => 0]);
        // sync many-to-many relationship
        try { $product->animalTypes()->sync($syncData); } catch (\Exception $e) {}

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
     * Update a product.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'animal_type_ids' => 'required|array',
            'animal_type_ids.*' => 'integer|exists:animal_types,id',
            'life_stages' => 'nullable|array',
            'animal_category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'stock' => 'nullable|integer|min:0',
            'image' => 'nullable|image|max:4096',
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'brand_name' => 'nullable|string',
            'wet_or_dry' => 'nullable|in:wet,dry',
        ]);
        if (($data['brand_name'] ?? '') === '' || $data['brand_name'] === null) {
            $data['brand_name'] = ''; // use empty string, not null (column doesn't allow null)
        }
        if (($data['short_description'] ?? '') === '' || ($data['short_description'] ?? null) === null) {
            $data['short_description'] = ''; // empty string, not null (column doesn't allow null)
        }
        if (array_key_exists('stock', $data) && $data['stock'] === 0) {
            $data['product_status'] = 'out_of_stock';
        }
        if ($request->hasFile('image')) {
            $data['animal_image_url'] = $request->file('image')->store('products', 'public');
        }

        // Calculate comma separated strings for backwards compatibility
        $animalTypeNames = [];
        $lifeStageNames = [];
        $syncData = [];
        foreach ($data['animal_type_ids'] as $typeId) {
            $at = \Illuminate\Support\Facades\DB::table('animal_types')->find($typeId);
            if ($at) {
                $animalTypeNames[] = $at->animal_type;
                $stage = $data['life_stages'][$typeId] ?? null;
                if ($stage) {
                    $lifeStageNames[] = ucfirst($stage);
                }
                $syncData[$typeId] = ['life_stage' => $stage];
            }
        }
        $data['animal_type'] = implode(', ', $animalTypeNames);
        $data['life_stage'] = implode(', ', array_unique(array_filter($lifeStageNames)));
        
        unset($data['animal_type_ids']);
        unset($data['life_stages']);

        // Auto-assign status based on stock if the product wasn't manually drafted
        if ($product->product_status !== 'draft') {
            if (isset($data['stock'])) {
                $data['product_status'] = ((int) $data['stock'] > 0) ? 'active' : 'out_of_stock';
            } else {
                $data['product_status'] = 'out_of_stock';
            }
        }

        $product->update($data);
        try { $product->animalTypes()->sync($syncData); } catch (\Exception $e) {}

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
     * Move a product to draft status.
     */
    public function draft($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['product_status' => 'draft']);
        return redirect()->route('inventory.admin')->with('success', 'Product moved to draft');
    }

    /**
     * Permanently delete a product (only allowed for draft products).
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        // Only allow permanent deletion of draft products
        if ($product->product_status !== 'draft') {
            return redirect()->route('inventory.admin')->with('error', 'Only draft products can be permanently deleted. Move to draft first.');
        }

        // Check if product is in any orders
        if ($product->orderItems()->count() > 0) {
            return redirect()->route('inventory.admin')->with('error', 'Cannot delete product because it is linked to past orders. Keep it as Draft instead.');
        }

        try {
            $product->variants()->delete();
            $product->reviews()->delete();
            \DB::table('cart_items')->where('product_id', $product->id)->delete();
            \DB::table('wishlists')->where('product_id', $product->id)->delete();
            \DB::table('product_questions')->where('product_id', $product->id)->delete();
            $product->delete();
            return redirect()->route('inventory.admin')->with('success', 'Product permanently deleted');
        } catch (\Exception $e) {
            return redirect()->route('inventory.admin')->with('error', 'Cannot delete product due to existing data linkages. Please keep it as Draft.');
        }
    }

    /**
     * Store detailed sale data for a product.
     */
    public function storeSale(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_type' => 'required|in:percent,fixed',
            'discount_amount' => 'required|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'is_featured' => 'nullable|boolean',
        ]);

        $product = Product::findOrFail($data['product_id']);
        $product->is_reduced = true;
        $product->discount_type = $data['discount_type'];
        $product->discount_amount = $data['discount_amount'];
        $product->sale_valid_from = $data['valid_from'];
        $product->sale_valid_until = $data['valid_until'];

        if (isset($data['is_featured']) && $data['is_featured']) {
            $product->is_featured = true;
        }

        $product->save();

        return redirect()->back()->with('success', 'Product sale configured successfully.');
    }

    /**
     * Toggle product sale status (is_reduced)
     */
    public function toggleSale($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->is_reduced = !$product->is_reduced;
            if (!$product->is_reduced) {
                $product->discount_type = null;
                $product->discount_amount = null;
                $product->sale_valid_from = null;
                $product->sale_valid_until = null;
            }
            $product->save();

            $status = $product->is_reduced ? 'added to' : 'removed from';
            return redirect()->back()->with('success', "Product $status sale.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to toggle sale status.');
        }
    }

    /**
     * Toggle product featured status (is_featured) for homepage display
     */
    public function toggleFeatured($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->is_featured = !$product->is_featured;
            $product->save();

            $status = $product->is_featured ? 'added to' : 'removed from';
            return redirect()->back()->with('success', "Product $status homepage featured.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to toggle featured status.');
        }
    }
}
