<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // GET /api/articles
    public function index()
    {
        return response()->json(
            Article::latest()->get()
        );
    }

    // POST /api/articles
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'source_url' => 'required|string',
        ]);

        // ❌ Do NOT set slug here
        // ✅ Slug will be auto-generated in the model

        $article = Article::create($data);

        return response()->json($article, 201);
    }

    // GET /api/articles/{id}
    public function show($id)
    {
        return response()->json(
            Article::findOrFail($id)
        );
    }

    // PUT /api/articles/{id}
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|string',
            'content' => 'sometimes|string',
            'source_url' => 'sometimes|string',
        ]);

        // ❌ Do NOT update slug manually
        // If title changes, you may regenerate slug in model if needed

        $article->update($data);

        return response()->json($article);
    }

    // DELETE /api/articles/{id}
    public function destroy($id)
    {
        Article::destroy($id);

        return response()->json([
            'message' => 'Article deleted successfully'
        ]);
    }
}
