<?php

use App\Filament\Resources\Authors\Pages\CreateAuthor;
use App\Filament\Resources\News\NewsResource;
use App\Filament\Resources\News\Pages\ListNews;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Models\Author;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);

    $this->authorA = User::factory()->create(['role' => 'author']);
    $this->authorProfileA = Author::create([
        'user_id' => $this->authorA->id,
        'username' => 'penulisa',
        'avatar' => 'avatars/sample-avatar-1.png',
        'bio' => 'Bio lama penulis A.',
    ]);

    $this->authorB = User::factory()->create(['role' => 'author']);
    $this->authorProfileB = Author::create([
        'user_id' => $this->authorB->id,
        'username' => 'penulisb',
    ]);

    $this->newsA = News::create([
        'author_id' => $this->authorProfileA->id,
        'news_category_id' => 1,
        'title' => 'Berita milik Penulis A',
        'slug' => 'berita-penulis-a',
        'thumbnail' => 'thumbnails/sample-liburan.png',
        'content' => '<p>Konten A.</p>',
    ]);

    $this->newsB = News::create([
        'author_id' => $this->authorProfileB->id,
        'news_category_id' => 1,
        'title' => 'Berita milik Penulis B',
        'slug' => 'berita-penulis-b',
        'thumbnail' => 'thumbnails/sample-liburan.png',
        'content' => '<p>Konten B.</p>',
    ]);
});

it('verifies test database is isolated sqlite in memory', function () {
    expect(config('database.default'))->toBe('sqlite')
        ->and(DB::connection()->getDatabaseName())->toBe(':memory:');
});

it('creates exactly one author profile when creating an author user', function () {
    $this->actingAs($this->admin);

    Livewire::test(CreateUser::class)
        ->fillForm([
            'name' => 'Penulis Baru',
            'email' => 'penulisbaru@example.com',
            'role' => 'author',
            'author_username' => 'penulisbaru',
            'password' => 'SecretPass123!',
        ])
        ->call('create')
        ->assertHasNoErrors();

    $user = User::where('email', 'penulisbaru@example.com')->first();

    expect($user)->not->toBeNull()
        ->and($user->role)->toBe('author')
        ->and(Author::where('user_id', $user->id)->count())->toBe(1)
        ->and($user->author->username)->toBe('penulisbaru');
});

it('does not create an author profile when creating an admin user', function () {
    $this->actingAs($this->admin);

    Livewire::test(CreateUser::class)
        ->fillForm([
            'name' => 'Admin Baru',
            'email' => 'adminbaru@example.com',
            'role' => 'admin',
            'password' => 'SecretPass123!',
        ])
        ->call('create')
        ->assertHasNoErrors();

    $user = User::where('email', 'adminbaru@example.com')->first();

    expect($user)->not->toBeNull()
        ->and($user->role)->toBe('admin')
        ->and(Author::where('user_id', $user->id)->count())->toBe(0);
});

it('requires author username when role is author', function () {
    $this->actingAs($this->admin);

    Livewire::test(CreateUser::class)
        ->fillForm([
            'name' => 'Penulis Tanpa Nama',
            'email' => 'tanpanama@example.com',
            'role' => 'author',
            'password' => 'SecretPass123!',
        ])
        ->call('create')
        ->assertHasFormErrors(['author_username']);

    expect(User::where('email', 'tanpanama@example.com')->exists())->toBeFalse();
});

it('creates an author profile when role changes from admin to author', function () {
    $this->actingAs($this->admin);

    Livewire::test(EditUser::class, ['record' => $this->admin->id])
        ->fillForm([
            'role' => 'author',
            'author_username' => 'adminjadipenulis',
        ])
        ->call('save')
        ->assertHasNoErrors();

    expect(Author::where('user_id', $this->admin->id)->count())->toBe(1)
        ->and($this->admin->fresh()->author->username)->toBe('adminjadipenulis');
});

it('updates the author username without creating a duplicate profile', function () {
    $this->actingAs($this->admin);

    Livewire::test(EditUser::class, ['record' => $this->authorA->id])
        ->fillForm([
            'name' => 'Penulis A Baru',
            'author_username' => 'penulisa-baru',
        ])
        ->call('save')
        ->assertHasNoErrors();

    $profile = $this->authorA->fresh()->author;

    expect(Author::where('user_id', $this->authorA->id)->count())->toBe(1)
        ->and($profile->username)->toBe('penulisa-baru')
        ->and($profile->avatar)->toBe('avatars/sample-avatar-1.png')
        ->and($profile->bio)->toBe('Bio lama penulis A.');
});

it('keeps the author profile and news attribution when role changes from author to admin', function () {
    $this->actingAs($this->admin);

    Livewire::test(EditUser::class, ['record' => $this->authorA->id])
        ->fillForm(['role' => 'admin'])
        ->call('save')
        ->assertHasNoErrors();

    expect($this->authorA->fresh()->role)->toBe('admin')
        ->and(Author::where('user_id', $this->authorA->id)->count())->toBe(1)
        ->and($this->newsA->fresh()->author_id)->toBe($this->authorProfileA->id);
});

it('rejects a duplicate author username on user creation', function () {
    $this->actingAs($this->admin);

    Livewire::test(CreateUser::class)
        ->fillForm([
            'name' => 'Penulis Duplikat',
            'email' => 'duplikat@example.com',
            'role' => 'author',
            'author_username' => 'penulisa',
            'password' => 'SecretPass123!',
        ])
        ->call('create')
        ->assertHasFormErrors(['author_username']);

    expect(User::where('email', 'duplikat@example.com')->exists())->toBeFalse();
});

it('allows keeping your own username when editing an author user', function () {
    $this->actingAs($this->admin);

    Livewire::test(EditUser::class, ['record' => $this->authorA->id])
        ->fillForm([
            'name' => 'Penulis A Sama',
            'author_username' => 'penulisa',
        ])
        ->call('save')
        ->assertHasNoErrors();

    expect($this->authorA->fresh()->author->username)->toBe('penulisa');
});

it('prevents two author profiles for one user at database level', function () {
    $this->expectException(QueryException::class);

    Author::create([
        'user_id' => $this->authorA->id,
        'username' => 'penulisa-dupe',
    ]);
});

it('prevents duplicate user id through the author form', function () {
    $this->actingAs($this->admin);

    Livewire::test(CreateAuthor::class)
        ->fillForm([
            'user_id' => $this->authorA->id,
            'username' => 'penulis-unik-lain',
        ])
        ->call('create')
        ->assertHasFormErrors(['user_id']);

    expect(Author::where('username', 'penulis-unik-lain')->exists())->toBeFalse();
});

it('allows authors to be created without avatar and bio', function () {
    expect($this->authorProfileB->avatar)->toBeNull()
        ->and($this->authorProfileB->bio)->toBeNull();
});

it('returns an empty list instead of an exception for an author user without a profile', function () {
    $orphan = User::factory()->create(['role' => 'author']);

    $this->actingAs($orphan);

    $query = NewsResource::getEloquentQuery();

    expect($query->count())->toBe(0);

    Livewire::test(ListNews::class)->assertSuccessful();
});

it('scopes the news query to the signed-in author only', function () {
    $this->actingAs($this->authorA);

    $titles = NewsResource::getEloquentQuery()->pluck('title')->all();

    expect($titles)->toContain('Berita milik Penulis A')
        ->not->toContain('Berita milik Penulis B');
});

it('lets admins see all news in the resource query', function () {
    $this->actingAs($this->admin);

    expect(NewsResource::getEloquentQuery()->count())->toBe(2);
});

it('blocks deleting a user that still has an author profile', function () {
    expect($this->authorA->delete())->toBeFalse()
        ->and(User::whereKey($this->authorA->id)->exists())->toBeTrue()
        ->and($this->newsA->fresh()->author_id)->toBe($this->authorProfileA->id);

    expect($this->admin->delete())->toBeTrue();
});

it('does not create author profiles silently when running resource queries', function () {
    $orphan = User::factory()->create(['role' => 'author']);
    $countBefore = Author::count();

    $this->actingAs($orphan);
    NewsResource::getEloquentQuery()->count();

    expect(Author::count())->toBe($countBefore);
});
