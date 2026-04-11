<?php

namespace App\Http\Controllers;

use App\Models\ProductQuestion;
use Illuminate\Http\Request;

class ProductQAAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductQuestion::with(['product', 'user']);

        $filter = $request->get('filter', 'unanswered');
        if ($filter === 'unanswered') {
            $query->unanswered();
        } elseif ($filter === 'answered') {
            $query->answered();
        }

        $questions = $query->orderByDesc('created_at')->paginate(20)->appends($request->query());

        $stats = [
            'total' => ProductQuestion::count(),
            'unanswered' => ProductQuestion::unanswered()->count(),
            'answered' => ProductQuestion::answered()->count(),
        ];

        return view('qa_admin', compact('questions', 'stats', 'filter'));
    }

    public function answer(Request $request, $id)
    {
        $request->validate([
            'answer_text' => 'required|string|max:2000',
        ]);

        $question = ProductQuestion::findOrFail($id);
        $question->update([
            'answer_text' => $request->answer_text,
        ]);

        return redirect()->route('qa.admin')->with('success', 'Answer posted successfully.');
    }
}
