@extends('layout.app')

@section('title', 'Profil Penulis: ' . ($author->user?->name ?? $author->username))

@section('content')
<div class="space-y-10">

  <!-- Author Profile Hero Card with Cover Banner -->
  <div class="rounded-2xl bg-white dark:bg-[#141d18] border border-slate-200/80 dark:border-[#223028] shadow-xs overflow-hidden">
    <!-- Cover Banner -->
    <div class="h-44 sm:h-60 md:h-72 w-full relative bg-[#edf4f0] dark:bg-[#1b2621] overflow-hidden">
      <img
        src="{{ $author->cover_url }}"
        alt="Foto Sampul {{ $author->user?->name ?? $author->username }}"
        onerror="this.onerror=null;this.src='{{ asset('assets/img/bg-profile.png') }}';"
        class="w-full h-full object-cover"
      />
      <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>
    </div>

    <!-- Profile Details & Avatar Overlapping Cover -->
    <div class="p-6 sm:p-10 pt-0 sm:pt-0 relative flex flex-col sm:flex-row items-center sm:items-end justify-between gap-6 text-center sm:text-left -mt-14 sm:-mt-16">

      <div class="flex flex-col sm:flex-row items-center sm:items-end gap-6">
        <div class="relative w-28 h-28 sm:w-32 sm:h-32 rounded-full overflow-hidden p-1 bg-white dark:bg-[#141d18] border-4 border-white dark:border-[#141d18] shadow-md shrink-0">
          <img
            src="{{ $author->avatar_url }}"
            alt="{{ $author->user?->name ?? $author->username }}"
            onerror="this.onerror=null;this.src='{{ asset('assets/img/profile.png') }}';"
            class="w-full h-full rounded-full object-cover"
          />
        </div>

        <div class="space-y-1 sm:pb-1">
          <span class="inline-block px-3 py-1 text-xs font-semibold uppercase tracking-wider text-[#3e6657] dark:text-[#88b5a3] bg-[#edf4f0] dark:bg-[#1a2721] rounded-full border border-[#d2e3d9] dark:border-[#2b3c34]">
            Penulis Berita
          </span>
          <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">
            {{ $author->user?->name ?? $author->username }}
          </h1>
          <p class="text-sm font-medium text-[#528270] dark:text-[#88b5a3]">
            {{ '@' . $author->username }}
          </p>
        </div>
      </div>

      @if (auth()->check() && auth()->id() === $author->user_id)
        <div class="sm:pb-1">
          <a href="{{ url('/author/settings') }}"
             class="inline-flex items-center gap-2 px-4 py-2 text-xs sm:text-sm font-semibold text-white bg-[#528270] hover:bg-[#416a5a] rounded-xl shadow-xs transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Pengaturan Profil</span>
          </a>
        </div>
      @endif

    </div>

    <!-- Bio & Stats section -->
    <div class="px-6 sm:px-10 pb-8 space-y-4">
      <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed max-w-3xl">
        {{ $author->bio ?: 'Penulis belum menambahkan biodata.' }}
      </p>

      <div class="pt-2 flex flex-wrap items-center justify-center sm:justify-start gap-4 text-xs font-semibold text-slate-500 dark:text-slate-400">
        <span class="flex items-center gap-1.5 px-3 py-1 rounded-lg bg-slate-100 dark:bg-slate-800">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#528270]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
          </svg>
          {{ $author->news->count() }} Artikel Terbit
        </span>
        <span class="flex items-center gap-1.5 px-3 py-1 rounded-lg bg-slate-100 dark:bg-slate-800">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#528270]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          Bergabung sejak {{ $author->created_at->format('M Y') }}
        </span>
      </div>
    </div>

  </div>

  <!-- Articles Written by Author -->
  <div>
    <div class="mb-6 pb-3 border-b border-slate-200/80 dark:border-[#223028]">
      <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
        Artikel oleh {{ $author->user?->name ?? $author->username }}
      </h2>
    </div>

    @if ($author->news->isNotEmpty())
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ($author->news as $item)
          <article class="group bg-white dark:bg-[#141d18] border border-slate-200/80 dark:border-[#223028] hover:border-[#528270]/60 dark:hover:border-[#528270]/60 rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition-all duration-300 flex flex-col">
            <a href="{{ route('news.show', $item->slug) }}" class="block relative aspect-[16/10] overflow-hidden bg-slate-100 dark:bg-slate-800">
              <span class="absolute top-3 left-3 z-10 px-2.5 py-0.5 rounded-full text-xs font-semibold text-white bg-[#528270]/90 backdrop-blur-xs">
                {{ $item->newsCategory->title ?? 'Berita' }}
              </span>
              <img 
                src="{{ $item->thumbnail_url }}" 
                alt="{{ $item->title }}" 
                onerror="this.onerror=null;this.src='{{ asset('assets/img/Berita-Liburan.png') }}';"
                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                loading="lazy"
              />
            </a>
            <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between">
              <div>
                <a href="{{ route('news.show', $item->slug) }}">
                  <h3 class="font-bold text-base text-slate-900 dark:text-white group-hover:text-[#528270] dark:group-hover:text-[#88b5a3] transition-colors line-clamp-2 leading-snug">
                    {{ $item->title }}
                  </h3>
                </a>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 line-clamp-2">
                  {{ Str::limit(strip_tags($item->content), 80) }}
                </p>
              </div>
              <div class="pt-3 mt-3 border-t border-slate-100 dark:border-[#1d2922] flex items-center justify-between text-xs text-slate-400 dark:text-slate-500">
                <span>{{ $item->created_at->format('d M Y') }}</span>
                <span class="text-[#528270] dark:text-[#88b5a3] font-medium group-hover:underline">Baca &rarr;</span>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    @else
      <div class="py-12 text-center bg-white dark:bg-[#141d18] rounded-2xl border border-slate-200/80 dark:border-[#223028] p-8">
        <p class="text-sm text-slate-500 dark:text-slate-400">Penulis ini belum mempublikasikan artikel.</p>
      </div>
    @endif
  </div>

</div>
@endsection