<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\SellerPayout;
use Illuminate\Http\Request;

class SellerAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Seller::withCount('products');

        if ($request->filled('status')) {
            if ($request->status === 'verified') {
                $query->where('verification_status', 'verified');
            } elseif ($request->status === 'pending') {
                $query->where('verification_status', 'pending');
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $sellers = $query->orderByDesc('created_at')->paginate(15)->appends($request->query());

        $stats = [
            'total' => Seller::count(),
            'verified' => Seller::where('verification_status', 'verified')->count(),
            'pending' => Seller::where('verification_status', 'pending')->count(),
            'inactive' => Seller::where('is_active', false)->count(),
        ];

        $payouts = SellerPayout::with('seller')
            ->orderByDesc('created_at')
            ->take(20)
            ->get();

        return view('sellers_admin', compact('sellers', 'stats', 'payouts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'business_name' => 'required|string|max:255',
            'business_email' => 'required|email|max:255',
            'business_phone' => 'required|string|max:30',
            'business_registration_number' => 'required|string|max:100',
            'business_registration_number_type' => 'required|string|max:50',
            'business_description' => 'nullable|string',
            'store_name' => 'required|string|max:255',
            'store_description' => 'nullable|string',
        ]);

        $data['verification_status'] = 'pending';
        $data['is_active'] = true;

        Seller::create($data);

        return redirect()->route('sellers.admin')->with('success', 'Seller added successfully.');
    }

    public function update(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);

        $data = $request->validate([
            'business_name' => 'required|string|max:255',
            'business_email' => 'required|email|max:255',
            'business_phone' => 'required|string|max:30',
            'business_registration_number' => 'required|string|max:100',
            'business_registration_number_type' => 'required|string|max:50',
            'business_description' => 'nullable|string',
            'store_name' => 'required|string|max:255',
            'store_description' => 'nullable|string',
            'verification_status' => 'nullable|in:pending,verified,rejected',
        ]);

        $seller->update($data);

        return redirect()->route('sellers.admin')->with('success', 'Seller updated.');
    }

    public function toggleStatus($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->update(['is_active' => !$seller->is_active]);

        return redirect()->route('sellers.admin')->with('success', 'Seller status toggled.');
    }

    public function processPayout(Request $request)
    {
        $data = $request->validate([
            'seller_id' => 'required|exists:sellers,id',
            'payout_amount' => 'required|numeric|min:1',
            'payout_method' => 'required|string|in:gcash,bank_transfer,cash',
            'bank_account_details' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $data['payout_status'] = 'completed';
        $data['transaction_reference'] = 'PO-' . strtoupper(\Illuminate\Support\Str::random(10));

        SellerPayout::create($data);

        return redirect()->route('sellers.admin')->with('success', 'Payout processed successfully.');
    }
}
