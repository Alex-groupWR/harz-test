window.harzlabs = {

    // открытие|закрытие подложки для модального окна .fog
    fogIsOpen: false,

    showFog: function (className, x, y) {
        if (className) {
            className = (className[0] === '.') ? className.slice(1) : className;
        } else {
            className = '';
        }


        var openClass = this.fogIsOpen ? '' : ' fog--open';
        $('.fog').css({left: x, top: y}).attr('class', 'fog ' + className + openClass);
    },

    hideFog: function () {
        $('.fog').attr('class', 'fog');
    },

    // убираем|показываем скролл
    setWindowOvh: function () {
        $('body').css({overflow: 'hidden'});
    },

    unsetWindowOvh: function () {
        $('body').attr('style', '');
    },

    //Модальные окна
    modalIsShown: false,

    showModal: function (className) {
        var _this = this;
        className = (className[0] === '.') ? className : '.' + className;
        $('.modal').hide();
        $(className).show();
        setTimeout(function () {
            _this.setWindowOvh();
            $('.modals').fadeIn();

            _this.modalIsShown = true;
        }, 200);
    },

    hideModal: function () {
        var _this = this;
        $('.modals').fadeOut(true, function () {
            $('.modal').hide();
            _this.unsetWindowOvh();
            _this.modalIsShown = false;
        });
    },

    //Заменяем svg картинки на инлайн svg
    replaceSvgImages: function () {
        jQuery('img.svg').each(function () {
            var $img = jQuery(this);
            var imgID = $img.attr('id');
            var imgClass = $img.attr('class');
            var imgURL = $img.attr('src');

            jQuery.get(imgURL, function (data) {
                // Get the SVG tag, ignore the rest
                var $svg = jQuery(data).find('svg');

                // Add replaced image's ID to the new SVG
                if (typeof imgID !== 'undefined') {
                    $svg = $svg.attr('id', imgID);
                }
                // Add replaced image's classes to the new SVG
                if (typeof imgClass !== 'undefined') {
                    $svg = $svg.attr('class', imgClass + ' replaced-svg');
                }

                // Remove any invalid XML tags as per http://validator.w3.org
                $svg = $svg.removeAttr('xmlns:a');

                // Check if the viewport is set, if the viewport is not set the SVG wont't scale.
                if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
                    $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
                }

                // Replace image with new SVG
                $img.replaceWith($svg);

            }, 'xml');

        });
    },

    //ресайз textarea
    autosizeTextarea: function () {
        var text = $('.js-autosize');

        text.each(function () {
            $(this).attr('rows', 1);
            resize($(this));
        });

        text.on('input', function () {
            resize($(this));
        });

        function resize($text) {
            $text.css('height', 'auto');
            $text.css('height', $text[0].scrollHeight + 'px');
        }
    },

    // open/hide modal nav
    toggleMobileNav: function () {
        $('.header__navigation').toggleClass('header__navigation--visible');
        $('.burger--mobile').toggleClass('burger--open');
        $('body').toggleClass('body-ovh');
    },

    resizeWindow: function () {
        $('.list--toggle').attr('style', '');
        $('.footer__desc--arrow').removeClass('footer__desc--active');
    },

    toggleFilter: function (elem) {
        $('.filters__body', $(elem).closest('.filters__tab')).slideToggle();
        $('.filters__title', $(elem).closest('.filters__tab')).toggleClass('filters__title--active');
    },

    initFilterSlider: function () {
        var $slider = $('#slider-range')
        if ($slider.length) {
            $slider.slider({
                range: true,
                min: 0,
                max: 500,
                values: [75, 300],
                slide: function (event, ui) {
                    $('.ui-slider span:nth-child(2)').attr('data-value', ui.values[0] + ' P');
                    $('.ui-slider span:nth-child(3)').attr('data-value', ui.values[1] + ' P');
                    $('.js-slider-from').val($("#slider-range").slider("values", 0));
                    $('.js-slider-to').val($("#slider-range").slider("values", 1));
                }
            });
            $('.js-slider-from').val($("#slider-range").slider("values", 0));
            $('.js-slider-to').val($("#slider-range").slider("values", 1));
            $('.ui-slider span:nth-child(2)').attr('data-value', $("#slider-range").slider("values", 0) + ' P');
            $('.ui-slider span:nth-child(3)').attr('data-value', $("#slider-range").slider("values", 1) + ' P');
        }
    },

    showSide: function (sideNumber) {
        $('.checkout__side').removeClass('checkout__side--active');
        $('.checkout__side--' + sideNumber).addClass('checkout__side--active');
    },

    openSearch: function () {
        $('.search').slideDown();
    },

    closeSearch: function () {
        $('.search').slideUp();
    },

    toggleSearch: function () {
        $('.search').slideToggle();
    },

    setComparsionWidth: function () {
        if($('.comparison').length) {
            $('.comparison .features, .comparison__head').css('min-width', ($('.product').width() + 20) * $('.product').length);
        }
    },

    // бинд событий
    bind: function () {
        var _this = this;

        $('.js-toggle-search').on('click', function () {
            _this.toggleSearch();
            return false;
        });

        $('.js-open-search').on('click', function () {
            _this.openSearch();
            return false;
        });

        $('.js-close-search').on('click', function () {
            _this.closeSearch();
            return false;
        });

        $('.js-show-modal').on('click', function (e) {
            var modalClassName = $(this).attr('data-modal');
            var fogClassName = $(this).attr('data-fog');

            var coords = {
                x: e.clientX,
                y: e.clientY
            };

            _this.showFog(fogClassName, coords.x, coords.y);

            _this.showModal(modalClassName);

            return false;
        });

        $('.js-hide-modal').on('click', function () {
            _this.hideFog();
            _this.hideModal();
            return false;
        });

        $(document).keyup(function (e) {
            if (e.key === "Escape") { // escape key maps to keycode `27`
                if (_this.modalIsShown) {
                    _this.hideFog();
                    _this.hideModal();
                }
            }
        });

        $('.form__input input, .form__input textarea').on('focus', function () {
            $(this).closest('.form__input').addClass('form__input--focus form__input--filled');
        }).on('blur', function () {
            if ($.trim(this.value) === '') {
                $(this).closest('.form__input').removeClass('form__input--filled');
                this.value = '';
            }
            $(this).closest('.form__input').removeClass('form__input--focus');
        });

        $('input[type="text"]').each(function(index, obj){
            if ($.trim(obj.value) !== '') {
                $(obj).closest('.form__input').addClass('form__input--focus form__input--filled');
            }
        });

        $('.js-open-mobile-nav').on('click', function () {
            _this.toggleMobileNav();
            return false;
        });

        $('.js-filters-tab').on('click', function () {
            _this.toggleFilter(this);
            return false;
        });

        $(window).on('resize', function () {
            _this.resizeWindow();
            _this.setComparsionWidth();
        }).trigger('resize');

        $('.checkout__input input').on('focus', function () {
            $(this).closest('.checkout__input').addClass('checkout__input--focus');
        }).on('blur', function () {
            $(this).closest('.checkout__input').removeClass('checkout__input--focus');
        });

        $('.search__input input').on('focus', function () {
            $(this).closest('.search__input').addClass('search__input--focus');
        }).on('blur', function () {
            $(this).closest('.search__input').removeClass('search__input--focus');
        });

        $('.burger').on('click', function () {
            $(this).toggleClass('burger--open');
            $('.header__navigation').toggleClass('header__navigation--visible');
            $('body').toggleClass('ovh');
            return false
        });

        $('.js-show-side').on('click', function () {
            var sideNumber = $(this).attr('data-side');
            _this.showSide(sideNumber);
            $(this).siblings('input[name="PERSON_TYPE_ID"]').val(sideNumber);
            $(this).siblings('input[name="DELIVERY_TYPE"]').val(sideNumber);
            if ($(this).hasClass('js-change-active')) {
                $('.checkout__button', $(this).closest('.checkout__box')).removeClass('checkout__button--active');
                $(this).addClass('checkout__button--active');
            }
            return false;
        });

        $('.js-toggle-block').on('click', function () {
            $(this).attr('checked', !$(this).attr('checked'));
            var $block = $($(this).attr('data-block'));
            $block.slideToggle();
        });

        $('.js-change-delivery').on('click', function () {
            $('#delivery_id').val($(this).data('dlv'));
            if(typeof $(this).data('side') !== 'undefined') {
                $('#delivery_type').val($(this).data('side'));
            }
        });

        $('.js-go-checkout').on('click', function(e){
            e.preventDefault();
            let form = $(this).closest("form");
            //$(form).find('input[name="save"]').val('Y');
            $(form).submit();
        });

        $('.js-set-color').on('click', function () {
            var $parent = $(this).closest('.det__colors');
            var value = $(this).attr('data-value');

            $('.det__color', $parent).removeClass('det__color--active');
            $(this).addClass('det__color--active');
            $('input', $parent).val(value);
            return false;
        });

        $('.js-toggle-footer-list').on('click', function () {
            $('.list--toggle', $(this).closest('.footer__box')).slideToggle();
            $('.footer__desc', $(this).closest('.footer__box')).toggleClass('footer__desc--active');
            return false;
        });


        if( $('.payment__reviews').length) {
            $('.payment__reviews').slick({
                dots: false,
                arrows: false
            });

            $('.payment__arrow--prev').on('click', function () {
                $('.payment__reviews').slick('slickPrev');
                return false;
            });

            $('.payment__arrow--next').on('click', function () {
                $('.payment__reviews').slick('slickNext');
                return false;
            });
        }

        $('.det__thumb').on('click', function () {
            if ($(this).hasClass('det__thumb--active')) return false;
            var bigImageUrl = $(this).attr('href');

            $('.det__thumb').removeClass('det__thumb--active');
            $(this).addClass('det__thumb--active');

            $('.det__image img').attr('src', bigImageUrl);
            return false;
        });

        $('.manufacturing__link').on('click', function () {
            var tabId = $(this).attr('data-tab');
            $('.manufacturing__link').removeClass('manufacturing__link--active');
            $(this).addClass('manufacturing__link--active');
            $('.manufacturing__content').removeClass('manufacturing__content--active');
            $('.manufacturing__content--' + tabId).addClass('manufacturing__content--active');
            return false;
        })
    },

    init: function () {
        // установка ширины блока бля страницы сравнения
        //this.setComparsionWidth();
        this.initFilterSlider();
        this.autosizeTextarea();
        this.replaceSvgImages();
        this.bind();
    }
};

function customDropdown()
{
    $('.custom-dropdown').on('click', function(e) {
        e.preventDefault();
        $(this).toggleClass('active');
        return false;
    });

    $('.custom-dropdown ul li').on('click', function() {
        let current = $(this).clone();
        $(this).parent().siblings('.current').html('').append(current);
        //$(this).closest('.custom-dropdown').removeClass('active');
    });
}

$(document).ready(function () {
    harzlabs.init();
    customDropdown();
});

$(window).on('load', function () {

});