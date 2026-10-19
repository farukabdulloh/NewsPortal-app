<div class="p-6 rounded-2xl bg-white dark:bg-[#141c18] border border-slate-200/80 dark:border-[#24352d] shadow-xs transition-all">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">
        <!-- Left: Welcome Title & Date -->
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-xs font-medium text-[#3e6657] dark:text-[#88b5a3] bg-[#edf4f0] dark:bg-[#1b2721] mb-2 border border-[#d6e3dc] dark:border-[#293d33]">
                <span class="w-1.5 h-1.5 rounded-full bg-[#528270]"></span>
                <span>{{ $this->getFormattedDate() }}</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                Selamat Datang, {{ $this->getAuthorName() }} 👋
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1 max-w-xl">
                Tulis artikel berkualitas, pantau publikasi karya Anda, dan bagikan wawasan terbaru kepada pembaca NewsPortal.
            </p>
        </div>

        <!-- Right: Action Buttons -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ url('/author/news/create') }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 text-xs sm:text-sm font-semibold text-white bg-[#528270] hover:bg-[#416a5a] rounded-xl shadow-xs transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Tulis Berita Baru</span>
            </a>

            <a href="{{ url('/author/news') }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-200 hover:text-[#3e6657] dark:hover:text-[#88b5a3] bg-slate-100 hover:bg-[#edf4f0] dark:bg-[#1b2621] dark:hover:bg-[#22332c] border border-slate-200/80 dark:border-[#273830] rounded-xl transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <span>Kelola Berita Saya</span>
            </a>

            <a href="{{ route('landing') }}"
               target="_blank"
               class="inline-flex items-center gap-1 px-3 py-2 text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-[#528270] dark:hover:text-[#88b5a3] transition-colors">
                <span>Lihat Web</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
            </a>
        </div>
    </div>
</div>
