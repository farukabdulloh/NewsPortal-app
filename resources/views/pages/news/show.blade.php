@extends('layout.app')

@section('title', $news->title)

@section('content')
<div class="space-y-10">

  <!-- Breadcrumb -->
  <nav class="flex items-center gap-2 text-xs sm:text-sm text-slate-500 dark:text-slate-400" aria-label="Breadcrumb">
    <a href="{{ route('landing') }}" class="hover:text-[#528270] dark:hover:text-[#88b5a3] transition-colors">Beranda</a>
    <span>/</span>
    @if ($news->newsCategory)
      <a href="{{ route('news.category', $news->newsCategory->slug) }}" class="hover:text-[#528270] dark:hover:text-[#88b5a3] transition-colors">
        {{ $news->newsCategory->title }}
      </a>
      <span>/</span>
    @endif
    <span class="text-slate-800 dark:text-slate-200 font-medium truncate max-w-xs sm:max-w-md">
      {{ $news->title }}
    </span>
  </nav>

  <!-- Article Header -->
  <header class="space-y-4 max-w-4xl">
    <span class="inline-block px-3 py-1 text-xs font-semibold uppercase tracking-wider text-[#3e6657] dark:text-[#88b5a3] bg-[#edf4f0] dark:bg-[#1a2721] rounded-full border border-[#d2e3d9] dark:border-[#2b3c34]">
      {{ $news->newsCategory->title ?? 'Berita' }}
    </span>

    <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-tight">
      {{ $news->title }}
    </h1>

    <div class="flex flex-wrap items-center gap-4 pt-2 text-xs sm:text-sm text-slate-500 dark:text-slate-400 border-b border-slate-200/80 dark:border-[#223028] pb-4">
      <!-- Author info -->
      <a href="{{ route('author.show', $news->author?->username ?? '#') }}" class="flex items-center gap-2.5 group">
        <img 
          src="{{ $news->author?->avatar_url ?? asset('assets/img/profile.png') }}" 
          alt="{{ $news->author?->user?->name ?? 'Penulis' }}" 
          class="w-9 h-9 rounded-full object-cover border border-[#528270]/40"
        />
        <div>
          <span class="font-semibold text-slate-800 dark:text-slate-200 group-hover:text-[#528270] dark:group-hover:text-[#88b5a3] transition-colors">
            {{ $news->author?->user?->name ?? 'Redaksi' }}
          </span>
          <span class="block text-[11px] text-slate-400">Penulis Kontributor</span>
        </div>
      </a>

      <span>&bull;</span>

      <!-- Date -->
      <div class="flex items-center gap-1.5">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#528270]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span>{{ $news->created_at->format('d F Y, H:i') }} WIB</span>
      </div>

      <span>&bull;</span>

      <!-- Reading time estimate -->
      @php
        $wordCount = str_word_count(strip_tags($news->content));
        $minutes = max(1, ceil($wordCount / 200));
      @endphp
      <div class="flex items-center gap-1.5">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#528270]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ $minutes }} menit membaca</span>
      </div>
    </div>
  </header>

  <!-- Main Content Layout (2 Columns: Article + Sidebar) -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

    <!-- Article Body (8 Cols) -->
    <article class="lg:col-span-8 space-y-6">
      
      <!-- Featured Image -->
      <div class="rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-800 border border-slate-200/80 dark:border-[#223028] shadow-xs">
        <img 
          src="{{ $news->thumbnail_url }}" 
          alt="{{ $news->title }}" 
          class="w-full max-h-[480px] object-cover"
        />
      </div>

      <!-- Rich Content -->
      <div class="text-base sm:text-lg text-slate-700 dark:text-slate-300 leading-relaxed space-y-4 font-normal [&_p]:mb-4 [&_p]:leading-relaxed [&_h2]:text-2xl [&_h2]:font-bold [&_h2]:text-slate-900 [&_h2]:dark:text-white [&_h2]:mt-6 [&_h2]:mb-3 [&_ul]:list-disc [&_ul]:pl-6 [&_ol]:list-decimal [&_ol]:pl-6 [&_blockquote]:border-l-4 [&_blockquote]:border-[#528270] [&_blockquote]:pl-4 [&_blockquote]:italic">
        {!! $news->content !!}
      </div>

      <!-- Author Bio Card (Bottom of article) -->
      @if ($news->author)
        <div class="mt-12 p-6 sm:p-8 rounded-2xl bg-white dark:bg-[#141d18] border border-slate-200/80 dark:border-[#223028] shadow-xs flex flex-col sm:flex-row gap-5 items-center sm:items-start text-center sm:text-left">
          <img 
            src="{{ $news->author->avatar_url }}" 
            alt="{{ $news->author->user?->name ?? $news->author->username }}" 
            class="w-20 h-20 rounded-full object-cover border-2 border-[#528270]/40 shrink-0"
          />
          <div class="flex-1 space-y-2">
            <span class="text-xs uppercase tracking-wider font-semibold text-[#528270] dark:text-[#88b5a3]">Tentang Penulis</span>
            <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white">
              {{ $news->author->user?->name ?? $news->author->username }}
            </h3>
            <p class="text-xs text-[#528270] font-medium">{{ '@' . $news->author->username }}</p>
            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
              {{ $news->author->bio }}
            </p>
            <div class="pt-2">
              <a href="{{ route('author.show', $news->author->username) }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-[#528270] hover:text-[#385c4e] dark:text-[#88b5a3] transition">
                <span>Lihat semua artikel karya {{ $news->author->user?->name ?? $news->author->username }} &rarr;</span>
              </a>
            </div>
          </div>
        </div>
      @endif

    </article>

    <!-- Sidebar: Latest Other News (4 Cols) -->
    <aside class="lg:col-span-4 space-y-6">
      <div class="sticky top-24 bg-white dark:bg-[#141d18] border border-slate-200/80 dark:border-[#223028] rounded-2xl p-5 sm:p-6 shadow-xs space-y-5">
        <div class="border-b border-slate-200/80 dark:border-[#223028] pb-3">
          <span class="text-xs font-semibold uppercase tracking-wider text-[#528270] dark:text-[#88b5a3]">Koleksi Terkait</span>
          <h2 class="text-lg font-bold text-slate-900 dark:text-white mt-0.5">
            Berita Terbaru Lainnya
          </h2>
        </div>

        <div class="space-y-4">
          @forelse ($newest as $new)
            <article class="group">
              <a href="{{ route('news.show', $new->slug) }}" class="flex gap-3 items-center">
                <div class="relative w-20 h-20 rounded-xl overflow-hidden shrink-0 bg-slate-100 dark:bg-slate-800">
                  <img 
                    src="{{ $new->thumbnail_url }}" 
                    alt="{{ $new->title }}" 
                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                    loading="lazy"
                  />
                </div>
                <div class="flex-1 min-w-0">
                  <span class="text-[10px] font-semibold text-[#528270] dark:text-[#88b5a3]">
                    {{ $new->newsCategory->title ?? 'Berita' }}
                  </span>
                  <h3 class="font-bold text-xs sm:text-sm text-slate-900 dark:text-white group-hover:text-[#528270] dark:group-hover:text-[#88b5a3] transition-colors line-clamp-2 leading-snug">
                    {{ $new->title }}
                  </h3>
                  <p class="text-[11px] text-slate-400 mt-1">
                    {{ $new->created_at->format('d M Y') }}
                  </p>
                </div>
              </a>
            </article>
          @empty
            <p class="text-xs text-slate-400">Tidak ada berita terbaru lainnya.</p>
          @endforelse
        </div>

        <div class="pt-4 border-t border-slate-100 dark:border-[#1d2922]">
          <a href="{{ route('news.index') }}" class="block text-center py-2 text-xs font-semibold text-[#528270] hover:text-[#385c4e] dark:text-[#88b5a3] transition">
            Lihat Semua Berita &rarr;
          </a>
        </div>
      </div>
    </aside>

  </div>

</div>
@endsection