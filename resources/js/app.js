import './bootstrap';

// Theme management (Light / Dark Mode)
window.toggleTheme = function () {
    const isDark = document.documentElement.classList.toggle('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    updateThemeIcons();
};

function updateThemeIcons() {
    const isDark = document.documentElement.classList.contains('dark');
    document.querySelectorAll('.theme-toggle-icon-sun').forEach(el => {
        el.classList.toggle('hidden', !isDark);
    });
    document.querySelectorAll('.theme-toggle-icon-moon').forEach(el => {
        el.classList.toggle('hidden', isDark);
    });
}

// Initial theme check on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    updateThemeIcons();

    // Mobile menu toggle
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Swiper safe initialization
    if (typeof Swiper !== 'undefined' && document.querySelector('.mySwiper')) {
        new Swiper('.mySwiper', {
            slidesPerView: 1.1,
            spaceBetween: 16,
            centeredSlides: true,
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 1.5,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 2.2,
                    spaceBetween: 24,
                },
            },
        });
    }
});
