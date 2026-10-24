@php
    $user = filament()->auth()->user();
    $logoutUrl = filament()->getLogoutUrl();
    $roleLabel = ($user && method_exists($user, 'isAdmin') && $user->isAdmin()) ? 'Admin' : 'Penulis';
    $author = $user?->author;
    $avatarUrl = $author ? $author->avatar_url : asset('assets/img/profile.png');
@endphp

@if ($user)
<div class="np-sidebar-account">
    <div class="np-sidebar-account__profile">
        <div class="np-sidebar-account__avatar">
            <img
                src="{{ $avatarUrl }}"
                alt="{{ $user->name }}"
                onerror="this.onerror=null;this.src='{{ asset('assets/img/profile.png') }}';"
            />
        </div>
        <div class="np-sidebar-account__meta">
            <p class="np-sidebar-account__name" title="{{ $user->name }}">
                {{ $user->name }}
            </p>
            <span class="np-sidebar-account__role">
                {{ $roleLabel }}
            </span>
        </div>
    </div>

    <form method="POST" action="{{ $logoutUrl }}" class="np-sidebar-account__form">
        @csrf
        <button type="submit" class="np-sidebar-logout">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" focusable="false">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span>Keluar (Logout)</span>
        </button>
    </form>
</div>
@endif
