@extends('layout.app')

@section('title', 'Beranda')

@section('content')
<div class="space-y-14 sm:space-y-16">

  <!-- Hero Swiper Banners -->
  @if ($banners->isNotEmpty())
    <section class="relative">
      <div class="swiper mySwiper rounded-2xl overflow-hidden shadow-sm">
        <div class="swiper-wrapper">
          @foreach ($banners as $banner)
            @if ($banner->news)
              <div class="swiper-slide">
                <a href="{{ route('news.show', $banner->news->slug) }}" class="block group relative">
                  <div class="relative h-72 sm:h-96 md:h-[420px] w-full rounded-2xl overflow-hidden bg-slate-900">
                    <img 
                      src="{{ $banner->news->thumbnail_url }}" 
                      alt="{{ $banner->news->title }}" 
                      class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                      loading="lazy"
                    />
                    <!-- Soft dark gradient overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-transparent"></div>

                    <!-- Banner Content -->
                    <div class="absolute bottom-0 inset-x-0 p-5 sm:p-8 flex flex-col items-start gap-2.5 z-10">
                      <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold tracking-wide text-white bg-[#528270] shadow-xs">
                        {{ $banner->news->newsCategory->title ?? 'Berita' }}
                      </span>
                      <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-white leading-snug max-w-3xl group-hover:text-[#a8c7ba] transition-colors line-clamp-2">
                        {{ $banner->news->title }}
                      </h2>
                      <div class="flex items-center gap-2.5 pt-1 text-xs sm:text-sm text-slate-300">
                        <img 
                          src="{{ $banner->news->author?->avatar_url ?? asset('assets/img/profile.png') }}" 
                          alt="{{ $banner->news->author?->user?->name ?? 'Penulis' }}" 
                          class="w-6 h-6 rounded-full object-cover border border-white/40"
                        />
                        <span class="font-medium text-white">{{ $banner->news->author?->user?->name ?? 'NewsPortal Editor' }}</span>
                        <span>&bull;</span>
                        <span>{{ $banner->news->created_at->format('d M Y') }}</span>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            @endif
          @endforeach
        </div>
        <!-- Carousel Pagination & Navigation -->
        <div class="swiper-pagination"></div>
      </div>
    </section>
  @endif

  <!-- Berita Unggulan (Featured News) -->
  @if ($featureds->isNotEmpty())
    <section>
      <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-6 pb-3 border-b border-slate-200/80 dark:border-[#223028]">
        <div>
          <span class="text-xs font-semibold uppercase tracking-wider text-[#528270] dark:text-[#88b5a3]">Pilihan Editor</span>
          <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white mt-0.5">
            Berita Unggulan Untuk Kamu
          </h2>
        </div>
        <a href="{{ route('news.index') }}" 
           class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-[#528270] hover:text-[#385c4e] dark:text-[#88b5a3] dark:hover:text-[#a6cdbe] transition-colors self-start sm:self-auto">
          <span>Lihat Semua Berita</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </a>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach ($featureds as $featured)
          <article class="group bg-white dark:bg-[#141d18] border border-slate-200/80 dark:border-[#223028] hover:border-[#528270]/60 dark:hover:border-[#528270]/60 rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition-all duration-300 flex flex-col">
            <a href="{{ route('news.show', $featured->slug) }}" class="block relative aspect-[16/10] overflow-hidden bg-slate-100 dark:bg-slate-800">
              <span class="absolute top-3 left-3 z-10 px-2.5 py-1 rounded-full text-xs font-semibold text-white bg-[#528270]/90 backdrop-blur-xs shadow-xs">
                {{ $featured->newsCategory->title ?? 'Umum' }}
              </span>
              <img 
                src="{{ $featured->thumbnail_url }}" 
                alt="{{ $featured->title }}" 
                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                loading="lazy"
              />
            </a>
            <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between">
              <div>
                <a href="{{ route('news.show', $featured->slug) }}">
                  <h3 class="font-bold text-base sm:text-lg text-slate-900 dark:text-white group-hover:text-[#528270] dark:group-hover:text-[#88b5a3] transition-colors line-clamp-2 leading-snug">
                    {{ $featured->title }}
                  </h3>
                </a>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-2 line-clamp-2">
                  {{ Str::limit(strip_tags($featured->content), 85) }}
                </p>
              </div>
              <div class="pt-4 mt-4 border-t border-slate-100 dark:border-[#1d2922] flex items-center justify-between text-xs text-slate-400 dark:text-slate-500">
                <span>{{ $featured->author?->user?->name ?? 'NewsPortal' }}</span>
                <span>{{ $featured->created_at->format('d M Y') }}</span>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </section>
  @endif

  <!-- Berita Terbaru (Latest News) -->
  @if ($news->isNotEmpty())
    <section>
      <div class="flex items-center justify-between mb-6 pb-3 border-b border-slate-200/80 dark:border-[#223028]">
        <div>
          <span class="text-xs font-semibold uppercase tracking-wider text-[#528270] dark:text-[#88b5a3]">Liputan Terkini</span>
          <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white mt-0.5">
            Berita Terbaru
          </h2>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Headline / Top Article (Left 7 Cols) -->
        <article class="lg:col-span-7 bg-white dark:bg-[#141d18] border border-slate-200/80 dark:border-[#223028] hover:border-[#528270]/60 dark:hover:border-[#528270]/60 rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition-all duration-300 flex flex-col group">
          <a href="{{ route('news.show', $news[0]->slug) }}" class="block relative aspect-video sm:aspect-[16/10] overflow-hidden bg-slate-100 dark:bg-slate-800">
            <span class="absolute top-4 left-4 z-10 px-3 py-1 rounded-full text-xs font-semibold text-white bg-[#528270]/90 backdrop-blur-xs">
              {{ $news[0]->newsCategory->title ?? 'Berita' }}
            </span>
            <img 
              src="{{ $news[0]->thumbnail_url }}" 
              alt="{{ $news[0]->title }}" 
              class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
            />
          </a>
          <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between">
            <div>
              <a href="{{ route('news.show', $news[0]->slug) }}">
                <h3 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white group-hover:text-[#528270] dark:group-hover:text-[#88b5a3] transition-colors leading-snug">
                  {{ $news[0]->title }}
                </h3>
              </a>
              <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 mt-2.5 leading-relaxed line-clamp-3">
                {{ Str::limit(strip_tags($news[0]->content), 180) }}
              </p>
            </div>
            <div class="pt-4 mt-4 border-t border-slate-100 dark:border-[#1d2922] flex items-center justify-between text-xs sm:text-sm text-slate-500 dark:text-slate-400">
              <span class="font-medium text-slate-700 dark:text-slate-300">{{ $news[0]->author?->user?->name ?? 'Redaksi' }}</span>
              <span>{{ $news[0]->created_at->format('d F Y') }}</span>
            </div>
          </div>
        </article>

        <!-- Side Stack of Next News (Right 5 Cols) -->
        <div class="lg:col-span-5 flex flex-col gap-4">
          @foreach ($news->skip(1)->take(4) as $item)
            <article class="group bg-white dark:bg-[#141d18] border border-slate-200/80 dark:border-[#223028] hover:border-[#528270]/60 dark:hover:border-[#528270]/60 rounded-2xl p-3 sm:p-4 shadow-xs hover:shadow-md transition-all duration-300">
              <a href="{{ route('news.show', $item->slug) }}" class="flex gap-3 sm:gap-4 items-center">
                <div class="relative w-28 sm:w-36 aspect-[4/3] rounded-xl overflow-hidden shrink-0 bg-slate-100 dark:bg-slate-800">
                  <img 
                    src="{{ $item->thumbnail_url }}" 
                    alt="{{ $item->title }}" 
                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                    loading="lazy"
                  />
                  <span class="absolute bottom-1.5 left-1.5 px-2 py-0.5 text-[10px] font-semibold text-white bg-[#528270]/90 rounded-md">
                    {{ $item->newsCategory->title ?? 'Info' }}
                  </span>
                </div>
                <div class="flex-1 min-w-0">
                  <h4 class="font-semibold text-sm sm:text-base text-slate-900 dark:text-white group-hover:text-[#528270] dark:group-hover:text-[#88b5a3] transition-colors line-clamp-2 leading-snug">
                    {{ $item->title }}
                  </h4>
                  <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-1">
                    {{ Str::limit(strip_tags($item->content), 70) }}
                  </p>
                  <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-2">
                    {{ $item->created_at->format('d M Y') }}
                  </p>
                </div>
              </a>
            </article>
          @endforeach
        </div>

      </div>
    </section>
  @else
    <!-- Empty State for News -->
    <section class="py-12 text-center bg-white dark:bg-[#141d18] rounded-2xl border border-slate-200/80 dark:border-[#223028] p-8">
      <div class="w-12 h-12 mx-auto rounded-full bg-[#edf4f0] dark:bg-[#1b2621] text-[#528270] flex items-center justify-center mb-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
        </svg>
      </div>
      <h3 class="text-lg font-bold text-slate-900 dark:text-white">Belum Ada Berita</h3>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Silakan jalankan seeder atau tambah artikel baru melalui Admin Panel.</p>
    </section>
  @endif

  <!-- Authors Section ("Kenali Author Terbaik Dari Kami") -->
  @if ($authors->isNotEmpty())
    <section>
      <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-6 pb-3 border-b border-slate-200/80 dark:border-[#223028]">
        <div>
          <span class="text-xs font-semibold uppercase tracking-wider text-[#528270] dark:text-[#88b5a3]">Kontributor Ahli</span>
          <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white mt-0.5">
            Kenali Author Terbaik Kami
          </h2>
        </div>
        <a href="/admin/register" 
           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs sm:text-sm font-semibold text-[#3e6657] dark:text-[#a8c7ba] bg-[#edf4f0] dark:bg-[#1a2721] hover:bg-[#e1ece5] dark:hover:bg-[#22332b] transition-colors self-start sm:self-auto border border-[#d2e3d9] dark:border-[#2c3d35]">
          <span>Gabung Menjadi Author</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
          </svg>
        </a>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
        @foreach ($authors as $author)
          <a href="{{ route('author.show', $author->username) }}" class="group block">
            <div class="h-full bg-white dark:bg-[#141d18] border border-slate-200/80 dark:border-[#223028] hover:border-[#528270]/60 dark:hover:border-[#528270]/60 rounded-2xl p-6 text-center shadow-xs hover:shadow-md transition-all duration-300 flex flex-col items-center">
              <div class="relative w-20 h-20 rounded-full overflow-hidden p-1 bg-[#edf4f0] dark:bg-[#1b2621] border-2 border-[#528270]/40 group-hover:border-[#528270] transition-colors">
                <img 
                  src="{{ $author->avatar_url }}" 
                  alt="{{ $author->user?->name ?? $author->username }}" 
                  class="w-full h-full rounded-full object-cover"
                  loading="lazy"
                />
              </div>
              <h3 class="font-bold text-base text-slate-900 dark:text-white mt-3 group-hover:text-[#528270] dark:group-hover:text-[#88b5a3] transition-colors line-clamp-1">
                {{ $author->user?->name ?? $author->username }}
              </h3>
              <p class="text-xs text-[#528270] dark:text-[#88b5a3] font-medium mt-0.5">
                {{ '@' . $author->username }}
              </p>
              <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 line-clamp-2 leading-relaxed">
                {{ $author->bio }}
              </p>
              <div class="mt-4 pt-3 w-full border-t border-slate-100 dark:border-[#1d2922] text-xs font-semibold text-slate-600 dark:text-slate-300">
                <span>{{ $author->news->count() }} Artikel Terbit</span>
              </div>
            </div>
          </a>
        @endforeach
      </div>
    </section>
  @endif

  <!-- Pilihan Author (Curated Picks) -->
  @if ($news->isNotEmpty())
    <section>
      <div class="mb-6 pb-3 border-b border-slate-200/80 dark:border-[#223028]">
        <span class="text-xs font-semibold uppercase tracking-wider text-[#528270] dark:text-[#88b5a3]">Rekomendasi Penulis</span>
        <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white mt-0.5">
          Pilihan Author
        </h2>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach ($news as $item)
          <article class="group bg-white dark:bg-[#141d18] border border-slate-200/80 dark:border-[#223028] hover:border-[#528270]/60 dark:hover:border-[#528270]/60 rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition-all duration-300 flex flex-col">
            <a href="{{ route('news.show', $item->slug) }}" class="block relative aspect-[16/10] overflow-hidden bg-slate-100 dark:bg-slate-800">
              <span class="absolute top-3 left-3 z-10 px-2.5 py-0.5 rounded-full text-xs font-semibold text-white bg-[#528270]/90 backdrop-blur-xs">
                {{ $item->newsCategory->title ?? 'Berita' }}
              </span>
              <img 
                src="{{ $item->thumbnail_url }}" 
                alt="{{ $item->title }}" 
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
                <span class="text-[#528270] dark:text-[#88b5a3] font-medium group-hover:underline">Baca Selengkapnya &rarr;</span>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </section>
  @endif

</div>
@endsection