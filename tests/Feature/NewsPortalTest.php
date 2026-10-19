<?php

use App\Models\Author;
use App\Models\Banner;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'name' => 'Admin Test',
        'email' => 'admin@testportal.com',
        'role' => 'admin',
    ]);

    $this->authorUser = User::factory()->create([
        'name' => 'Author Test',
        'email' => 'author@testportal.com',
        'role' => 'author',
    ]);

    $this->author = Author::create([
        'user_id' => $this->authorUser->id,
        'username' => 'testauthor',
        'avatar' => 'avatars/sample-avatar-1.png',
        'bio' => 'Test Author Biography',
    ]);

    $this->category = NewsCategory::create([
        'title' => 'Teknologi',
        'slug' => 'teknologi',
    ]);

    $this->news = News::create([
        'author_id' => $this->author->id,
        'news_category_id' => $this->category->id,
        'title' => 'Inovasi AI 2026',
        'slug' => 'inovasi-ai-2026',
        'thumbnail' => 'thumbnails/sample-demo.png',
        'content' => '<p>Konten artikel pengujian otomatis.</p>',
        'is_featured' => true,
    ]);

    $this->banner = Banner::create([
        'news_id' => $this->news->id,
    ]);
});

it('loads landing page successfully with branding and dark mode support', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertSee('NewsPortal');
    $response->assertSee('Inovasi AI 2026');
});

it('loads news index and search functionality', function () {
    $response = $this->get('/news');
    $response->assertStatus(200);
    $response->assertSee('Inovasi AI 2026');

    $searchResponse = $this->get('/news?search=Inovasi');
    $searchResponse->assertStatus(200);
    $searchResponse->assertSee('Inovasi AI 2026');
});

it('shows article detail and handles 404 properly', function () {
    $response = $this->get('/news/inovasi-ai-2026');
    $response->assertStatus(200);
    $response->assertSee('Inovasi AI 2026');
    $response->assertSee('Test Author Biography');

    $notFoundResponse = $this->get('/news/slug-yang-tidak-ada');
    $notFoundResponse->assertStatus(404);
});

it('shows category page and handles 404 properly', function () {
    $response = $this->get('/category/teknologi');
    $response->assertStatus(200);
    $response->assertSee('Teknologi');
    $response->assertSee('Inovasi AI 2026');

    $notFoundResponse = $this->get('/category/kategori-palsu');
    $notFoundResponse->assertStatus(404);
});

it('shows author profile and handles 404 properly', function () {
    $response = $this->get('/author/testauthor');
    $response->assertStatus(200);
    $response->assertSee('Author Test');
    $response->assertSee('Test Author Biography');

    $notFoundResponse = $this->get('/author/penulis-palsu');
    $notFoundResponse->assertStatus(404);
});

it('displays filament login page with back button', function () {
    $response = $this->get('/admin/login');
    $response->assertStatus(200);
    $response->assertSee('Kembali ke Website (Back)');
});
