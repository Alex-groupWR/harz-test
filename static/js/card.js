'use strict';
$(document).ready(function () {
    //Slider
    // let slideIndex = 1;

    const setupEvents = (parent) => {
        const updateChooseColor = (chooseColor, colorItems) => {
            for (let i = 0; i < colorItems.length; i++) {
                colorItems[i].addEventListener("click", function () {
                    let current = chooseColor.getElementsByClassName("choose-color-item-active");
                    if (current.length > 0) {
                        current[0].className = current[0].className.replace(" choose-color-item-active", "");
                    }
                    this.className += " choose-color-item-active";
                });
            }
        };

        const screenWidth = window.screen.width;

        let dots = parent.querySelectorAll(".dot");
        let order = parent.querySelectorAll(".get-order");
        let flyingImg = parent.querySelectorAll("#img1");
        let wrapperSlides = parent.querySelectorAll(".wrapperSlides");

        let chooseWeight = parent.querySelector(".choose-weight");
        let chooseWeightItems = chooseWeight.querySelectorAll(".choose-weight-item");

        let chooseColor = parent.querySelector('.choose-color-basket');
        if (chooseColor) {
            let chooseColorItems = chooseColor ? chooseColor.querySelectorAll(".choose-color-item") : [];
            updateChooseColor(chooseColor, chooseColorItems)
        }

        let chooseColorMobile = parent.querySelector('.choose-color-basket-mobile');
        if (chooseColorMobile) {
            let chooseColorItemsMobile = chooseColorMobile ? chooseColorMobile.querySelectorAll(".choose-color-item") : [];
            updateChooseColor(chooseColorMobile, chooseColorItemsMobile)
        }

        let basket = document.querySelectorAll(".desktop-nav-collapse .nav-item.basket");
        if (screenWidth < 767) {
            basket = document.querySelectorAll(".nav-mobile-page .nav-item.basket");
        }

        const plusElement = parent.querySelector('.plus'),
            minusElement = parent.querySelector('.minus'),
            addProductblock = parent.querySelector('.add-product'),
            priceElement = parent.querySelector('.price');

        const onPlusClick = () => {
            updatePrice(1);
        }
        const onMinusClick = () => {
            updatePrice(-1);
        }
        const updatePrice = (delta = 0) => {
            if (!priceElement || !addProductblock) return;
            let newValue = +priceElement.value + delta;

            if (newValue === 0) {
                addProductblock.classList.remove('active');
                priceElement.value = '1';
            } else {
                priceElement.value = `${newValue}`;
                addProductblock.classList.add('active');
            }
        }

        if (plusElement) {
            plusElement.addEventListener("click", onPlusClick);
        }
        if (minusElement) {
            minusElement.addEventListener("click", onMinusClick);
        }
        updatePrice();

        for (let i = 0; i < chooseWeightItems.length; i++) {
            chooseWeightItems[i].addEventListener("click", function () {
                let current = chooseWeight.getElementsByClassName("choose-weight-item-active");
                if (current.length > 0) {
                    current[0].className = current[0].className.replace(" choose-weight-item-active", "");
                }
                this.className += " choose-weight-item-active";
            });
        }

        dots.forEach(dot => {
            $(dot).mouseenter(function () {
                let n = $(this).data("slide-ref");
                let parent = $(this).closest(".slideshow-container")[0]
                showSlides(parent, n);
            });

            $(dot).mouseleave(function () {
                let parent = $(this).closest(".slideshow-container")[0]
                showSlides(parent, 1);
            });
        });

        $(order).click(function () {
            (this).innerHTML = "В корзине";
            const clone = $(flyingImg).clone().appendTo(wrapperSlides);
            const targetX = $(basket).offset()['left'] + $(basket).width() - $(clone).offset()['left'] - 5;
            const targetY = $(basket).offset()['top'] - $(clone).offset()['top'] + 100;

            clone.css({'position': 'absolute', 'top': '0', 'left': '0', 'z-index': '100'});

            clone.animate({
                top: targetY,
                left: targetX,
                opacity: 0.4,
                width: 40,
            }, 1000, function () {
                $(this).remove();
            });
        });

    }

    const setupCard = (cardNode) => {
        let slideShow = cardNode.querySelector(".slideshow-container");
        if (slideShow) {
            createDots(slideShow);
            showSlides(slideShow, 1);
        }
        setupEvents(cardNode);
    };

    let cards = document.querySelectorAll(".card-product");
    if (cards.length > 0) {
        cards.forEach(card => setupCard(card));
    }
    let desktopCards = document.querySelectorAll(".choose-block-product");
    if (desktopCards.length > 0) {
        desktopCards.forEach(desktopCard => setupCard(desktopCard));
    }

    let mobileCards = document.querySelectorAll(".choose-parameters-mobile");
    if (mobileCards.length > 0) {
        mobileCards.forEach(mobileCard => setupCard(mobileCard));
    }
    let basketCards = document.querySelectorAll(".basket-products-elem");
    if (basketCards.length > 0) {
        basketCards.forEach(basketCard => setupCard(basketCard));
    }


    // showSlides(slideIndex);

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function createDots(parent) {
        let slides = parent.querySelectorAll(".wrapperSlides");
        let dotsContainer = parent.querySelector(".dots-container");
        if (slides <= 0) return;
        if (!dotsContainer) return;

        for (let i = 0; i < slides.length; i++) {
            let dot = document.createElement("div");
            $(dot).addClass('dot');
            $(dot).css({"width": `100 / ${slides.length}% `});
            $(dot).data("slide-ref", i + 1);
            $(dotsContainer).append(dot);
        }
    }

    function showSlides(parent, n) {
        let i;
        let slideIndex = n;
        let slides = parent.querySelectorAll(".wrapperSlides");
        let dots = parent.querySelectorAll(".dot");

        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
            // slides[i].className += " fade";
            dots[i].className = dots[i].className.replace(" active", "");
        }
        // for (i = 0; i < dots.length; i++) {

        // }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
        // dots[slideIndex - 1].className.replace(" fade", "");
    }
    const sliderElement = $('.slider-documents');
    if (sliderElement.children().length) {
        $('.slider-documents').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 2000,
            dots: true,
            responsive: [
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 3
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
                        slidesToShow: 1,
                        centerMode: true,
                        dots: true,
                        centerPadding: '80px'
                    }
                },
                {
                    breakpoint: 321,
                    settings: {
                        slidesToShow: 1,
                        centerMode: true,
                        dots: true,
                        centerPadding: '60px'
                    }
                }
            ]
        });
    }

    $('.slider-printers').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        infinite: true,
        dots: true,
        responsive: [
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true
                }
            },
            {
                breakpoint: 770,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: true
                }
            },
            {
                breakpoint: 540,
                settings: {
                    slidesToShow: 1,
                    centerMode: true,
                    dots: true,
                    centerPadding: '60px'
                }
            }
        ]
    });
    $('.slider-production').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 2000,
        dots: true,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    dots: true,
                    arrows: false
                }
            }
        ]
    });
    $('.slider-comments').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 2000,
        dots: true,
        responsive: [
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 770,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 540,
                settings: {
                    slidesToShow: 1,
                    dots: true,
                    arrows: false
                }
            },
            {
                breakpoint: 321,
                settings: {
                    slidesToShow: 1,
                    arrows: false,
                    dots: true
                }
            }
        ]
    });
    $('.slider-products').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 2000,
        dots: true,
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
                    slidesToShow: 1,
                    centerMode: true,
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
