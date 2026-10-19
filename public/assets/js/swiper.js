document.addEventListener('DOMContentLoaded', function () {
  const swiperElement = document.querySelector('.mySwiper');
  if (!swiperElement) return;

  const swiper = new Swiper('.mySwiper', {
    slidesPerView: 1.2,
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
});
