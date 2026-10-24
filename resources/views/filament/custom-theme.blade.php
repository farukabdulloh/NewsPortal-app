<!-- Fonts & Soft Sage Green Theme Customization -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<script>
    (function () {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else if (savedTheme === 'light') {
            document.documentElement.classList.remove('dark');
        }
    })();
</script>

<style>
    /* ========================================================
       Global Typography & Theme Tokens
       ======================================================== */
    body, * {
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif !important;
    }

    :root {
        --sage-primary: #528270;
        --sage-primary-hover: #416a5a;
        --sage-primary-light: rgba(82, 130, 112, 0.08);
        --sage-primary-border: #d5e3dc;
        --sage-surface: #f8faf9;
        --sage-card: #ffffff;
        --sage-border: #e4ece7;
        --sage-text-main: #0f172a;
        --sage-text-muted: #64748b;
    }

    .dark {
        --sage-primary: #528270;
        --sage-primary-hover: #679f8b;
        --sage-primary-light: rgba(82, 130, 112, 0.16);
        --sage-primary-border: #293d33;
        --sage-surface: #0f1412;
        --sage-card: #141c18;
        --sage-border: #223029;
        --sage-text-main: #f8fafc;
        --sage-text-muted: #94a39b;
    }

    /* Page background */
    body.fi-body {
        background-color: var(--sage-surface) !important;
        color: var(--sage-text-main) !important;
    }

    /* ========================================================
       ROOT CAUSE FIX: Strict Global Icon & SVG Size Guards
       Prevent ANY icon/SVG from blowing up to full-screen/giant size
       ======================================================== */
    svg {
        vertical-align: middle;
    }

    /* Base Filament Icon Utility Bounds */
    .fi-icon {
        vertical-align: middle !important;
        flex-shrink: 0 !important;
    }

    .fi-icon.fi-size-xs,
    .fi-size-xs > .fi-icon {
        width: 0.75rem !important;  /* 12px */
        height: 0.75rem !important;
        min-width: 0.75rem !important;
    }

    .fi-icon.fi-size-sm,
    .fi-size-sm > .fi-icon {
        width: 0.875rem !important; /* 14px */
        height: 0.875rem !important;
        min-width: 0.875rem !important;
    }

    .fi-icon.fi-size-md,
    .fi-size-md > .fi-icon {
        width: 1.125rem !important; /* 18px */
        height: 1.125rem !important;
        min-width: 1.125rem !important;
    }

    /* Override Filament v5's 40px default for fi-size-lg */
    .fi-icon.fi-size-lg,
    .fi-size-lg > .fi-icon {
        width: 1.25rem !important;  /* 20px */
        height: 1.25rem !important;
        min-width: 1.25rem !important;
    }

    .fi-icon.fi-size-xl,
    .fi-size-xl > .fi-icon {
        width: 1.5rem !important;   /* 24px */
        height: 1.5rem !important;
        min-width: 1.5rem !important;
    }

    /* Empty state icon bounds */
    .fi-ta-empty-state-icon,
    .fi-empty-state-icon {
        width: 2.75rem !important;
        height: 2.75rem !important;
        margin-inline: auto !important;
        color: #94a39b !important;
    }

    .fi-ta-empty-state-icon .fi-icon,
    .fi-empty-state-icon .fi-icon {
        width: 2.5rem !important;
        height: 2.5rem !important;
    }

    /* Spin animation for loading indicators */
    .fi-loading-indicator {
        animation: spin 1s linear infinite !important;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* ========================================================
       1. SIDEBAR & NAVIGATION STYLING
       ======================================================== */
    .fi-sidebar {
        background-color: var(--sage-card) !important;
        border-right: 1px solid var(--sage-border) !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02) !important;
    }

    /* Sidebar Header / Brand */
    .fi-sidebar-header {
        height: 4rem !important;
        border-bottom: 1px solid var(--sage-border) !important;
        padding-inline: 1.25rem !important;
    }

    .fi-logo {
        font-weight: 700 !important;
        font-size: 1.0625rem !important;
        letter-spacing: -0.02em !important;
        color: var(--sage-text-main) !important;
    }

    /* Sidebar Navigation Items */
    .fi-sidebar-nav {
        padding-inline: 0.625rem !important;
        padding-block: 0.75rem !important;
        gap: 0.25rem !important;
    }

    .fi-sidebar-item {
        margin-block: 0.125rem !important;
    }

    .fi-sidebar-item-btn {
        border-radius: 0.625rem !important;
        padding: 0.5rem 0.75rem !important;
        font-size: 0.84375rem !important;
        font-weight: 500 !important;
        color: #475569 !important;
        transition: all 0.15s ease-in-out !important;
        display: flex !important;
        align-items: center !important;
        gap: 0.625rem !important;
    }
    .dark .fi-sidebar-item-btn {
        color: #94a3b8 !important;
    }

    /* Sidebar Icons */
    .fi-sidebar-item-icon,
    .fi-sidebar-item-btn .fi-icon {
        width: 1.1875rem !important; /* 19px */
        height: 1.1875rem !important;
        min-width: 1.1875rem !important;
        flex-shrink: 0 !important;
        color: #64748b !important;
        transition: color 0.15s ease !important;
    }
    .dark .fi-sidebar-item-icon,
    .dark .fi-sidebar-item-btn .fi-icon {
        color: #94a39b !important;
    }

    /* Sidebar Item Hover */
    .fi-sidebar-item:not(.fi-active) .fi-sidebar-item-btn:hover {
        background-color: var(--sage-primary-light) !important;
        color: #1e293b !important;
    }
    .dark .fi-sidebar-item:not(.fi-active) .fi-sidebar-item-btn:hover {
        color: #f1f5f9 !important;
    }

    .fi-sidebar-item:not(.fi-active) .fi-sidebar-item-btn:hover .fi-sidebar-item-icon,
    .fi-sidebar-item:not(.fi-active) .fi-sidebar-item-btn:hover .fi-icon {
        color: var(--sage-primary) !important;
    }

    /* Active Sidebar Navigation Item */
    .fi-sidebar-item.fi-active .fi-sidebar-item-btn {
        background-color: var(--sage-primary-light) !important;
        color: #37574b !important;
        font-weight: 600 !important;
        box-shadow: inset 3px 0 0 var(--sage-primary) !important;
    }
    .dark .fi-sidebar-item.fi-active .fi-sidebar-item-btn {
        color: #8ec2ae !important;
    }

    .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
    .fi-sidebar-item.fi-active .fi-sidebar-item-btn .fi-icon {
        color: var(--sage-primary) !important;
    }
    .dark .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
    .dark .fi-sidebar-item.fi-active .fi-sidebar-item-btn .fi-icon {
        color: #76a291 !important;
    }

    /* Sidebar Badge */
    .fi-sidebar-item-badge {
        font-size: 0.6875rem !important;
        font-weight: 600 !important;
        padding: 0.125rem 0.4375rem !important;
        border-radius: 9999px !important;
        background-color: rgba(82, 130, 112, 0.12) !important;
        color: var(--sage-primary) !important;
    }

    /* ========================================================
       2. TOPBAR & BREADCRUMBS
       ======================================================== */
    .fi-topbar {
        height: 4rem !important;
        background-color: rgba(255, 255, 255, 0.88) !important;
        backdrop-filter: blur(12px) !important;
        -webkit-backdrop-filter: blur(12px) !important;
        border-bottom: 1px solid var(--sage-border) !important;
    }
    .dark .fi-topbar {
        background-color: rgba(18, 24, 21, 0.88) !important;
    }

    /* Mobile Sidebar Toggle Button */
    .fi-topbar-open-sidebar-btn,
    .fi-topbar-close-sidebar-btn {
        width: 2.125rem !important;
        height: 2.125rem !important;
        border-radius: 0.5rem !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        color: #64748b !important;
    }
    .fi-topbar-open-sidebar-btn .fi-icon,
    .fi-topbar-close-sidebar-btn .fi-icon {
        width: 1.25rem !important;
        height: 1.25rem !important;
    }

    /* Breadcrumbs */
    .fi-breadcrumbs {
        font-size: 0.8125rem !important;
        font-weight: 500 !important;
    }
    .fi-breadcrumbs ol li .fi-icon {
        width: 0.875rem !important;
        height: 0.875rem !important;
        color: #94a3b8 !important;
    }

    /* Topbar Icon Buttons (Theme toggle, notifications, etc.) */
    .fi-topbar .fi-icon-btn {
        width: 2.125rem !important;
        height: 2.125rem !important;
        min-width: 2.125rem !important;
        border-radius: 0.5rem !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: background-color 0.15s ease, color 0.15s ease !important;
    }
    .fi-topbar .fi-icon-btn > .fi-icon {
        width: 1.125rem !important;
        height: 1.125rem !important;
    }
    .fi-topbar .fi-icon-btn:hover {
        background-color: var(--sage-primary-light) !important;
        color: var(--sage-primary) !important;
    }

    /* User Avatar */
    .fi-user-avatar {
        width: 2.5rem !important;
        height: 2.5rem !important;
        border-radius: 9999px !important;
        border: 1.5px solid var(--sage-border) !important;
    }

    /* ========================================================
       3. STAT OVERVIEW WIDGET (MODERN DASHBOARD CARDS)
       ======================================================== */
    .fi-wi-stats-overview-stat {
        background-color: var(--sage-card) !important;
        border: 1px solid var(--sage-border) !important;
        border-radius: 1rem !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.03), 0 1px 2px -1px rgba(0, 0, 0, 0.02) !important;
        padding: 1.25rem 1.375rem !important;
        position: relative !important;
        overflow: hidden !important;
        transition: all 0.2s ease-in-out !important;
    }

    .fi-wi-stats-overview-stat:hover {
        border-color: #cfded6 !important;
        box-shadow: 0 6px 16px -4px rgba(82, 130, 112, 0.1), 0 2px 6px -1px rgba(0, 0, 0, 0.04) !important;
    }
    .dark .fi-wi-stats-overview-stat:hover {
        border-color: #31463c !important;
        box-shadow: 0 6px 20px -4px rgba(0, 0, 0, 0.5) !important;
    }

    .fi-wi-stats-overview-stat-content {
        display: flex !important;
        flex-direction: column !important;
        gap: 0.35rem !important;
    }

    /* Label Container with Top Icon */
    .fi-wi-stats-overview-stat-label-ctn {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        flex-direction: row-reverse !important;
        margin-bottom: 0.25rem !important;
    }

    .fi-wi-stats-overview-stat-label-ctn .fi-icon {
        width: 1.125rem !important;
        height: 1.125rem !important;
        min-width: 1.125rem !important;
        padding: 0.375rem !important;
        box-sizing: content-box !important;
        border-radius: 0.5rem !important;
        background-color: rgba(82, 130, 112, 0.08) !important;
        color: var(--sage-primary) !important;
        flex-shrink: 0 !important;
    }
    .dark .fi-wi-stats-overview-stat-label-ctn .fi-icon {
        background-color: rgba(82, 130, 112, 0.18) !important;
        color: #76a291 !important;
    }

    .fi-wi-stats-overview-stat-label {
        font-size: 0.8125rem !important;
        font-weight: 600 !important;
        color: #64748b !important;
        letter-spacing: -0.01em !important;
    }
    .dark .fi-wi-stats-overview-stat-label {
        color: #94a3b8 !important;
    }

    /* Stat Number / Value */
    .fi-wi-stats-overview-stat-value {
        font-size: 1.75rem !important; /* 28px */
        font-weight: 700 !important;
        letter-spacing: -0.03em !important;
        line-height: 1.2 !important;
        color: var(--sage-text-main) !important;
        font-variant-numeric: tabular-nums !important;
    }

    /* Stat Description */
    .fi-wi-stats-overview-stat-description {
        font-size: 0.75rem !important;
        font-weight: 500 !important;
        color: #64748b !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.35rem !important;
        margin-top: 0.25rem !important;
    }
    .dark .fi-wi-stats-overview-stat-description {
        color: #94a3b8 !important;
    }

    .fi-wi-stats-overview-stat-description .fi-icon {
        width: 0.875rem !important; /* 14px */
        height: 0.875rem !important;
        min-width: 0.875rem !important;
        flex-shrink: 0 !important;
    }

    /* Sparkline Chart Canvas */
    .fi-wi-stats-overview-stat-chart canvas {
        height: 1.75rem !important;
    }

    /* ========================================================
       4. TABLES & TABLE WIDGETS
       ======================================================== */
    .fi-ta-ctn {
        background-color: var(--sage-card) !important;
        border: 1px solid var(--sage-border) !important;
        border-radius: 1rem !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.03) !important;
        overflow: hidden !important;
    }

    /* Table Toolbar */
    .fi-ta-header {
        padding: 1rem 1.25rem !important;
        border-bottom: 1px solid var(--sage-border) !important;
    }

    .fi-ta-header-heading {
        font-size: 1.0625rem !important;
        font-weight: 700 !important;
        color: var(--sage-text-main) !important;
        letter-spacing: -0.02em !important;
    }

    .fi-ta-header-description {
        font-size: 0.8125rem !important;
        color: var(--sage-text-muted) !important;
        margin-top: 0.125rem !important;
    }

    /* Table Search Input */
    .fi-ta-search-field input,
    .fi-input-wrp {
        border-radius: 0.625rem !important;
        border-color: var(--sage-border) !important;
        font-size: 0.8125rem !important;
    }

    /* Table Header Columns (th) */
    .fi-ta th {
        background-color: #f8faf9 !important;
        padding: 0.6875rem 1rem !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        color: #64748b !important;
        border-bottom: 1px solid var(--sage-border) !important;
    }
    .dark .fi-ta th {
        background-color: #17221d !important;
        color: #94a3b8 !important;
    }

    /* Table Body Cells (td) */
    .fi-ta td {
        padding: 0.8125rem 1rem !important;
        font-size: 0.84375rem !important;
        border-bottom: 1px solid #f1f5f3 !important;
    }
    .dark .fi-ta td {
        border-bottom: 1px solid #1c2822 !important;
    }

    /* Table Row Hover */
    .fi-ta-row:hover td {
        background-color: rgba(82, 130, 112, 0.025) !important;
    }
    .dark .fi-ta-row:hover td {
        background-color: rgba(82, 130, 112, 0.07) !important;
    }

    /* Table Action Buttons (View, Edit, Delete) */
    .fi-ta-actions .fi-icon-btn,
    .fi-ta-record-actions .fi-icon-btn,
    .fi-icon-btn.fi-size-md {
        width: 1.875rem !important; /* 30px */
        height: 1.875rem !important;
        min-width: 1.875rem !important;
        border-radius: 0.5rem !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.15s ease !important;
    }

    .fi-ta-actions .fi-icon-btn .fi-icon,
    .fi-ta-record-actions .fi-icon-btn .fi-icon,
    .fi-icon-btn.fi-size-md .fi-icon {
        width: 0.9375rem !important; /* 15px */
        height: 0.9375rem !important;
    }

    .fi-ta-actions .fi-icon-btn:hover,
    .fi-icon-btn:not([disabled]):hover {
        background-color: var(--sage-primary-light) !important;
        color: var(--sage-primary) !important;
    }

    /* Danger action (Delete) hover styling */
    .fi-ta-actions .fi-icon-btn.fi-color-danger:hover,
    .fi-icon-btn.fi-color-danger:hover {
        background-color: rgba(239, 68, 68, 0.1) !important;
        color: #dc2626 !important;
    }

    /* Badges in Tables */
    .fi-badge {
        border-radius: 9999px !important;
        font-size: 0.75rem !important;
        font-weight: 500 !important;
        padding: 0.1875rem 0.5625rem !important;
    }

    /* Table Pagination */
    .fi-ta-pagination {
        padding: 0.75rem 1rem !important;
        border-top: 1px solid var(--sage-border) !important;
    }

    /* ========================================================
       5. PRIMARY BUTTONS & FORMS
       ======================================================== */
    .fi-btn-color-primary {
        background-color: var(--sage-primary) !important;
        border-color: var(--sage-primary) !important;
        color: #ffffff !important;
        border-radius: 0.625rem !important;
        font-weight: 600 !important;
        box-shadow: 0 1px 2px 0 rgba(82, 130, 112, 0.25) !important;
        transition: all 0.15s ease !important;
    }
    .fi-btn-color-primary:hover {
        background-color: var(--sage-primary-hover) !important;
        border-color: var(--sage-primary-hover) !important;
    }

    .fi-btn .fi-icon {
        width: 1rem !important;
        height: 1rem !important;
        min-width: 1rem !important;
    }

    /* Form Fields & Inputs */
    .fi-fo-field-wrp {
        border-radius: 0.625rem !important;
    }

    .fi-input,
    .fi-select-input {
        border-radius: 0.625rem !important;
    }

    .fi-input:focus,
    .fi-select-input:focus {
        border-color: var(--sage-primary) !important;
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(82, 130, 112, 0.2) !important;
    }

    /* ========================================================
       6. AUTH PAGES (LOGIN / REGISTER)
       ======================================================== */
    .fi-simple-main-ctn {
        background-color: var(--sage-surface) !important;
    }

    .fi-simple-main {
        border-radius: 1.25rem !important;
        box-shadow: 0 6px 24px -2px rgba(82, 130, 112, 0.08), 0 2px 6px -1px rgba(0, 0, 0, 0.04) !important;
        border: 1px solid var(--sage-border) !important;
        background-color: var(--sage-card) !important;
        padding: 2rem !important;
    }

    /* ========================================================
       7. RESPONSIVENESS & SPACING
       ======================================================== */
    .fi-main {
        padding-inline: 1rem !important;
        padding-block: 1.25rem !important;
    }

    @media (min-width: 640px) {
        .fi-main {
            padding-inline: 1.5rem !important;
            padding-block: 1.75rem !important;
        }
    }

    @media (min-width: 1024px) {
        .fi-main {
            padding-inline: 2rem !important;
            padding-block: 2rem !important;
        }
    }

    /* Prevent overflow on small screens */
    .fi-page,
    .fi-body,
    .fi-main-ctn {
        max-width: 100vw !important;
        overflow-x: hidden !important;
    }

    .fi-ta-ctn {
        max-width: 100% !important;
    }

    /* Dashboard composition shared by the admin and author panels. */
    .fi-page-content {
        width: 100%;
        max-width: 1480px;
        margin-inline: auto;
    }

    .fi-page-content > .fi-wi {
        margin-bottom: 1.35rem;
    }

    .dashboard-welcome {
        display: grid;
        gap: 1.5rem;
        padding: clamp(1.25rem, 2.5vw, 2rem);
        overflow: hidden;
        border: 1px solid var(--sage-border);
        border-radius: 1.125rem;
        background: radial-gradient(ellipse at top right, rgba(82, 130, 112, .11), transparent 44%), var(--sage-card);
        box-shadow: 0 2px 8px rgba(18, 35, 27, .035);
    }

    .dashboard-welcome__intro { max-width: 54rem; }
    .dashboard-welcome__date {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        margin-bottom: .75rem;
        color: var(--sage-text-muted);
        font-size: .8125rem;
        font-weight: 500;
        letter-spacing: .01em;
    }
    .dashboard-welcome__date > span {
        width: .4375rem;
        height: .4375rem;
        border-radius: 999px;
        background: var(--sage-primary);
        box-shadow: 0 0 0 3px rgba(82, 130, 112, .12);
    }
    .dashboard-welcome__intro h1 {
        margin: 0;
        color: var(--sage-text-main);
        font-size: clamp(1.5rem, 2vw, 1.75rem);
        font-weight: 700;
        line-height: 1.3;
        letter-spacing: -.035em;
    }
    .dashboard-welcome__intro h1 span { font-size: .82em; }
    .dashboard-welcome__intro p {
        margin: .55rem 0 0;
        color: var(--sage-text-muted);
        font-size: .9375rem;
        line-height: 1.65;
    }

    .dashboard-actions {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: .7rem;
    }
    .dashboard-actions--author { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    .dashboard-action {
        display: flex;
        min-width: 0;
        min-height: 4.5rem;
        align-items: center;
        gap: .75rem;
        padding: .75rem .875rem;
        border: 1px solid var(--sage-border);
        border-radius: .875rem;
        background: rgba(255, 255, 255, .58);
        color: var(--sage-text-main);
        text-decoration: none;
        transition: background-color .16s ease, border-color .16s ease, box-shadow .16s ease, transform .16s ease;
    }
    .dark .dashboard-action { background: rgba(255, 255, 255, .025); }
    .dashboard-action:hover {
        transform: translateY(-1px);
        border-color: rgba(82, 130, 112, .45);
        background: rgba(82, 130, 112, .075);
        box-shadow: 0 4px 12px rgba(31, 68, 52, .07);
    }
    .dashboard-action:focus-visible { outline: 2px solid var(--sage-primary); outline-offset: 2px; }
    .dashboard-action--primary {
        border-color: rgba(82, 130, 112, .32);
        background: rgba(82, 130, 112, .09);
    }
    .dashboard-action__icon {
        display: grid;
        width: 2.5rem;
        height: 2.5rem;
        flex: 0 0 2.5rem;
        place-items: center;
        border: 1px solid rgba(82, 130, 112, .15);
        border-radius: .75rem;
        background: rgba(82, 130, 112, .1);
        color: #528270;
    }
    .dark .dashboard-action__icon { color: #91b9a8; }
    .dashboard-action__icon svg { display: block; width: 1.25rem; height: 1.25rem; }
    .dashboard-action__copy { display: grid; min-width: 0; gap: .15rem; }
    .dashboard-action__copy strong {
        overflow: hidden;
        font-size: .875rem;
        font-weight: 600;
        line-height: 1.3;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .dashboard-action__copy small {
        overflow: hidden;
        color: var(--sage-text-muted);
        font-size: .75rem;
        line-height: 1.35;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .fi-wi-stats-overview { margin-block: .25rem 1.4rem; }
    .fi-wi-stats-overview > div { gap: .875rem !important; }
    .fi-wi-stats-overview-stat {
        min-height: 9rem;
        padding: 1.35rem 1.4rem !important;
        border-radius: 1rem !important;
    }
    .fi-wi-stats-overview-stat-label { font-size: .875rem !important; }
    .fi-wi-stats-overview-stat-value { font-size: clamp(1.875rem, 2.5vw, 2.125rem) !important; }
    .fi-wi-stats-overview-stat-label-ctn .fi-icon {
        width: 1.25rem !important;
        height: 1.25rem !important;
        min-width: 1.25rem !important;
        padding: .5rem !important;
        border-radius: .75rem !important;
    }
    .fi-wi-stats-overview-stat-description { font-size: .8125rem !important; }

    .fi-wi-table { margin-top: .25rem; }
    .fi-ta-ctn { border-radius: 1rem !important; }
    .fi-ta-header { padding: 1.25rem 1.5rem !important; }
    .fi-ta-header-heading { font-size: 1.125rem !important; }

    @media (max-width: 1100px) {
        .dashboard-actions { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .dashboard-actions--author { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }
    @media (max-width: 700px) {
        .dashboard-welcome { gap: 1.15rem; padding: 1.2rem; }
        .dashboard-actions, .dashboard-actions--author { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: .55rem; }
        .dashboard-action { min-height: 4.25rem; gap: .6rem; padding: .65rem; }
        .dashboard-action__icon { width: 2.25rem; height: 2.25rem; flex-basis: 2.25rem; }
        .dashboard-action__icon svg { width: 1.125rem; height: 1.125rem; }
    }
    @media (max-width: 430px) {
        .dashboard-actions, .dashboard-actions--author { grid-template-columns: 1fr; }
        .dashboard-action { min-height: 3.9rem; }
        .fi-ta-header { padding: 1rem !important; }
    }

    /* ========================================================
       8. SIDEBAR ACCOUNT FOOTER (ADMIN & AUTHOR)
       Explicit classes: the panel does not ship Tailwind utilities.
       ======================================================== */
    .np-sidebar-account {
        margin-top: auto;
        padding: 0.875rem 0.75rem 1rem;
        border-top: 1px solid var(--sage-border);
        background-color: var(--sage-surface);
    }

    .np-sidebar-account__profile {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        min-width: 0;
        padding-inline: 0.25rem;
    }

    .np-sidebar-account__avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 3.25rem;
        height: 3.25rem;
        flex: 0 0 3.25rem;
        overflow: hidden;
        border: 1px solid var(--sage-primary-border);
        border-radius: 9999px;
        background-color: var(--sage-primary-light);
    }

    .np-sidebar-account__avatar img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .np-sidebar-account__meta {
        display: flex;
        flex: 1 1 auto;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.3rem;
        min-width: 0;
    }

    .np-sidebar-account__name {
        max-width: 100%;
        margin: 0;
        overflow: hidden;
        color: var(--sage-text-main);
        font-size: 0.875rem;
        font-weight: 600;
        line-height: 1.3;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .np-sidebar-account__role {
        display: inline-flex;
        align-items: center;
        padding: 0.125rem 0.5rem;
        border-radius: 9999px;
        background-color: var(--sage-primary-light);
        color: #3e6657;
        font-size: 0.6875rem;
        font-weight: 600;
        letter-spacing: 0.01em;
        line-height: 1.4;
    }

    .dark .np-sidebar-account__role {
        color: #8ec2ae;
    }

    .np-sidebar-account__form {
        margin-top: 0.75rem;
    }

    .np-sidebar-logout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        min-height: 2.375rem;
        padding: 0.5rem 0.75rem;
        border: 1px solid #fecdd3;
        border-radius: 0.625rem;
        background-color: var(--sage-card);
        color: #e11d48;
        font: inherit;
        font-size: 0.8125rem;
        font-weight: 600;
        line-height: 1.2;
        cursor: pointer;
        transition: background-color 0.15s ease, border-color 0.15s ease, color 0.15s ease;
    }

    .np-sidebar-logout svg {
        width: 1.25rem;
        height: 1.25rem;
        flex: 0 0 1.25rem;
    }

    .np-sidebar-logout:hover {
        border-color: #e11d48;
        background-color: #e11d48;
        color: #ffffff;
    }

    .np-sidebar-logout:focus-visible {
        outline: 2px solid #e11d48;
        outline-offset: 2px;
    }

    .dark .np-sidebar-logout {
        border-color: #4c1d24;
        background-color: transparent;
        color: #fb7185;
    }

    .dark .np-sidebar-logout:hover {
        border-color: #e11d48;
        background-color: #e11d48;
        color: #ffffff;
    }

    /* ========================================================
       9. AUTHOR SETTINGS PAGE
       Explicit classes: the panel does not ship Tailwind utilities.
       ======================================================== */
    .np-settings-hero {
        overflow: hidden;
        border: 1px solid var(--sage-border);
        border-radius: 1rem;
        background-color: var(--sage-card);
        box-shadow: 0 1px 3px rgba(18, 35, 27, 0.04);
    }

    .np-settings-hero__cover {
        position: relative;
        height: 8.25rem;
        overflow: hidden;
        background-color: #eef2f0;
    }

    .dark .np-settings-hero__cover {
        background-color: #1b2621;
    }

    .np-settings-hero__cover > img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .np-settings-hero__shade {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(9, 20, 15, 0.5), rgba(9, 20, 15, 0) 55%);
        pointer-events: none;
    }

    .np-settings-hero__badge {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.3rem 0.7rem;
        border-radius: 9999px;
        background-color: rgba(82, 130, 112, 0.92);
        color: #ffffff;
        font-size: 0.6875rem;
        font-weight: 600;
        line-height: 1.3;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(4px);
    }

    .np-settings-hero__badge svg {
        width: 0.875rem;
        height: 0.875rem;
        flex: 0 0 0.875rem;
    }

    .np-settings-hero__body {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: space-between;
        gap: 0.875rem;
        margin-top: -2.25rem;
        padding: 0 1.25rem 1.125rem;
    }

    .np-settings-hero__identity {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        min-width: 0;
    }

    .np-settings-avatar {
        width: 4.5rem;
        height: 4.5rem;
        flex: 0 0 4.5rem;
        overflow: hidden;
        border: 4px solid var(--sage-card);
        border-radius: 9999px;
        background-color: var(--sage-primary-light);
        box-shadow: 0 4px 12px rgba(18, 35, 27, 0.14);
    }

    .np-settings-avatar img {
        display: block;
        width: 100%;
        height: 100%;
        border-radius: 9999px;
        object-fit: cover;
    }

    .np-settings-meta {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        min-width: 0;
    }

    .np-settings-meta__title-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.5rem;
    }

    .np-settings-meta__name {
        margin: 0;
        color: var(--sage-text-main);
        font-size: 1.25rem;
        font-weight: 700;
        line-height: 1.25;
        letter-spacing: -0.02em;
    }

    .np-settings-meta__badge {
        display: inline-flex;
        align-items: center;
        padding: 0.1875rem 0.5625rem;
        border: 1px solid var(--sage-primary-border);
        border-radius: 9999px;
        background-color: var(--sage-primary-light);
        color: #3e6657;
        font-size: 0.6875rem;
        font-weight: 600;
        line-height: 1.4;
    }

    .dark .np-settings-meta__badge {
        color: #8ec2ae;
    }

    .np-settings-meta__username {
        margin: 0;
        color: var(--sage-primary);
        font-size: 0.8125rem;
        font-weight: 600;
        line-height: 1.4;
    }

    .dark .np-settings-meta__username {
        color: #88b5a3;
    }

    .np-settings-public-link {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.4375rem 0.75rem;
        border: 1px solid var(--sage-primary-border);
        border-radius: 0.5rem;
        background-color: var(--sage-primary-light);
        color: #3e6657;
        font-size: 0.75rem;
        font-weight: 600;
        line-height: 1.3;
        text-decoration: none;
        white-space: nowrap;
        transition: background-color 0.15s ease, border-color 0.15s ease;
    }

    .np-settings-public-link:hover {
        border-color: rgba(82, 130, 112, 0.42);
        background-color: rgba(82, 130, 112, 0.14);
    }

    .np-settings-public-link svg {
        width: 0.875rem;
        height: 0.875rem;
        flex: 0 0 0.875rem;
    }

    .dark .np-settings-public-link {
        color: #8ec2ae;
    }

    @media (min-width: 640px) {
        .np-settings-hero__cover {
            height: 10.5rem;
        }

        .np-settings-hero__body {
            flex-direction: row;
            align-items: flex-end;
            gap: 1rem;
            margin-top: -2.75rem;
            padding: 0 1.5rem 1.25rem;
        }

        .np-settings-hero__identity {
            gap: 1rem;
        }

        .np-settings-avatar {
            width: 5.5rem;
            height: 5.5rem;
            flex-basis: 5.5rem;
        }

        .np-settings-meta__name {
            font-size: 1.5rem;
        }
    }

    /* Uploader styling scoped to the Author Settings form. */
    .np-settings-form .fi-fo-file-upload {
        width: 100%;
    }

    .np-settings-form .fi-fo-file-upload .filepond--root {
        margin: 0;
    }

    .np-settings-form .fi-fo-file-upload .filepond--panel-root {
        border: 1px dashed var(--sage-primary-border);
        border-radius: 0.75rem;
        background-color: var(--sage-primary-light);
    }

    .np-settings-form .fi-fo-file-upload .filepond--drop-label {
        min-height: 6.5rem;
        padding: 0.75rem;
    }

    .np-settings-form .fi-fo-file-upload .filepond--drop-label label {
        color: var(--sage-text-muted);
        font-size: 0.8125rem;
        font-weight: 500;
        line-height: 1.45;
    }

    .np-settings-form .fi-fo-file-upload .filepond--item-panel,
    .np-settings-form .fi-fo-file-upload .filepond--image-preview {
        border-radius: 0.75rem;
    }
</style>
