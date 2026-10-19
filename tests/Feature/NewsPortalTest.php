<?php

use App\Filament\Pages\Auth\AdminLogin;
use App\Filament\Pages\Auth\AuthorLogin;
use App\Filament\Pages\Auth\AuthorRegister;
use App\Models\Author;
use App\Models\Banner;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

beforeEach(function () {
    $this->admin = User::updateOrCreate(
        ['email' => 'admin_test@testportal.com'],
        [
            'name' => 'Admin Test',
            'password' => Hash::make('SecretAdmin123!'),
            'role' => 'admin',
        ]
    );

    $this->authorUser = User::updateOrCreate(
        ['email' => 'author_test@testportal.com'],
        [
            'name' => 'Author Test',
            'password' => Hash::make('SecretAuthor123!'),
            'role' => 'author',
        ]
    );

    $this->author = Author::updateOrCreate(
        ['username' => 'testauthor'],
        [
            'user_id' => $this->authorUser->id,
            'avatar' => 'avatars/sample-avatar-1.png',
            'bio' => 'Test Author Biography',
        ]
    );

    $this->category = NewsCategory::firstOrCreate(
        ['slug' => 'teknologi'],
        ['title' => 'Teknologi']
    );

    $this->news = News::firstOrCreate(
        ['slug' => 'inovasi-ai-2026'],
        [
            'author_id' => $this->author->id,
            'news_category_id' => $this->category->id,
            'title' => 'Inovasi AI 2026',
            'thumbnail' => 'thumbnails/sample-demo.png',
            'content' => '<p>Konten artikel pengujian otomatis.</p>',
            'is_featured' => true,
        ]
    );

    $this->banner = Banner::firstOrCreate([
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

it('displays admin login page with back button and admin branding', function () {
    $response = $this->get('/admin/login');
    $response->assertStatus(200);
    $response->assertSee('Kembali ke Website');
    $response->assertSee('Masuk Admin Panel');
});

it('displays author login page with back button and register link', function () {
    $response = $this->get('/author/login');
    $response->assertStatus(200);
    $response->assertSee('Kembali ke Website');
    $response->assertSee('Masuk Panel Penulis');
    $response->assertSee('Belum punya akun?');
});

it('displays author register page with back button', function () {
    $response = $this->get('/author/register');
    $response->assertStatus(200);
    $response->assertSee('Kembali ke Website');
    $response->assertSee('Daftar sebagai Penulis');
});

it('authenticates admin successfully on admin login', function () {
    Livewire::test(AdminLogin::class)
        ->fillForm([
            'email' => 'admin_test@testportal.com',
            'password' => 'SecretAdmin123!',
        ])
        ->call('authenticate')
        ->assertHasNoFormErrors();

    expect(auth()->check())->toBeTrue();
    expect(auth()->user()->role)->toBe('admin');
});

it('rejects author login on admin login page', function () {
    Livewire::test(AdminLogin::class)
        ->fillForm([
            'email' => 'author_test@testportal.com',
            'password' => 'SecretAuthor123!',
        ])
        ->call('authenticate')
        ->assertHasFormErrors(['email']);
});

it('authenticates author successfully on author login', function () {
    Livewire::test(AuthorLogin::class)
        ->fillForm([
            'email' => 'author_test@testportal.com',
            'password' => 'SecretAuthor123!',
        ])
        ->call('authenticate')
        ->assertHasNoFormErrors();

    expect(auth()->check())->toBeTrue();
    expect(auth()->user()->role)->toBe('author');
});

it('rejects admin login on author login page', function () {
    Livewire::test(AuthorLogin::class)
        ->fillForm([
            'email' => 'admin_test@testportal.com',
            'password' => 'SecretAdmin123!',
        ])
        ->call('authenticate')
        ->assertHasFormErrors(['email']);
});

it('registers author with server-side author role and hashes password', function () {
    $randomSuffix = rand(1000, 9999);
    $email = "new_author_{$randomSuffix}@testportal.com";
    $username = "newauthor{$randomSuffix}";
    $avatarFile = \Illuminate\Http\UploadedFile::fake()->image('avatar.jpg');

    Livewire::test(AuthorRegister::class)
        ->fillForm([
            'name' => 'New Contributor',
            'username' => $username,
            'email' => $email,
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
            'avatar' => [$avatarFile],
            'bio' => 'Biografi jurnalis baru untuk penulisan artikel.',
        ])
        ->call('register')
        ->assertHasNoFormErrors();

    $newUser = User::where('email', $email)->first();
    expect($newUser)->not->toBeNull();
    expect($newUser->role)->toBe('author');
    expect(Hash::check('SecurePass123!', $newUser->password))->toBeTrue();

    $newAuthor = Author::where('username', $username)->first();
    expect($newAuthor)->not->toBeNull();
    expect($newAuthor->user_id)->toBe($newUser->id);
});

it('generates working storage URLs and falls back gracefully when file is absent', function () {
    expect($this->news->thumbnail_url)->not->toBeEmpty();
    expect($this->author->avatar_url)->not->toBeEmpty();

    $fakeNews = new News(['thumbnail' => null]);
    expect($fakeNews->thumbnail_url)->toContain('Berita-Liburan.png');

    $fakeAuthor = new Author(['avatar' => null]);
    expect($fakeAuthor->avatar_url)->toContain('profile.png');
});

it('rejects duplicate email and duplicate username on author registration', function () {
    $avatarFile = \Illuminate\Http\UploadedFile::fake()->image('avatar.jpg');

    Livewire::test(AuthorRegister::class)
        ->fillForm([
            'name' => 'Duplicate Test',
            'username' => 'testauthor', // already exists
            'email' => 'author_test@testportal.com', // already exists
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
            'avatar' => [$avatarFile],
            'bio' => 'Biografi duplikat.',
        ])
        ->call('register')
        ->assertHasFormErrors(['email', 'username']);
});

it('prevents author from accessing admin panel', function () {
    $response = $this->actingAs($this->authorUser)->get('/admin');
    expect($response->status())->toBeIn([403, 302]);
});

it('prevents admin from accessing author panel', function () {
    $response = $this->actingAs($this->admin)->get('/author');
    expect($response->status())->toBeIn([403, 302]);
});
