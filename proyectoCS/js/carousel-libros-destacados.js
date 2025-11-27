// js/carousel-libros-destacados.js
document.addEventListener('DOMContentLoaded', function () {
  const scrollAmount = 300;

  // Tomar TODOS los carruseles (Destacados, Populares, etc.)
  const wrappers = document.querySelectorAll('.deals-wrapper');

  wrappers.forEach(wrapper => {
    const dealsCarousel = wrapper.querySelector('.deals-carousel');
    const dealsPrev = wrapper.querySelector('.deals-prev');
    const dealsNext = wrapper.querySelector('.deals-next');

    if (!dealsCarousel) return;

    if (dealsPrev) {
      dealsPrev.addEventListener('click', () => {
        dealsCarousel.scrollBy({
          left: -scrollAmount,
          behavior: 'smooth'
        });
      });
    }

    if (dealsNext) {
      dealsNext.addEventListener('click', () => {
        dealsCarousel.scrollBy({
          left: scrollAmount,
          behavior: 'smooth'
        });
      });
    }
  });
});
