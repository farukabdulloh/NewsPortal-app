<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AuthorSettingsAndLogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_logout_and_is_redirected_to_admin_login(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);
        $this->assertAuthenticated();

        $response = $this->post(route('filament.admin.auth.logout'));

        $response->assertRedirect(url('/admin/login'));
        $this->assertGuest();
    }

    public function test_author_can_logout_and_is_redirected_to_author_login(): void
    {
        $authorUser = User::create([
            'name' => 'Author User',
            'email' => 'author@example.com',
            'password' => Hash::make('password123'),
            'role' => 'author',
        ]);

        Author::create([
            'user_id' => $authorUser->id,
            'username' => 'authoruser',
            'bio' => 'Original bio',
        ]);

        $this->actingAs($authorUser);
        $this->assertAuthenticated();

        $response = $this->post(route('filament.author.auth.logout'));

        $response->assertRedirect(url('/author/login'));
        $this->assertGuest();
    }

    public function test_authenticated_panel_responses_include_no_cache_headers(): void
    {
        $authorUser = User::create([
            'name' => 'Author User',
            'email' => 'author2@example.com',
            'password' => Hash::make('password123'),
            'role' => 'author',
        ]);

        Author::create([
            'user_id' => $authorUser->id,
            'username' => 'authoruser2',
            'bio' => 'Bio',
        ]);

        $this->actingAs($authorUser);

        $response = $this->get('/author');

        $response->assertHeader('Cache-Control');
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
    }

    public function test_author_can_access_author_settings_page(): void
    {
        $authorUser = User::create([
            'name' => 'Author User',
            'email' => 'author3@example.com',
            'password' => Hash::make('password123'),
            'role' => 'author',
        ]);

        Author::create([
            'user_id' => $authorUser->id,
            'username' => 'authoruser3',
            'bio' => 'Bio',
        ]);

        $this->actingAs($authorUser);

        $response = $this->get('/author/settings');
        $response->assertSuccessful();
        $response->assertSee('Author Settings');
    }

    public function test_admin_cannot_access_author_settings_page(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $response = $this->get('/author/settings');
        $this->assertTrue(in_array($response->status(), [403, 302]));
    }

    public function test_author_profile_page_displays_cover_banner_with_fallback(): void
    {
        $authorUser = User::create([
            'name' => 'Author User',
            'email' => 'author4@example.com',
            'password' => Hash::make('password123'),
            'role' => 'author',
        ]);

        $author = Author::create([
            'user_id' => $authorUser->id,
            'username' => 'authoruser4',
            'bio' => 'Profil jurnalis investigatif.',
        ]);

        $response = $this->get(route('author.show', 'authoruser4'));
        $response->assertSuccessful();
        $response->assertSee('bg-profile.png');
        $response->assertSee('Profil jurnalis investigatif.');
    }

    public function test_author_settings_form_updates_profile_and_hashes_new_password(): void
    {
        Storage::fake('public');

        $authorUser = User::create([
            'name' => 'Old Name',
            'email' => 'author5@example.com',
            'password' => Hash::make('oldpassword123'),
            'role' => 'author',
        ]);

        $author = Author::create([
            'user_id' => $authorUser->id,
            'username' => 'authoruser5',
            'bio' => 'Old bio',
        ]);

        $this->actingAs($authorUser);

        Livewire::test(\App\Filament\Pages\AuthorSettings::class)
            ->set('data.name', 'New Author Name')
            ->set('data.bio', 'Updated bio info')
            ->set('data.currentPassword', 'oldpassword123')
            ->set('data.password', 'newsecretpassword123')
            ->set('data.passwordConfirmation', 'newsecretpassword123')
            ->call('save')
            ->assertHasNoErrors();

        $authorUser->refresh();
        $author->refresh();

        $this->assertEquals('New Author Name', $authorUser->name);
        $this->assertEquals('Updated bio info', $author->bio);
        $this->assertTrue(Hash::check('newsecretpassword123', $authorUser->password));
        $this->assertFalse(Hash::check('oldpassword123', $authorUser->password));
    }
}
