<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\NewsResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(
            Category::query()
                ->withCount('news')
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get()
        );
    }

    public function news(Request $request, Category $category)
    {
        $perPage = min(max((int) $request->integer('per_page', 8), 1), 20);

        return NewsResource::collection(
            $category->news()
                ->with(['category', 'author'])
                ->published()
                ->latest('published_at')
                ->paginate($perPage)
                ->withQueryString()
        );
    }
}

