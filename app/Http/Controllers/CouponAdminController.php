<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CouponAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Coupon::withCount('usages');

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true)->where('valid_until', '>=', now());
            } elseif ($request->status === 'expired') {
                $query->where('valid_until', '<', now());
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $coupons = $query->orderByDesc('created_at')->paginate(15)->appends($request->query());

        $stats = [
            'total' => Coupon::count(),
            'active' => Coupon::where('is_active', true)->where('valid_until', '>=', now())->count(),
            'expired' => Coupon::where('valid_until', '<', now())->count(),
            'total_uses' => \App\Models\CouponUsage::count(),
        ];

        $products = \App\Models\Product::where('product_status', 'active')->orderBy('product_name')->get();
        
        // Get products marked as on sale/reduced
        $saleProducts = \App\Models\Product::where('product_status', 'active')
            ->where('is_reduced', true)
            ->orderByDesc('updated_at')
            ->paginate(15)->appends($request->query());

        return view('coupons_admin', compact('coupons', 'stats', 'products', 'saleProducts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'coupon_code' => 'required|string|max:50|unique:coupons,coupon_code',
            'coupon_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percent,fixed',
            'discount_amount' => 'required|numeric|min:0',
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'max_usage_limit' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'min_order_value' => 'nullable|numeric|min:0',
        ]);

        $data['coupon_code'] = strtoupper($data['coupon_code']);
        $data['coupon_id'] = 'CPN-' . strtoupper(Str::random(8));
        $data['is_active'] = true;
        $data['featured_product_id'] = $request->input('featured_product_id') ?: null;
        $data['show_on_homepage'] = $request->boolean('show_on_homepage');

        Coupon::create($data);

        return redirect()->route('coupons.admin')->with('success', 'Coupon created successfully.');
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $data = $request->validate([
            'coupon_code' => 'required|string|max:50|unique:coupons,coupon_code,' . $coupon->id,
            'coupon_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percent,fixed',
            'discount_amount' => 'required|numeric|min:0',
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'max_usage_limit' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'min_order_value' => 'nullable|numeric|min:0',
        ]);

        $data['coupon_code'] = strtoupper($data['coupon_code']);
        $data['featured_product_id'] = $request->input('featured_product_id') ?: null;
        $data['show_on_homepage'] = $request->boolean('show_on_homepage');
        $coupon->update($data);

        return redirect()->route('coupons.admin')->with('success', 'Coupon updated.');
    }

    public function toggleStatus($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update(['is_active' => !$coupon->is_active]);

        return redirect()->route('coupons.admin')->with('success', 'Coupon status toggled.');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->usages()->delete();
        $coupon->delete();

        return redirect()->route('coupons.admin')->with('success', 'Coupon deleted.');
    }
}
