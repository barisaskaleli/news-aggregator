<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsFilterRequest;
use App\Models\Article;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getLatestNews(): JsonResponse
    {
        $news = Article::latest()->paginate(10);

        return response()->json([
            'news' => $news,
        ]);
    }

    /**
     * @param NewsFilterRequest $request
     * @return JsonResponse
     */
    public function getNewsByFilter(NewsFilterRequest $request): JsonResponse
    {
        $filters = $request->validated();

        $news = Article::with(['category', 'source'])
            ->join('authors', 'articles.author_id', '=', 'authors.id')
            ->filterByTitle($filters['title'] ?? null)
            ->filterByDate($filters['date'] ?? null)
            ->filterByCategories($filters['categories'] ?? null)
            ->filterBySources($filters['sources'] ?? null)
            ->filterByAuthors($filters['authors'] ?? null)
            ->filterByAuthorName($filters['author'] ?? null)
            ->paginate(20);

        return response()->json(['news' => $news]);
    }
}
