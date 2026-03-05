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

        $categories = Category::with('parent')
            ->withCount('products')
            ->orderBy('category_name')
            ->get();

        return view('categories_admin', compact('stats', 'categories'));
    }

    /**
     * Show form for new category.
     */
    public function create()
    {
        $parents = Category::orderBy('category_name')->get();
        return view('categories.create', compact('parents'));
    }

    /**
     * Persist new category.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:255',
            'parent_category_id' => 'nullable|exists:categories,id',
            'is_active' => 'sometimes|boolean',
        ]);

        Category::create($data);
        return redirect()->route('categories.admin')->with('success', 'Category created');
    }

    /**
     * Edit existing category.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $parents = Category::where('id', '!=', $id)->orderBy('category_name')->get();
        return view('categories.edit', compact('category', 'parents'));
    }

    /**
     * Update category.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validate([
            'category_name' => 'required|string|max:255',
            'parent_category_id' => 'nullable|exists:categories,id',
            'is_active' => 'sometimes|boolean',
        ]);

        $category->update($data);
        return redirect()->route('categories.admin')->with('success', 'Category updated');
    }

    /**
     * Delete category.
     */
    public function destroy($id)
    {
        Category::destroy($id);
        return redirect()->route('categories.admin')->with('success', 'Category deleted');
    }
}
