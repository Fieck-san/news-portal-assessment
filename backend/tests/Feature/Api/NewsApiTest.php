<?php

namespace Tests\Feature\Api;

use App\Models\Author;
use App\Models\Category;
use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_news_index_returns_paginated_articles_with_relationships(): void
    {
        $category = Category::factory()->create(['name' => 'Terkini', 'slug' => 'terkini']);
        $author = Author::factory()->create(['name' => 'Aina Rahman']);

        News::factory()
            ->count(3)
            ->for($category)
            ->for($author)
            ->create(['published_at' => now()->subHour()]);

        $response = $this->getJson('/api/news?per_page=2');

        $response->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('meta.per_page', 2)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'title',
                    'slug',
                    'summary',
                    'body',
                    'image_url',
                    'is_featured',
                    'published_at',
                    'category' => ['id', 'name', 'slug'],
                    'author' => ['id', 'name', 'title'],
                ]],
                'links',
                'meta',
            ]);
    }

    public function test_news_detail_can_be_loaded_by_id(): void
    {
        $news = News::factory()
            ->for(Category::factory()->create())
            ->for(Author::factory()->create())
            ->create(['title' => 'Hospital awam tambah kaunter saringan']);

        $this->getJson('/api/news/'.$news->id)
            ->assertOk()
            ->assertJsonPath('data.id', $news->id)
            ->assertJsonPath('data.title', 'Hospital awam tambah kaunter saringan');
    }

    public function test_category_news_endpoint_filters_by_category_slug(): void
    {
        $politics = Category::factory()->create(['name' => 'Politik', 'slug' => 'politik']);
        $business = Category::factory()->create(['name' => 'Bisnes', 'slug' => 'bisnes']);

        News::factory()->for($politics)->for(Author::factory()->create())->create([
            'title' => 'Ahli Parlimen gesa reformasi institusi',
            'published_at' => now()->subHour(),
        ]);
        News::factory()->for($business)->for(Author::factory()->create())->create([
            'title' => 'Syarikat teknologi perluas operasi',
            'published_at' => now()->subHour(),
        ]);

        $this->getJson('/api/categories/politik/news')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.category.slug', 'politik')
            ->assertJsonPath('data.0.title', 'Ahli Parlimen gesa reformasi institusi');
    }

    public function test_news_index_can_return_english_article_and_category_content(): void
    {
        $category = Category::factory()->create([
            'name' => 'Politik',
            'name_en' => 'Politics',
            'slug' => 'politik',
        ]);

        News::factory()->for($category)->for(Author::factory()->create())->create([
            'title' => 'Ahli Parlimen gesa reformasi institusi',
            'title_en' => 'MP urges special committee to review institutional reforms',
            'summary' => 'Cadangan itu dibangkitkan selepas beberapa siri perbahasan.',
            'summary_en' => 'The proposal followed several rounds of debate.',
            'body' => 'Versi Bahasa Melayu.',
            'body_en' => 'English version.',
            'published_at' => now()->subHour(),
        ]);

        $this->getJson('/api/news?lang=en')
            ->assertOk()
            ->assertJsonPath('data.0.title', 'MP urges special committee to review institutional reforms')
            ->assertJsonPath('data.0.summary', 'The proposal followed several rounds of debate.')
            ->assertJsonPath('data.0.body', 'English version.')
            ->assertJsonPath('data.0.category.name', 'Politics');
    }

    public function test_news_index_uses_malay_content_by_default(): void
    {
        $category = Category::factory()->create([
            'name' => 'Politik',
            'name_en' => 'Politics',
            'slug' => 'politik',
        ]);

        News::factory()->for($category)->for(Author::factory()->create())->create([
            'title' => 'Ahli Parlimen gesa reformasi institusi',
            'title_en' => 'MP urges special committee to review institutional reforms',
            'summary' => 'Cadangan itu dibangkitkan selepas beberapa siri perbahasan.',
            'summary_en' => 'The proposal followed several rounds of debate.',
            'body' => 'Versi Bahasa Melayu.',
            'body_en' => 'English version.',
            'published_at' => now()->subHour(),
        ]);

        $this->getJson('/api/news')
            ->assertOk()
            ->assertJsonPath('data.0.title', 'Ahli Parlimen gesa reformasi institusi')
            ->assertJsonPath('data.0.summary', 'Cadangan itu dibangkitkan selepas beberapa siri perbahasan.')
            ->assertJsonPath('data.0.body', 'Versi Bahasa Melayu.')
            ->assertJsonPath('data.0.category.name', 'Politik');
    }
}
