<!doctype html>
<html lang="id" class="h-full">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Portal Berita Terkini') — NewsPortal</title>
  <meta name="description" content="NewsPortal - Sumber informasi dan berita terpercaya, akurat, dan berimbang seputar teknologi, otomotif, kesehatan, dan gaya hidup.">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/Logo.png') }}">

  <!-- Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Swiper Carousel CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <!-- Anti-FOUC Dark Mode Initializer -->
  <script>
    (function() {
      const savedTheme = localStorage.getItem('theme');
      if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    })();
  </script>

  <!-- Vite / Tailwind CSS & JS -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col min-h-full bg-[#f8faf9] text-slate-800 dark:bg-[#0f1412] dark:text-[#e4eae6] transition-colors duration-200">
  <!-- Navbar -->
  @include('includes.navbar')

  <!-- Main Content -->
  <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="mt-auto border-t border-slate-200/80 dark:border-[#223029] bg-white/70 dark:bg-[#141c18]/80 backdrop-blur-md transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
        <div class="md:col-span-2">
          <div class="flex items-center gap-2.5 mb-3">
            <img src="{{ asset('assets/img/Logo.png') }}" alt="Logo" class="w-8 h-8 object-contain">
            <span class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">News<span class="text-[#528270]">Portal</span></span>
          </div>
          <p class="text-sm text-slate-600 dark:text-slate-400 max-w-md leading-relaxed">
            Menyajikan berita dan wawasan terpercaya dari berbagai bidang mulai dari teknologi, otomotif, kesehatan, wisata, hingga gaya hidup dengan sentuhan modern dan jurnalisme berimbang.
          </p>
        </div>

        <div>
          <h4 class="text-sm font-semibold uppercase tracking-wider text-slate-900 dark:text-white mb-3">Kategori</h4>
          <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
            @foreach (\App\Models\NewsCategory::take(5)->get() as $cat)
              <li>
                <a href="{{ route('news.category', $cat->slug) }}" class="hover:text-[#528270] dark:hover:text-[#88b5a3] transition-colors">
                  {{ $cat->title }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>

        <div>
          <h4 class="text-sm font-semibold uppercase tracking-wider text-slate-900 dark:text-white mb-3">Tautan Cepat</h4>
          <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
            <li><a href="{{ route('landing') }}" class="hover:text-[#528270] dark:hover:text-[#88b5a3] transition-colors">Beranda</a></li>
            <li><a href="{{ route('news.index') }}" class="hover:text-[#528270] dark:hover:text-[#88b5a3] transition-colors">Semua Berita</a></li>
            <li><a href="{{ url('/author/login') }}" class="hover:text-[#528270] dark:hover:text-[#88b5a3] transition-colors">Masuk Penulis</a></li>
            <li><a href="{{ url('/author/register') }}" class="hover:text-[#528270] dark:hover:text-[#88b5a3] transition-colors">Daftar Penulis</a></li>
            <li><a href="{{ url('/admin/login') }}" class="hover:text-[#528270] dark:hover:text-[#88b5a3] transition-colors">Masuk Admin</a></li>
          </ul>
        </div>
      </div>

      <div class="pt-6 border-t border-slate-200/60 dark:border-[#223029] flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500 dark:text-slate-400">
        <p>&copy; {{ date('Y') }} NewsPortal. Crafted with modern engineering &amp; design standards.</p>
        <p class="flex items-center gap-1">
          Designed with <span class="text-[#528270] font-medium">Soft Sage Green</span> theme &bull; Light &amp; Night Mode
        </p>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>

</html>