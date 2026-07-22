<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $isEnglish = $request->query('lang') === 'en';

        return [
            'id' => $this->id,
            'title' => $isEnglish ? ($this->title_en ?? $this->title) : $this->title,
            'slug' => $this->slug,
            'summary' => $isEnglish ? ($this->summary_en ?? $this->summary) : $this->summary,
            'body' => $isEnglish ? ($this->body_en ?? $this->body) : $this->body,
            'image_url' => $this->image_url,
            'is_featured' => $this->is_featured,
            'published_at' => $this->published_at?->toIso8601String(),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'author' => new AuthorResource($this->whenLoaded('author')),
        ];
    }
}
