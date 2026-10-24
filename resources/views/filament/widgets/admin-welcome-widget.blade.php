<section class="dashboard-welcome">
    <div class="dashboard-welcome__intro">
        <span class="dashboard-welcome__date"><span aria-hidden="true"></span>{{ $this->getFormattedDate() }}</span>
        <h1>Welcome back, {{ $this->getUserName() }} <span aria-hidden="true">👋</span></h1>
        <p>Pantau publikasi, aktivitas penulis, dan kelola NewsPortal dari satu tempat.</p>
    </div>

    <nav class="dashboard-actions" aria-label="Aksi cepat">
        <a href="{{ url('/admin/news/create') }}" class="dashboard-action dashboard-action--primary">
            <span class="dashboard-action__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" /></svg></span>
            <span class="dashboard-action__copy"><strong>Create News</strong><small>Buat artikel baru</small></span>
        </a>
        <a href="{{ url('/admin/news') }}" class="dashboard-action">
            <span class="dashboard-action__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 4h8l4 4v12H4V4h4zm7 0v5h5M8 13h8M8 17h8" /></svg></span>
            <span class="dashboard-action__copy"><strong>Manage News</strong><small>Kelola artikel</small></span>
        </a>
        <a href="{{ url('/admin/authors') }}" class="dashboard-action">
            <span class="dashboard-action__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16 19h5v-1a4 4 0 0 0-6.5-3.1M16 19H3v-1a7 7 0 0 1 13-3.1M15 6a4 4 0 1 1-8 0 4 4 0 0 1 8 0zm5 3a3 3 0 1 1-6 0" /></svg></span>
            <span class="dashboard-action__copy"><strong>Authors</strong><small>Daftar penulis</small></span>
        </a>
        <a href="{{ url('/admin/news-categories') }}" class="dashboard-action">
            <span class="dashboard-action__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 4h14v17l-7-4-7 4V4z" /></svg></span>
            <span class="dashboard-action__copy"><strong>Categories</strong><small>Atur topik berita</small></span>
        </a>
        <a href="{{ route('landing') }}" target="_blank" rel="noopener noreferrer" class="dashboard-action">
            <span class="dashboard-action__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M14 4h6v6m-1-5-9 9M18 13v6a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h6" /></svg></span>
            <span class="dashboard-action__copy"><strong>Lihat Web</strong><small>Buka NewsPortal</small></span>
        </a>
    </nav>
</section>
