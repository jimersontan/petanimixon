<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryAdminController extends Controller
{
    /**
     * Display category hierarchy and stats.
     */
    public function index(Request $request)
    {
        $stats = [
            'total_categories' => Category::count(),
            'active_categories' => Category::where('is_active', true)->count(),
            'total_products' => Product::count(),
            'avg_products_per_category' => Category::has('products')->withCount('products')->get()->avg('products_count'),
        ];

        $status = $request->get('status', 'all');

        $query = Category::with('parent')
            ->withCount('products')
            ->orderBy('category_name');
            
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'draft') {
            $query->where('is_active', false);
        }
            
        $categories = $query->get();

        // for modal creation form
        $parents = Category::orderBy('category_name')->get();

        // Animal types for the second table
        $animalTypesQuery = \DB::table('animal_types')
            ->orderBy('sort_order')
            ->orderBy('id');
            
        if ($status === 'active') {
            // using string literals matching what we saw in DB/blade (Active, Draft, etc.)
            $animalTypesQuery->where('status', 'Active');
        } elseif ($status === 'draft') {
            $animalTypesQuery->where('status', 'Draft');
        }

        $animalTypes = $animalTypesQuery->get()
            ->map(function ($t) {
                $t->product_count = Product::where('animal_type', $t->animal_type)->count();
                $t->image_full_url = $t->image_url ? asset('storage/' . $t->image_url) : '';
                return $t;
            });

        return view('categories_admin', compact('stats', 'categories', 'parents', 'status', 'animalTypes'));
    }


    /**
     * Persist new category.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:255',
            'is_active' => 'sometimes|boolean',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'sometimes|boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);
        return redirect()->route('categories.admin')->with('success', 'Category created');
    }


    /**
     * Update category.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validate([
            'category_name' => 'required|string|max:255',
            'is_active' => 'sometimes|boolean',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'sometimes|boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);
        return redirect()->route('categories.admin')->with('success', 'Category updated');
    }

    /**
     * Move a category to draft (inactive) status.
     */
    public function draft($id)
    {
        $category = Category::findOrFail($id);
        $category->update(['is_active' => false]);
        return redirect()->route('categories.admin')->with('success', 'Category moved to draft');
    }

    /**
     * Restore a drafted category back to active.
     */
    public function restore($id)
    {
        $category = Category::findOrFail($id);
        $category->update(['is_active' => true]);
        return redirect()->route('categories.admin')->with('success', 'Category restored to active');
    }

    /**
     * Permanently delete category.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        // Only allow permanent deletion of inactive (draft) categories
        if ($category->is_active) {
            return redirect()->route('categories.admin')->with('error', 'Only inactive categories can be permanently deleted. Move to draft first.');
        }
        if ($category->products()->count() > 0) {
            return redirect()->route('categories.admin')->with('error', 'Cannot delete category. It contains products. Reassign or delete the products first.');
        }
        $category->delete();
        return redirect()->route('categories.admin')->with('success', 'Category permanently deleted');
    }
}
