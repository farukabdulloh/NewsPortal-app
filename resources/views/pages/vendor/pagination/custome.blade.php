@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="w-full flex items-center justify-center gap-1.5 sm:gap-2 pt-8 mb-6">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-slate-200 dark:border-[#223028] text-slate-300 dark:text-slate-600 bg-white/50 dark:bg-[#141d18]/50 cursor-not-allowed select-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" 
               class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-slate-200 dark:border-[#223028] text-slate-700 dark:text-slate-200 bg-white dark:bg-[#141d18] hover:border-[#528270] hover:text-[#528270] dark:hover:border-[#88b5a3] dark:hover:text-[#88b5a3] transition-all shadow-xs">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="inline-flex items-center justify-center w-10 h-10 text-slate-400 select-none">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl font-bold text-sm text-white bg-[#528270] shadow-xs select-none">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" 
                           class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-slate-200 dark:border-[#223028] text-sm font-medium text-slate-700 dark:text-slate-200 bg-white dark:bg-[#141d18] hover:border-[#528270] hover:text-[#528270] dark:hover:border-[#88b5a3] dark:hover:text-[#88b5a3] transition-all shadow-xs">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" 
               class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-slate-200 dark:border-[#223028] text-slate-700 dark:text-slate-200 bg-white dark:bg-[#141d18] hover:border-[#528270] hover:text-[#528270] dark:hover:border-[#88b5a3] dark:hover:text-[#88b5a3] transition-all shadow-xs">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        @else
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-slate-200 dark:border-[#223028] text-slate-300 dark:text-slate-600 bg-white/50 dark:bg-[#141d18]/50 cursor-not-allowed select-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </span>
        @endif
    </nav>
@endif
