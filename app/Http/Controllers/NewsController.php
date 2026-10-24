<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\NewsCategory;

class NewsController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $news = News::query()
            ->when($search, function ($query, $search) {
                return $query
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(3)
            ->withQueryString();
    
        return view('pages.news.index', compact('news', 'search'));
    }

    public function show(Request $request, $slug){
        $news = News::where('slug', $slug)->firstOrFail();

        // Hitung setiap pembukaan halaman detail yang valid (termasuk
        // pembukaan ulang) dengan operasi increment atomik di database.
        // Kolom ini sengaja tidak masuk $fillable sehingga tidak bisa
        // diubah lewat form maupun mass assignment.
        if (! $this->isBotRequest($request)) {
            News::whereKey($news->id)->increment('view_count');
        }

        $newest = News::where('id', '!=', $news->id)->orderBy('created_at', 'desc')->take(4)->get();

        return view('pages.news.show', compact('news', 'newest'));
    }

    private function isBotRequest(Request $request): bool
    {
        $userAgent = (string) $request->userAgent();

        if ($userAgent === '') {
            return true;
        }

        return (bool) preg_match(
            '/bot|crawl|spider|slurp|preview|curl|wget|python|guzzle|facebookexternalhit|lighthouse|pingdom|uptime/i',
            $userAgent
        );
    }

    
    public function category($slug){
        $category = NewsCategory::where('slug', $slug)->firstOrFail();

        return view('pages.news.news', compact('category'));
    }
}
