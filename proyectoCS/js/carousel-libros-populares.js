$(document).ready(function () {

    $('.deals-carousel-pop').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
        arrows: false,
        responsive: [
            { breakpoint: 992, settings: { slidesToShow: 3 } },
            { breakpoint: 768, settings: { slidesToShow: 2 } },
            { breakpoint: 576, settings: { slidesToShow: 1 } }
        ]
    });

    // Botón previo
    $('.deals-prev-pop').click(function () {
        $('.deals-carousel-pop').slick('slickPrev');
    });

    // Botón siguiente
    $('.deals-next-pop').click(function () {
        $('.deals-carousel-pop').slick('slickNext');
    });

});
