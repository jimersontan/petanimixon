<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourierAdminController extends Controller
{
    /**
     * Display all couriers.
     */
    public function index()
    {
        $couriers = Courier::orderByDesc('is_active')->orderBy('name')->paginate(20);

        $totalCouriers = Courier::count();
        $activeCouriers = Courier::where('is_active', true)->count();
        $deliveriesToday = 0; // Future: count orders dispatched today via courier

        return view('couriers_admin', compact(
            'couriers',
            'totalCouriers',
            'activeCouriers',
            'deliveriesToday'
        ));
    }

    /**
     * Store a new courier.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tracking_url' => 'required|url|max:500',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'is_active' => 'nullable',
        ]);

        $logoUrl = null;

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('couriers', 'public');
            $logoUrl = '/storage/' . $path;
        }

        Courier::create([
            'name' => $request->name,
            'tracking_url' => $request->tracking_url,
            'logo_url' => $logoUrl,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('couriers.admin')->with('success', 'Courier added successfully!');
    }

    /**
     * Show edit form (redirect with edit modal).
     */
    public function edit($id)
    {
        $couriers = Courier::orderByDesc('is_active')->orderBy('name')->paginate(20);

        $totalCouriers = Courier::count();
        $activeCouriers = Courier::where('is_active', true)->count();
        $deliveriesToday = 0;

        $editCourier = Courier::findOrFail($id);
        $showEditModal = true;

        return view('couriers_admin', compact(
            'couriers',
            'totalCouriers',
            'activeCouriers',
            'deliveriesToday',
            'editCourier',
            'showEditModal'
        ));
    }

    /**
     * Update an existing courier.
     */
    public function update(Request $request, $id)
    {
        $courier = Courier::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'tracking_url' => 'required|url|max:500',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'is_active' => 'nullable',
        ]);

        $data = [
            'name' => $request->name,
            'tracking_url' => $request->tracking_url,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('couriers', 'public');
            $data['logo_url'] = '/storage/' . $path;
        }

        $courier->update($data);

        return redirect()->route('couriers.admin')->with('success', 'Courier updated successfully!');
    }

    /**
     * Toggle courier active status.
     */
    public function toggleStatus($id)
    {
        $courier = Courier::findOrFail($id);
        $courier->update(['is_active' => !$courier->is_active]);

        $action = $courier->is_active ? 'activated' : 'deactivated';
        return redirect()->route('couriers.admin')->with('success', "Courier {$action} successfully!");
    }
}
