@php
    $user = auth()->user();
    $author = $user?->author;
    $coverUrl = $author ? $author->cover_url : asset('assets/img/bg-profile.png');
    $avatarUrl = $author ? $author->avatar_url : asset('assets/img/profile.png');
    $authorName = $user?->name ?? 'Penulis';
    $authorUsername = $author?->username ?? 'author';
@endphp

<div class="np-settings-hero">
    <div class="np-settings-hero__cover">
        <img
            src="{{ $coverUrl }}"
            alt="Foto Sampul"
            onerror="this.onerror=null;this.src='{{ asset('assets/img/bg-profile.png') }}';"
        />
        <div class="np-settings-hero__shade"></div>
        <span class="np-settings-hero__badge">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" focusable="false">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Foto Sampul Saat Ini
        </span>
    </div>

    <div class="np-settings-hero__body">
        <div class="np-settings-hero__identity">
            <div class="np-settings-avatar">
                <img
                    src="{{ $avatarUrl }}"
                    alt="{{ $authorName }}"
                    onerror="this.onerror=null;this.src='{{ asset('assets/img/profile.png') }}';"
                />
            </div>
            <div class="np-settings-meta">
                <div class="np-settings-meta__title-row">
                    <h2 class="np-settings-meta__name">{{ $authorName }}</h2>
                    <span class="np-settings-meta__badge">Penulis Berita</span>
                </div>
                <p class="np-settings-meta__username">{{ '@' . $authorUsername }}</p>
            </div>
        </div>

        @if ($author)
            <a
                href="{{ route('author.show', $author->username) }}"
                target="_blank"
                rel="noopener noreferrer"
                class="np-settings-public-link"
            >
                <span>Lihat Halaman Publik</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" focusable="false">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
        @endif
    </div>
</div>
