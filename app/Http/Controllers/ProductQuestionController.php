<?php

namespace App\Http\Controllers;

use App\Models\ProductQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductQuestionController extends Controller
{
    /**
     * Customer submits a question on a product.
     */
    public function store(Request $request, $productId)
    {
        $request->validate([
            'question_text' => 'required|string|max:1000',
        ]);

        ProductQuestion::create([
            'product_id' => $productId,
            'user_id' => Auth::id(),
            'product_id_field' => (string) $productId,
            'question_text' => $request->question_text,
            'is_active' => true,
        ]);

        return back()->with('success', 'Your question has been submitted! We\'ll answer it soon.');
    }
}
