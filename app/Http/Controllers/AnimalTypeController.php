<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnimalType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class AnimalTypeController extends Controller
{
    /**
     * List all animal types (JSON).
     */
    public function index()
    {
        $types = AnimalType::query()->orderBy('sort_order')->orderBy('id')->get();

        $types->transform(function ($t) {
            $t->product_count = Product::where('animal_type', $t->animal_type)->count();
            $t->name = $t->animal_type;
            $t->image_full_url = $t->image_full_url;
            $t->life_stages = $t->life_stages ? json_decode($t->life_stages, true) : [];
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

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $imageUrl = $request->file('image')->store('animal_types', 'public');
        }

        $lifeStages = $request->input('life_stages', []);
        $lifeStagesJson = is_array($lifeStages) ? json_encode(array_values(array_filter($lifeStages))) : null;

        $id = DB::table('animal_types')->insertGetId([
            'animal_type' => $name,
            'status' => 'Active',
            'image_url' => $imageUrl,
            'description' => $request->input('description', ''),
            'sort_order' => (int) $request->input('sort_order', 0),
            'life_stages' => $lifeStagesJson,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'id' => $id,
            'name' => $name,
            'status' => 'Active',
            'product_count' => 0,
            'image_url' => $imageUrl,
            'image_full_url' => $this->buildImageUrl($imageUrl),
            'description' => $request->input('description', ''),
            'sort_order' => (int) $request->input('sort_order', 0),
            'life_stages' => $lifeStagesJson ? json_decode($lifeStagesJson, true) : [],
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

        $lifeStages = $request->input('life_stages', []);
        $lifeStagesJson = is_array($lifeStages) ? json_encode(array_values(array_filter($lifeStages))) : null;

        $updateData = [
            'animal_type' => $name,
            'description' => $request->input('description', ''),
            'sort_order' => (int) $request->input('sort_order', 0),
            'life_stages' => $lifeStagesJson,
            'updated_at' => now(),
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($type->image_url && Storage::disk('public')->exists($type->image_url)) {
                Storage::disk('public')->delete($type->image_url);
            }
            $updateData['image_url'] = $request->file('image')->store('animal_types', 'public');
        }

        DB::table('animal_types')->where('id', $id)->update($updateData);

        $imageUrl = $updateData['image_url'] ?? $type->image_url;

        return response()->json([
            'message' => 'Animal type updated successfully.',
            'name' => $name,
            'image_url' => $imageUrl,
            'image_full_url' => $this->buildImageUrl($imageUrl),
            'description' => $request->input('description', ''),
            'sort_order' => (int) $request->input('sort_order', 0),
            'life_stages' => $lifeStagesJson ? json_decode($lifeStagesJson, true) : [],
        ]);
    }

    protected function buildImageUrl(?string $path): string
    {
        if (empty($path)) {
            return asset('images/placeholder.png');
        }

        $path = str_replace('\\', '/', trim($path));

        if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0) {
            return $path;
        }

        $path = ltrim($path, '/');
        if (strpos($path, 'storage/') === 0) {
            $path = substr($path, strlen('storage/'));
        } elseif (strpos($path, 'public/') === 0) {
            $path = substr($path, strlen('public/'));
        }

        return asset('storage/' . ltrim($path, '/'));
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

        $usedCount = Product::where('animal_type', $type->animal_type)->count();

        if ($usedCount > 0) {
            return response()->json([
                'error' => 'This animal type is currently used by existing products. You can Draft it instead.',
                'used_count' => $usedCount,
            ], 409);
        }

        // Delete image
        if ($type->image_url && Storage::disk('public')->exists($type->image_url)) {
            Storage::disk('public')->delete($type->image_url);
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
