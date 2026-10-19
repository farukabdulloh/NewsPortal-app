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
    body, * {
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif !important;
    }

    /* Soft Sage Green Accents & Clean Modern Surfaces */
    :root {
        --sage-primary: #528270;
        --sage-primary-hover: #416a5a;
        --sage-surface: #f8faf9;
        --sage-border: #dbe5e0;
    }

    .dark {
        --sage-surface: #0f1412;
        --sage-border: #223029;
    }

    /* Simple auth card clean styling */
    .fi-simple-main-ctn {
        background-color: #f8faf9 !important;
    }
    .dark .fi-simple-main-ctn {
        background-color: #0f1412 !important;
    }

    .fi-simple-main {
        border-radius: 1rem !important;
        box-shadow: 0 4px 20px -2px rgba(82, 130, 112, 0.08), 0 2px 6px -1px rgba(0, 0, 0, 0.04) !important;
        border: 1px solid #e2ece7 !important;
    }
    .dark .fi-simple-main {
        background-color: #141c18 !important;
        border-color: #24352d !important;
        box-shadow: 0 4px 25px -2px rgba(0, 0, 0, 0.4) !important;
    }

    /* Primary buttons */
    .fi-btn-color-primary {
        background-color: #528270 !important;
        border-color: #528270 !important;
    }
    .fi-btn-color-primary:hover {
        background-color: #416a5a !important;
        border-color: #416a5a !important;
    }

    /* Table & Card subtle borders */
    .fi-ta-ctn {
        border-radius: 0.875rem !important;
        border-color: #e2ece7 !important;
    }
    .dark .fi-ta-ctn {
        border-color: #24352d !important;
    }
</style>
