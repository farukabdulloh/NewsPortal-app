@extends('layout.app')

@section('title', 'Kategori: ' . $category->title)

@section('content')
<div class="space-y-8">

  <!-- Category Banner Header -->
  <div class="rounded-2xl p-8 sm:p-12 bg-white dark:bg-[#141d18] border border-slate-200/80 dark:border-[#223028] text-center shadow-xs">
    <span class="inline-block px-3 py-1 text-xs font-semibold uppercase tracking-wider text-[#3e6657] dark:text-[#88b5a3] bg-[#edf4f0] dark:bg-[#1a2721] rounded-full mb-3 border border-[#d2e3d9] dark:border-[#2b3c34]">
      Kategori
    </span>
    <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">
      {{ $category->title }}
    </h1>
    <p class="text-sm sm:text-base text-slate-500 dark:text-slate-400 max-w-xl mx-auto mt-2">
      Kumpulan artikel, investigasi, dan liputan seputar topik {{ strtolower($category->title) }}.
    </p>
    <div class="mt-3 text-xs font-medium text-[#528270] dark:text-[#88b5a3]">
      <span>Total {{ $category->news->count() }} Artikel Tersedia</span>
    </div>
  </div>

  <!-- Articles in Category -->
  @if ($category->news->isNotEmpty())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach ($category->news as $newsItem)
        <article class="group bg-white dark:bg-[#141d18] border border-slate-200/80 dark:border-[#223028] hover:border-[#528270]/60 dark:hover:border-[#528270]/60 rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition-all duration-300 flex flex-col">
          <a href="{{ route('news.show', $newsItem->slug) }}" class="block relative aspect-[16/10] overflow-hidden bg-slate-100 dark:bg-slate-800">
            <span class="absolute top-3 left-3 z-10 px-3 py-1 rounded-full text-xs font-semibold text-white bg-[#528270]/90 backdrop-blur-xs">
              {{ $category->title }}
            </span>
            <img 
              src="{{ $newsItem->thumbnail_url }}" 
              alt="{{ $newsItem->title }}" 
              class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
              loading="lazy"
            />
          </a>
          <div class="p-5 flex-1 flex flex-col justify-between">
            <div>
              <a href="{{ route('news.show', $newsItem->slug) }}">
                <h3 class="font-bold text-base sm:text-lg text-slate-900 dark:text-white group-hover:text-[#528270] dark:group-hover:text-[#88b5a3] transition-colors line-clamp-2 leading-snug">
                  {{ $newsItem->title }}
                </h3>
              </a>
              <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-2 line-clamp-2">
                {{ Str::limit(strip_tags($newsItem->content), 85) }}
              </p>
            </div>
            <div class="pt-4 mt-4 border-t border-slate-100 dark:border-[#1d2922] flex items-center justify-between text-xs text-slate-400 dark:text-slate-500">
              <span>{{ $newsItem->author?->user?->name ?? 'NewsPortal' }}</span>
              <span>{{ $newsItem->created_at->format('d M Y') }}</span>
            </div>
          </div>
        </article>
      @endforeach
    </div>
  @else
    <!-- Empty Category State -->
    <div class="py-16 text-center bg-white dark:bg-[#141d18] rounded-2xl border border-slate-200/80 dark:border-[#223028] p-8">
      <div class="w-12 h-12 mx-auto rounded-full bg-[#edf4f0] dark:bg-[#1b2621] text-[#528270] flex items-center justify-center mb-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
        </svg>
      </div>
      <h3 class="text-lg font-bold text-slate-900 dark:text-white">Belum Ada Artikel dalam Kategori Ini</h3>
      <p class="text-sm text-slate-500 dark:text-slate-400 max-w-sm mx-auto mt-1">
        Artikel untuk kategori {{ $category->title }} sedang dalam proses penulisan oleh redaksi.
      </p>
      <div class="mt-5">
        <a href="{{ route('landing') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-semibold text-white bg-[#528270] hover:bg-[#416a5a] transition">
          <span>Kembali ke Beranda</span>
        </a>
      </div>
    </div>
  @endif

</div>
@endsection