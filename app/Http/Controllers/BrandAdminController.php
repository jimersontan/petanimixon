<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class BrandAdminController extends Controller
{
    /**
     * Display a list of brands with product counts.
     */
    public function index(Request $request)
    {
        // paginate for the table view
        $brands = Brand::withCount(['products'])->orderBy('name')->paginate(20);

        // compute stats on entire set to avoid pagination skew
        $all = Brand::withCount(['products'])->get();
        $stats = [
            'total_brands' => $all->count(),
            'active_brands' => $all->where('is_active', true)->count(),
            'featured_brands' => $all->where('is_featured', true)->count(),
            'avg_products_per_brand' => $all->avg('products_count'),
        ];

        return view('brands_admin', compact('stats', 'brands'));
    }

    public function create()
    {
        return view('brands.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
        ]);
        // ensure keys exist as booleans
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        Brand::create($data);
        return redirect()->route('brands.admin')->with('success', 'Brand created');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $brand->update($data);
        return redirect()->route('brands.admin')->with('success', 'Brand updated');
    }

    public function destroy($id)
    {
        Brand::destroy($id);
        return redirect()->route('brands.admin')->with('success', 'Brand deleted');
    }
}
