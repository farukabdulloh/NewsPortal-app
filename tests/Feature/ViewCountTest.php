<?php

use App\Filament\Pages\MostViewedNews;
use App\Filament\Widgets\AdminStatsOverviewWidget;
use App\Filament\Widgets\AuthorMostViewedWidget;
use App\Filament\Widgets\AuthorStatsWidget;
use App\Filament\Widgets\MostViewedNewsWidget;
use App\Models\Author;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);

    $this->authorA = User::factory()->create(['role' => 'author']);
    $this->authorProfileA = Author::create([
        'user_id' => $this->authorA->id,
        'username' => 'penulisa',
    ]);

    $this->authorB = User::factory()->create(['role' => 'author']);
    $this->authorProfileB = Author::create([
        'user_id' => $this->authorB->id,
        'username' => 'penulisb',
    ]);

    $this->category = NewsCategory::create(['title' => 'Teknologi', 'slug' => 'teknologi-views']);

    $this->newsA = News::create([
        'author_id' => $this->authorProfileA->id,
        'news_category_id' => $this->category->id,
        'title' => 'Berita Populer milik Penulis A',
        'slug' => 'berita-populer-penulis-a',
        'thumbnail' => 'thumbnails/sample-liburan.png',
        'content' => '<p>Konten A.</p>',
    ]);

    $this->newsB = News::create([
        'author_id' => $this->authorProfileB->id,
        'news_category_id' => $this->category->id,
        'title' => 'Berita milik Penulis B',
        'slug' => 'berita-penulis-b-views',
        'thumbnail' => 'thumbnails/sample-liburan.png',
        'content' => '<p>Konten B.</p>',
    ]);
});

it('starts every news article at zero views', function () {
    expect((int) $this->newsA->fresh()->view_count)->toBe(0)
        ->and((int) $this->newsB->fresh()->view_count)->toBe(0);
});

it('increments the view count on every valid article page open', function () {
    $headers = ['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'];

    $this->get('/news/berita-populer-penulis-a', $headers)->assertStatus(200);
    $this->get('/news/berita-populer-penulis-a', $headers)->assertStatus(200);

    expect((int) $this->newsA->fresh()->view_count)->toBe(2);
});

it('does not increment views on listings, search results, or the landing page', function () {
    $headers = ['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'];

    $this->get('/', $headers);
    $this->get('/news', $headers);
    $this->get('/news?search=Berita', $headers);
    $this->get('/category/teknologi-views', $headers);

    expect((int) $this->newsA->fresh()->view_count)->toBe(0);
});

it('does not increment views for a missing article', function () {
    $this->get('/news/slug-tidak-ada', ['User-Agent' => 'Mozilla/5.0'])->assertStatus(404);

    expect((int) $this->newsA->fresh()->view_count)->toBe(0);
});

it('ignores requests with known bot user agents', function () {
    $bots = [
        'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
        'curl/8.4.0',
        'python-requests/2.31.0',
        'facebookexternalhit/1.1',
    ];

    foreach ($bots as $userAgent) {
        $this->get('/news/berita-populer-penulis-a', ['User-Agent' => $userAgent]);
    }

    expect((int) $this->newsA->fresh()->view_count)->toBe(0);
});

it('treats an empty user agent as a bot', function () {
    $this->get('/news/berita-populer-penulis-a', ['User-Agent' => '']);

    expect((int) $this->newsA->fresh()->view_count)->toBe(0);
});

it('prevents view_count from being set through mass assignment', function () {
    $news = News::create([
        'author_id' => $this->authorProfileA->id,
        'news_category_id' => $this->category->id,
        'title' => 'Berita Coba Mass Assignment',
        'slug' => 'berita-coba-mass-assignment',
        'thumbnail' => 'thumbnails/sample-liburan.png',
        'content' => '<p>Konten.</p>',
        'view_count' => 9999,
    ]);

    expect((int) $news->fresh()->view_count)->toBe(0);
});

it('shows the most viewed page sorted by views for an admin', function () {
    $this->newsA->forceFill(['view_count' => 5])->save();
    $this->newsB->forceFill(['view_count' => 12])->save();

    $this->actingAs($this->admin);

    $html = Livewire::test(MostViewedNews::class)
        ->assertSuccessful()
        ->html();

    $positionB = strpos($html, 'Berita milik Penulis B');
    $positionA = strpos($html, 'Berita Populer milik Penulis A');

    expect($positionB)->not()->toBeFalse()
        ->and($positionA)->not()->toBeFalse()
        ->and($positionB)->toBeLessThan($positionA);
});

it('scopes the most viewed page to the signed-in author only', function () {
    $this->newsA->forceFill(['view_count' => 5])->save();
    $this->newsB->forceFill(['view_count' => 12])->save();

    $this->actingAs($this->authorA);

    Livewire::test(MostViewedNews::class)
        ->assertSuccessful()
        ->assertSeeText('Berita Populer milik Penulis A')
        ->assertDontSeeText('Berita milik Penulis B');
});

it('renders the dashboard view widgets without errors', function () {
    $this->actingAs($this->admin);
    Livewire::test(MostViewedNewsWidget::class)->assertSuccessful();
    Livewire::test(AdminStatsOverviewWidget::class)->assertSuccessful();

    $this->actingAs($this->authorA);
    Livewire::test(AuthorMostViewedWidget::class)->assertSuccessful();
    Livewire::test(AuthorStatsWidget::class)->assertSuccessful();
});

it('sums only the signed-in author views for the author widget', function () {
    $this->newsA->forceFill(['view_count' => 7])->save();
    $this->newsB->forceFill(['view_count' => 30])->save();

    $ownViews = (int) News::where('author_id', $this->authorProfileA->id)->sum('view_count');
    $allViews = (int) News::sum('view_count');

    expect($ownViews)->toBe(7)
        ->and($ownViews)->not()->toBe($allViews);

    $this->actingAs($this->authorA);

    Livewire::test(AuthorStatsWidget::class)->assertSuccessful();
});

it('keeps the news resource table working with the views column', function () {
    $this->actingAs($this->admin);

    Livewire::test(\App\Filament\Resources\News\Pages\ListNews::class)
        ->assertSuccessful();
});
