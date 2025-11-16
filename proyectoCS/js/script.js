(function ($) {

  "use strict";

  /* =========================================================
     TABS (si existen)
  ============================================================ */
  const tabs = document.querySelectorAll('[data-tab-target]');
  const tabContents = document.querySelectorAll('[data-tab-content]');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const target = document.querySelector(tab.dataset.tabTarget);

      tabContents.forEach(c => c.classList.remove('active'));
      tabs.forEach(t => t.classList.remove('active'));

      tab.classList.add('active');
      target.classList.add('active');
    });
  });


  /* =========================================================
     MENÚ RESPONSIVE (hamburguesa)
  ============================================================ */
  const hamburger = document.querySelector(".hamburger");
  const navMenu = document.querySelector(".menu-list");

  if (hamburger) {
    hamburger.addEventListener("click", () => {
      hamburger.classList.toggle("active");
      navMenu.classList.toggle("responsive");
    });
  }

  const navLink = document.querySelectorAll(".nav-link");

  navLink.forEach(n => n.addEventListener("click", () => {
    hamburger.classList.remove("active");
    navMenu.classList.remove("responsive");
  }));


  /* =========================================================
     HEADER FIXED AL HACER SCROLL
  ============================================================ */
  const initScrollNav = () => {
    const scroll = $(window).scrollTop();
    if (scroll >= 200) $("#header").addClass("fixed-top");
    else $("#header").removeClass("fixed-top");
  };

  $(window).scroll(() => initScrollNav());


  /* =========================================================
     DOCUMENT READY
  ============================================================ */
  $(document).ready(function () {

    initScrollNav();

    /* =============================
       Chocolat (solo si existe)
    ============================== */
    if (typeof Chocolat !== "undefined") {
      Chocolat(document.querySelectorAll('.image-link'), {
        imageSize: 'contain',
        loop: true,
      });
    }

    /* =============================
       Buscador en Header
    ============================== */
    $('#header-wrap').on('click', '.search-toggle', function (e) {
      const selector = $(this).data('selector');
      $(selector).toggleClass('show').find('.search-input').focus();
      $(this).toggleClass('active');
      e.preventDefault();
    });

    $(document).on('click touchstart', function (e) {
      if (!$(e.target).is('.search-toggle, .search-toggle *, #header-wrap, #header-wrap *')) {
        $('.search-toggle').removeClass('active');
        $('#header-wrap').removeClass('show');
      }
    });


    /* =========================================================
       SLIDER PRINCIPAL (billboard) 
    ============================================================ */
    if ($.fn.slick) {
      $('.main-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        fade: true,
        infinite: true,
        dots: true,
        autoplay: false,
        autoplaySpeed: 4000,
        prevArrow: $('.prev'),
        nextArrow: $('.next'),
      });
    }


    /* =========================================================
       PRODUCT GRID (populares)
    ============================================================ */
    if ($.fn.slick) {
      $('.product-grid').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        autoplay: false,
        responsive: [
          { breakpoint: 1400, settings: { slidesToShow: 3 } },
          { breakpoint: 999, settings: { slidesToShow: 2 } },
          { breakpoint: 660, settings: { slidesToShow: 1 } }
        ]
      });
    }


    /* =========================================================
       CARRUSEL MANUAL — LIBROS DESTACADOS
    ============================================================ */
    const dealsWrapper = document.querySelector('.deals-wrapper');
    if (dealsWrapper) {
      const dealsCarousel = dealsWrapper.querySelector('.deals-carousel');
      const dealsPrev = dealsWrapper.querySelector('.deals-prev');
      const dealsNext = dealsWrapper.querySelector('.deals-next');
      const scrollAmount = 300;

      if (dealsPrev) {
        dealsPrev.addEventListener("click", () => {
          dealsCarousel.scrollBy({ left: -scrollAmount, behavior: "smooth" });
        });
      }

      if (dealsNext) {
        dealsNext.addEventListener("click", () => {
          dealsCarousel.scrollBy({ left: scrollAmount, behavior: "smooth" });
        });
      }
    }

    /* =========================================================
       AOS (si existe)
    ============================================================ */
    if (typeof AOS !== "undefined") {
      AOS.init({
        duration: 1200,
        once: true,
      });
    }

    /* =========================================================
       MENÚ DESPLEGABLE PRINCIPAL (stellarNav)
    ============================================================ */
    if ($.fn.stellarNav) {
      $('.stellarnav').stellarNav({
        theme: 'plain',
        closingDelay: 250,
      });
    }

  }); // end document ready

})(jQuery);
