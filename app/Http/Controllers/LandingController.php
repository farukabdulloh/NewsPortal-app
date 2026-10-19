<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\News;
use App\Models\Author;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(){
        $banners = Banner::with(['news.newsCategory', 'news.author.user'])->get();
        $featureds = News::with(['newsCategory', 'author.user'])->where('is_featured', true)->latest()->take(4)->get();
        $news = News::with(['newsCategory', 'author.user'])->latest()->take(5)->get();
        $authors = Author::with(['user', 'news'])->take(5)->get();

        return view('pages.landing', compact('banners', 'featureds', 'news', 'authors'));
    }
}
