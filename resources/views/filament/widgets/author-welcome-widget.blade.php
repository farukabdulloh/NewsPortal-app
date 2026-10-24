<section class="dashboard-welcome">
    <div class="dashboard-welcome__intro">
        <span class="dashboard-welcome__date"><span aria-hidden="true"></span>{{ $this->getFormattedDate() }}</span>
        <h1>Selamat datang, {{ $this->getAuthorName() }} <span aria-hidden="true">👋</span></h1>
        <p>Tulis artikel berkualitas, pantau publikasi karya Anda, dan bagikan wawasan terbaru kepada pembaca.</p>
    </div>

    <nav class="dashboard-actions dashboard-actions--author" aria-label="Aksi cepat">
        <a href="{{ url('/author/news/create') }}" class="dashboard-action dashboard-action--primary">
            <span class="dashboard-action__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" /></svg></span>
            <span class="dashboard-action__copy"><strong>Tulis Berita Baru</strong><small>Mulai artikel baru</small></span>
        </a>
        <a href="{{ url('/author/news') }}" class="dashboard-action">
            <span class="dashboard-action__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 4h8l4 4v12H4V4h4zm7 0v5h5M8 13h8M8 17h8" /></svg></span>
            <span class="dashboard-action__copy"><strong>Kelola Berita Saya</strong><small>Lihat semua artikel</small></span>
        </a>
        <a href="{{ route('landing') }}" target="_blank" rel="noopener noreferrer" class="dashboard-action">
            <span class="dashboard-action__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M14 4h6v6m-1-5-9 9M18 13v6a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h6" /></svg></span>
            <span class="dashboard-action__copy"><strong>Lihat Web</strong><small>Buka NewsPortal</small></span>
        </a>
    </nav>
</section>
