@extends('layout.app')

@section('title', isset($search) && $search ? 'Pencarian: ' . $search : 'Semua Berita')

@section('content')
<div class="space-y-8">

  <!-- Header Banner -->
  <div class="rounded-2xl p-8 sm:p-12 bg-white dark:bg-[#141d18] border border-slate-200/80 dark:border-[#223028] text-center shadow-xs">
    <span class="inline-block px-3 py-1 text-xs font-semibold uppercase tracking-wider text-[#528270] dark:text-[#88b5a3] bg-[#edf4f0] dark:bg-[#1b2721] rounded-full mb-3">
      Arsip Redaksi
    </span>
    <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">
      @if (isset($search) && $search)
        Hasil Pencarian: <span class="text-[#528270]">&ldquo;{{ $search }}&rdquo;</span>
      @else
        Jelajahi Semua Berita
      @endif
    </h1>
    <p class="text-sm sm:text-base text-slate-500 dark:text-slate-400 max-w-2xl mx-auto mt-3">
      Temukan artikel mendalam, investigasi, ulasan gaya hidup, otomotif, teknologi terkini, dan berita terpopuler lainnya.
    </p>

    @if (isset($search) && $search)
      <div class="mt-4">
        <a href="{{ route('news.index') }}" class="inline-flex items-center gap-1.5 px-4 py-1.5 text-xs font-medium text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 rounded-full hover:bg-slate-200 dark:hover:bg-slate-700 transition">
          <span>&times; Reset Filter Pencarian</span>
        </a>
      </div>
    @endif
  </div>

  <!-- Articles Grid -->
  @if ($news->isNotEmpty())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($news as $item)
        <article class="group bg-white dark:bg-[#141d18] border border-slate-200/80 dark:border-[#223028] hover:border-[#528270]/60 dark:hover:border-[#528270]/60 rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition-all duration-300 flex flex-col">
          <a href="{{ route('news.show', $item->slug) }}" class="block relative aspect-[16/10] overflow-hidden bg-slate-100 dark:bg-slate-800">
            <span class="absolute top-3 left-3 z-10 px-3 py-1 rounded-full text-xs font-semibold text-white bg-[#528270]/90 backdrop-blur-xs shadow-xs">
              {{ $item->newsCategory->title ?? 'Berita' }}
            </span>
            <img 
              src="{{ $item->thumbnail_url }}" 
              alt="{{ $item->title }}" 
              class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
              loading="lazy"
            />
          </a>
          <div class="p-5 flex-1 flex flex-col justify-between">
            <div>
              <a href="{{ route('news.show', $item->slug) }}">
                <h2 class="font-bold text-lg text-slate-900 dark:text-white group-hover:text-[#528270] dark:group-hover:text-[#88b5a3] transition-colors line-clamp-2 leading-snug">
                  {{ $item->title }}
                </h2>
              </a>
              <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-2.5 line-clamp-3 leading-relaxed">
                {{ Str::limit(strip_tags($item->content), 120) }}
              </p>
            </div>
            <div class="pt-4 mt-4 border-t border-slate-100 dark:border-[#1d2922] flex items-center justify-between text-xs text-slate-400 dark:text-slate-500">
              <span class="font-medium text-slate-600 dark:text-slate-400">{{ $item->author?->user?->name ?? 'NewsPortal' }}</span>
              <span>{{ $item->created_at->format('d M Y') }}</span>
            </div>
          </div>
        </article>
      @endforeach
    </div>

    <!-- Pagination -->
    <div class="pt-6">
      {{ $news->links('pages.vendor.pagination.custome') }}
    </div>
  @else
    <!-- Empty Search State -->
    <div class="py-16 text-center bg-white dark:bg-[#141d18] rounded-2xl border border-slate-200/80 dark:border-[#223028] p-8">
      <div class="w-14 h-14 mx-auto rounded-full bg-[#edf4f0] dark:bg-[#1b2621] text-[#528270] flex items-center justify-center mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>
      <h3 class="text-xl font-bold text-slate-900 dark:text-white">Tidak Ada Berita Ditemukan</h3>
      <p class="text-sm text-slate-500 dark:text-slate-400 max-w-md mx-auto mt-2">
        Kami tidak menemukan artikel yang cocok dengan kata kunci &ldquo;{{ $search ?? '' }}&rdquo;. Coba gunakan kata kunci umum lainnya atau lihat beranda.
      </p>
      <div class="mt-6">
        <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold text-white bg-[#528270] hover:bg-[#416a5a] transition shadow-xs">
          <span>Lihat Semua Berita</span>
        </a>
      </div>
    </div>
  @endif

</div>
@endsection