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
        $status = $request->get('status', 'all');

        $query = Brand::withCount(['products'])->orderBy('name');
        
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'draft') {
            $query->where('is_active', false);
        }
        
        // paginate for the table view
        $brands = $query->paginate(20);

        // compute stats on entire set to avoid pagination skew
        $all = Brand::withCount(['products'])->get();
        $stats = [
            'total_brands' => $all->count(),
            'active_brands' => $all->where('is_active', true)->count(),
            'featured_brands' => $all->where('is_featured', true)->count(),
            'avg_products_per_brand' => $all->avg('products_count'),
        ];

        return view('brands_admin', compact('stats', 'brands', 'status'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'description' => 'nullable|string',
            'website_url' => 'nullable|url|max:255',
            'logo' => 'nullable|image|max:2048',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
        ]);
        // ensure keys exist as booleans
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('brands', 'public');
        }
        Brand::create($data);
        return redirect()->route('brands.admin')->with('success', 'Brand created');
    }


    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'description' => 'nullable|string',
            'website_url' => 'nullable|url|max:255',
            'logo' => 'nullable|image|max:2048',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('brands', 'public');
        }
        $brand->update($data);
        return redirect()->route('brands.admin')->with('success', 'Brand updated');
    }

    /**
     * Move a brand to draft (inactive) status.
     */
    public function draft($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->update(['is_active' => false]);
        return redirect()->route('brands.admin')->with('success', 'Brand moved to draft');
    }

    /**
     * Permanently delete a brand (only allowed for inactive/draft brands).
     */
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        // Only allow permanent deletion of inactive (draft) brands
        if ($brand->is_active) {
            return redirect()->route('brands.admin')->with('error', 'Only draft/inactive brands can be permanently deleted. Move to draft first.');
        }
        if ($brand->products()->count() > 0) {
            return redirect()->route('brands.admin')->with('error', 'Cannot delete brand. It has active products assigned to it. Reassign or delete the products first.');
        }
        $brand->delete();
        return redirect()->route('brands.admin')->with('success', 'Brand permanently deleted');
    }
}
