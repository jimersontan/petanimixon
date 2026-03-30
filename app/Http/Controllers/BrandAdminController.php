<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Traits\RoleBasedAuthorization;

class BrandAdminController extends Controller
{
    use RoleBasedAuthorization;

    /**
     * Display a list of brands with product counts.
     * Only Main Admin and Supervisor can manage brands
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
        $this->ensureNotStaffAdmin('Staff Admin cannot create brands.');
        return view('brands.create');
    }

    public function store(Request $request)
    {
        $this->ensureNotStaffAdmin('Staff Admin cannot create brands.');
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

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        // Soft-deactivate brand instead of hard delete
        $brand->update(['is_active' => false]);
        return redirect()->route('brands.admin')->with('success', 'Brand deactivated');
    }
}
