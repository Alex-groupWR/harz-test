$(document).ready(function () {
    $('.slider-recently').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 2000,
        dots: true,
        centerPadding: '0px',
        responsive: [
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 770,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 540,
                settings: {
                    slidesToShow: 2,
                    dots: true,
                    centerPadding: '120px',
                    arrows: false
                }
            },
            {
                breakpoint: 320,
                settings: {
                    slidesToShow: 1,
                    centerMode: true,
                    dots: true,
                    centerPadding: '70px',
                    arrows: false
                }
            }
        ]
    });
});
