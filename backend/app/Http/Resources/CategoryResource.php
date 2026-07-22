<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $isEnglish = $request->query('lang') === 'en';

        return [
            'id' => $this->id,
            'name' => $isEnglish ? ($this->name_en ?? $this->name) : $this->name,
            'slug' => $this->slug,
            'sort_order' => $this->sort_order,
            'news_count' => $this->whenCounted('news'),
        ];
    }
}
