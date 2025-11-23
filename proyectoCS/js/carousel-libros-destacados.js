document.addEventListener('DOMContentLoaded', function() {
  const dealsWrapper = document.querySelector('.deals-wrapper');
  if (!dealsWrapper) return;

  const dealsCarousel = dealsWrapper.querySelector('.deals-carousel');
  const dealsPrev = dealsWrapper.querySelector('.deals-prev');
  const dealsNext = dealsWrapper.querySelector('.deals-next');
  const scrollAmount = 300;

  if (dealsPrev) {
    dealsPrev.addEventListener('click', () => {
      dealsCarousel.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });
  }

  if (dealsNext) {
    dealsNext.addEventListener('click', () => {
      dealsCarousel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });
  }
});
