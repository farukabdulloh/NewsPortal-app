<!-- Navbar -->
<header class="sticky top-0 z-50 w-full bg-white/85 dark:bg-[#121915]/85 backdrop-blur-md border-b border-slate-200/80 dark:border-[#223029] transition-colors duration-200">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16 sm:h-20 gap-4">
      
      <!-- Left: Logo & Desktop Links -->
      <div class="flex items-center gap-8">
        <!-- Logo -->
        <a href="{{ route('landing') }}" class="flex items-center gap-2.5 group">
          <div class="w-9 h-9 rounded-xl bg-[#edf3ef] dark:bg-[#1b2621] border border-[#d6e3dc] dark:border-[#2c3d34] flex items-center justify-center p-1.5 transition-transform duration-200 group-hover:scale-105">
            <img src="{{ asset('assets/img/Logo.png') }}" alt="NewsPortal Logo" class="w-full h-full object-contain">
          </div>
          <span class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">
            News<span class="text-[#528270]">Portal</span>
          </span>
        </a>

        <!-- Desktop Navigation Categories -->
        <nav class="hidden md:flex items-center gap-1">
          <a href="{{ route('landing') }}" 
             class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('landing') ? 'text-[#3e6657] dark:text-[#88b5a3] bg-[#edf4f0] dark:bg-[#1a2721]' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/70 dark:hover:bg-[#18231e]' }}">
            Beranda
          </a>
          <a href="{{ route('news.index') }}" 
             class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('news.index') ? 'text-[#3e6657] dark:text-[#88b5a3] bg-[#edf4f0] dark:bg-[#1a2721]' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/70 dark:hover:bg-[#18231e]' }}">
            Semua Berita
          </a>
          @foreach (\App\Models\NewsCategory::all() as $cat)
            <a href="{{ route('news.category', $cat->slug) }}" 
               class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->is('category/' . $cat->slug) ? 'text-[#3e6657] dark:text-[#88b5a3] bg-[#edf4f0] dark:bg-[#1a2721]' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/70 dark:hover:bg-[#18231e]' }}">
              {{ $cat->title }}
            </a>
          @endforeach
        </nav>
      </div>

      <!-- Right: Search, Theme Toggle, Admin Button, Mobile Toggle -->
      <div class="flex items-center gap-2 sm:gap-3">
        
        <!-- Search Input (Desktop) -->
        <form action="{{ route('news.index') }}" method="GET" class="hidden lg:block relative">
          <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}"
            placeholder="Cari artikel berita..." 
            class="w-56 xl:w-64 pl-9 pr-4 py-1.5 text-xs sm:text-sm bg-slate-100/80 dark:bg-[#18241e] text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 border border-slate-200 dark:border-[#273830] rounded-full focus:outline-none focus:ring-2 focus:ring-[#528270]/40 focus:border-[#528270] transition-all"
          />
          <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </span>
        </form>

        <!-- Theme Toggle Button (Light/Dark Mode) -->
        <button 
          type="button" 
          onclick="toggleTheme()" 
          title="Ganti Mode Tampilan (Light / Night Mode)"
          class="p-2 rounded-full text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-[#1a2620] border border-slate-200/80 dark:border-[#2a3a32] transition-colors focus:outline-none">
          <!-- Sun Icon (shown when in dark mode) -->
          <svg class="w-4 h-4 sm:w-5 sm:h-5 theme-toggle-icon-sun hidden text-amber-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
          </svg>
          <!-- Moon Icon (shown when in light mode) -->
          <svg class="w-4 h-4 sm:w-5 sm:h-5 theme-toggle-icon-moon text-slate-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
          </svg>
        </button>

        <!-- Login / Dashboard Actions -->
        @if (auth()->check())
          @php
            $isAdmin = auth()->user()->isAdmin();
            $dashboardUrl = $isAdmin ? url('/admin') : url('/author');
            $dashboardLabel = $isAdmin ? 'Dashboard Admin' : 'Dashboard Penulis';
            $logoutUrl = $isAdmin ? route('filament.admin.auth.logout') : route('filament.author.auth.logout');
          @endphp
          <div class="hidden sm:flex items-center gap-2">
            <a href="{{ $dashboardUrl }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs sm:text-sm font-semibold text-white bg-[#528270] hover:bg-[#416a5a] rounded-full shadow-xs transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
              <span>{{ $dashboardLabel }}</span>
            </a>
            @if (! $isAdmin && auth()->user()->author)
              <a href="{{ url('/author/settings') }}"
                 title="Pengaturan Profil"
                 class="p-2 text-slate-600 dark:text-slate-300 hover:text-[#528270] dark:hover:text-[#88b5a3] hover:bg-slate-100 dark:hover:bg-[#1a2620] rounded-full border border-slate-200/80 dark:border-[#2a3a32] transition-colors">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </a>
            @endif
            <form method="POST" action="{{ $logoutUrl }}" class="inline-block">
              @csrf
              <button
                type="submit"
                title="Keluar (Logout)"
                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs sm:text-sm font-medium text-rose-600 dark:text-rose-400 hover:text-white hover:bg-rose-600 dark:hover:bg-rose-600 border border-rose-200 dark:border-rose-900/60 hover:border-rose-600 rounded-full transition-colors">
                <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Keluar</span>
              </button>
            </form>
          </div>
        @else
          <div class="hidden sm:flex items-center gap-2">
            <a href="{{ url('/author/login') }}" 
               class="inline-flex items-center px-3 py-1.5 text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-200 hover:text-[#3e6657] dark:hover:text-[#88b5a3] hover:bg-slate-100 dark:hover:bg-[#1b2621] rounded-full transition-colors">
              <span>Masuk Penulis</span>
            </a>
            <a href="{{ url('/admin/login') }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs sm:text-sm font-semibold text-white bg-[#528270] hover:bg-[#416a5a] rounded-full shadow-xs transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
              </svg>
              <span>Admin</span>
            </a>
          </div>
        @endif

        <!-- Mobile Menu Toggle Button -->
        <button 
          id="menu-toggle"
          type="button" 
          class="md:hidden p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-[#1a2620] rounded-lg transition-colors focus:outline-none"
          aria-label="Buka menu navigasi">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>

      </div>
    </div>

    <!-- Mobile Drawer Menu -->
    <div id="mobile-menu" class="hidden md:hidden py-4 border-t border-slate-200/80 dark:border-[#223029] space-y-3">
      <!-- Mobile Search Form -->
      <form action="{{ route('news.index') }}" method="GET" class="relative">
        <input 
          type="text" 
          name="search" 
          value="{{ request('search') }}"
          placeholder="Cari berita..." 
          class="w-full pl-9 pr-4 py-2 text-sm bg-slate-100/90 dark:bg-[#18241e] text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 border border-slate-200 dark:border-[#273830] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#528270]/40"
        />
        <span class="absolute inset-y-0 left-3 flex items-center text-slate-400 dark:text-slate-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </span>
      </form>

      <!-- Mobile Navigation Links -->
      <div class="flex flex-col space-y-1 pt-2">
        <a href="{{ route('landing') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-[#1a2721]">
          Beranda
        </a>
        <a href="{{ route('news.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-[#1a2721]">
          Semua Berita
        </a>
        @foreach (\App\Models\NewsCategory::all() as $cat)
          <a href="{{ route('news.category', $cat->slug) }}" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-[#1a2721]">
            {{ $cat->title }}
          </a>
        @endforeach
      </div>

      <!-- Mobile Auth Action -->
      <div class="pt-3 border-t border-slate-200/60 dark:border-[#223029] space-y-2">
        @if (auth()->check())
          @php
            $isAdmin = auth()->user()->isAdmin();
            $dashboardUrl = $isAdmin ? url('/admin') : url('/author');
            $dashboardLabel = $isAdmin ? 'Masuk Dashboard Admin' : 'Masuk Dashboard Penulis';
            $logoutUrl = $isAdmin ? route('filament.admin.auth.logout') : route('filament.author.auth.logout');
          @endphp
          <a href="{{ $dashboardUrl }}" class="flex items-center justify-center gap-2 w-full py-2.5 text-sm font-semibold text-white bg-[#528270] hover:bg-[#416a5a] rounded-xl shadow-xs">
            <span>{{ $dashboardLabel }}</span>
          </a>
          @if (! $isAdmin && auth()->user()->author)
            <a href="{{ url('/author/settings') }}" class="flex items-center justify-center gap-2 w-full py-2 text-sm font-medium text-[#3e6657] dark:text-[#88b5a3] bg-[#edf4f0] dark:bg-[#1a2721] rounded-xl border border-[#d2e3d9] dark:border-[#2b3c34]">
              <span>Pengaturan Profil</span>
            </a>
          @endif
          <form method="POST" action="{{ $logoutUrl }}" class="w-full">
            @csrf
            <button type="submit" class="flex items-center justify-center gap-2 w-full py-2 text-sm font-semibold text-rose-600 dark:text-rose-400 hover:text-white hover:bg-rose-600 rounded-xl border border-rose-200 dark:border-rose-900/60 transition-colors">
              <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
              </svg>
              <span>Keluar (Logout)</span>
            </button>
          </form>
        @else
          <a href="{{ url('/author/login') }}" class="flex items-center justify-center gap-2 w-full py-2 text-sm font-medium text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-[#1a2620] hover:bg-slate-200 rounded-xl">
            <span>Masuk Penulis</span>
          </a>
          <a href="{{ url('/author/register') }}" class="flex items-center justify-center gap-2 w-full py-2 text-sm font-medium text-[#3e6657] dark:text-[#88b5a3] bg-[#edf4f0] dark:bg-[#1b2721] rounded-xl border border-[#d6e3dc] dark:border-[#283930]">
            <span>Daftar Jadi Penulis</span>
          </a>
          <a href="{{ url('/admin/login') }}" class="flex items-center justify-center gap-2 w-full py-2.5 text-sm font-semibold text-white bg-[#528270] hover:bg-[#416a5a] rounded-xl shadow-xs">
            <span>Masuk Admin</span>
          </a>
        @endif
      </div>
    </div>

  </div>
</header>