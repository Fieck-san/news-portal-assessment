<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->integer('per_page', 8), 1), 20);

        $query = News::query()
            ->with(['category', 'author'])
            ->published()
            ->latest('published_at');

        if ($category = $request->query('category')) {
            $query->whereHas('category', fn ($categoryQuery) => $categoryQuery->where('slug', $category));
        }

        if ($request->has('featured')) {
            $query->where('is_featured', $request->boolean('featured'));
        }

        if ($search = trim((string) $request->query('search', ''))) {
            $query->where(function ($searchQuery) use ($search): void {
                $searchQuery
                    ->where('title', 'like', '%'.$search.'%')
                    ->orWhere('summary', 'like', '%'.$search.'%');
            });
        }

        return NewsResource::collection($query->paginate($perPage)->withQueryString());
    }

    public function show(string $news): NewsResource
    {
        $article = News::query()
            ->with(['category', 'author'])
            ->published()
            ->where(fn ($query) => $query->whereKey($news)->orWhere('slug', $news))
            ->firstOrFail();

        return new NewsResource($article);
    }
}
