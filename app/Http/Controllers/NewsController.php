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

    public function show($slug){
        $news = News::where('slug', $slug)->firstOrFail();
        $newest = News::where('id', '!=', $news->id)->orderBy('created_at', 'desc')->take(4)->get();

        return view('pages.news.show', compact('news', 'newest'));
    }

    
    public function category($slug){
        $category = NewsCategory::where('slug', $slug)->firstOrFail();

        return view('pages.news.news', compact('category'));
    }
}
