<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class AnimalTypeController extends Controller
{
    /**
     * List all animal types (JSON).
     */
    public function index()
    {
        $types = DB::table('animal_types')->orderBy('id')->get();

        // Attach usage count for each type
        $types->transform(function ($t) {
            $t->product_count = Product::where('animal_type', $t->animal_type)
                ->orWhere('animal_type_id', $t->id)
                ->count();
            $t->name = $t->animal_type;
            return $t;
        });

        return response()->json($types);
    }

    /**
     * Store a new animal type (JSON).
     */
    public function store(Request $request)
    {
        $name = trim($request->input('name', ''));

        if ($name === '') {
            return response()->json(['error' => 'Animal type name is required.'], 422);
        }

        // Case-insensitive duplicate check
        $exists = DB::table('animal_types')
            ->whereRaw('LOWER(animal_type) = ?', [strtolower($name)])
            ->exists();

        if ($exists) {
            return response()->json(['error' => 'This animal type already exists!'], 409);
        }

        $id = DB::table('animal_types')->insertGetId([
            'animal_type' => $name,
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'id' => $id,
            'name' => $name,
            'status' => 'Active',
            'product_count' => 0,
            'message' => 'Animal type added successfully.',
        ]);
    }

    /**
     * Update an animal type (JSON).
     */
    public function update(Request $request, $id)
    {
        $name = trim($request->input('name', ''));

        if ($name === '') {
            return response()->json(['error' => 'Animal type name is required.'], 422);
        }

        $type = DB::table('animal_types')->where('id', $id)->first();
        if (!$type) {
            return response()->json(['error' => 'Animal type not found.'], 404);
        }

        $exists = DB::table('animal_types')
            ->whereRaw('LOWER(animal_type) = ?', [strtolower($name)])
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return response()->json(['error' => 'This animal type already exists!'], 409);
        }

        DB::table('animal_types')->where('id', $id)->update([
            'animal_type' => $name,
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Animal type updated successfully.', 'name' => $name]);
    }

    /**
     * Delete an animal type permanently (JSON).
     */
    public function destroy($id)
    {
        $type = DB::table('animal_types')->where('id', $id)->first();
        if (!$type) {
            return response()->json(['error' => 'Animal type not found.'], 404);
        }

        $usedCount = Product::where('animal_type', $type->animal_type)
            ->orWhere('animal_type_id', $type->id)
            ->count();

        if ($usedCount > 0) {
            return response()->json([
                'error' => 'This animal type is currently used by existing products. You can Draft it instead.',
                'used_count' => $usedCount,
            ], 409);
        }

        DB::table('animal_types')->where('id', $id)->delete();

        return response()->json(['message' => 'Animal type deleted successfully.']);
    }

    /**
     * Toggle status (Active / Inactive) for draft/restore (JSON).
     */
    public function toggleStatus($id)
    {
        $type = DB::table('animal_types')->where('id', $id)->first();
        if (!$type) {
            return response()->json(['error' => 'Animal type not found.'], 404);
        }

        $newStatus = ($type->status === 'Active') ? 'Inactive' : 'Active';

        DB::table('animal_types')->where('id', $id)->update([
            'status' => $newStatus,
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => $newStatus === 'Active' ? 'Animal type restored.' : 'Animal type drafted.',
            'status' => $newStatus,
        ]);
    }
}
