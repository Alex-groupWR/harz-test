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

    $(document).mouseup(function (e){
        let div = $(".custom-dropdown.active");
        if (!div.is(e.target)
            && div.has(e.target).length === 0) {
            div.removeClass('active');
        }
    });
}

var hasWebP = (function() {
    // some small (2x1 px) test images for each feature
    var images = {
        basic: "data:image/webp;base64,UklGRjIAAABXRUJQVlA4ICYAAACyAgCdASoCAAEALmk0mk0iIiIiIgBoSygABc6zbAAA/v56QAAAAA==",
        lossless: "data:image/webp;base64,UklGRh4AAABXRUJQVlA4TBEAAAAvAQAAAAfQ//73v/+BiOh/AAA="
    };

    return function(feature) {
        var deferred = $.Deferred();

        $("<img>").on("load", function() {
            // the images should have these dimensions
            if(this.width === 2 && this.height === 1) {
                deferred.resolve();
            } else {
                deferred.reject();
            }
        }).on("error", function() {
            deferred.reject();
        }).attr("src", images[feature || "basic"]);

        return deferred.promise();
    }
})();

function imgReplace() {
    let images = $('.img-replace');

    hasWebP().then(function() {
        console.log("Basic WebP available");
    }, function () {
        images.each(function () {
            let img = $(this),
                data = img.data();
            console.log(img.prop("tagName"));
            if(img.prop("tagName") == 'IMG'){
                img.attr('src',data.orig);
            } else {
                img.css('background-image', 'url(' + data.orig + ')');
            }
        });
    });
}




$(document).ready(function () {
    let lang = $('#cookieLang').val();
    harzlabs.init();
    customDropdown();
    imgReplace();

    let option = {};

    if (lang == 'ru') {
        option = {
            title: 'Конфиденциальность и файлы Cookie',
            message: 'Файлы Cookie позволяют Вам использовать корзину покупок и персонализировать опыт на сайте, показывают нам, какие страницы сайта были посещены, помогают измерять эффективность рекламы и поисковых запросов в Интернете, а также дают нам представление о поведении пользователей, чтобы мы могли улучшать наш сайт и продукты.',
            moreInfoLabel: 'Подробнее',
            acceptBtnLabel: 'Принять Cookie',
            advancedBtnLabel: 'Настроить Cookie',
            fixedCookieTypeLabel: 'Необходимые',
            cookieTypesTitle: 'Выберите куки, чтобы принять:',
            cookieTypes: [
                {
                    type: 'Аналитика',
                    value: 'analytics',
                },
                {
                    type: 'Настройки сайта',
                    value: 'preferences',
                },
                {
                    type: 'Маркетинг',
                    value: 'marketing',
                }
            ]
        };
    }

    $('body').ihavecookies(option);


});

/**
$(window).on('load', function () {
    let product = document.querySelectorAll('.product');
    if(product){
        product.forEach(function(item){
            let btnColorsList = item.querySelectorAll('.product__colors');
            let imageArea = item.querySelector('.img-replace');
            let moreImages = item.querySelectorAll('.offers-image');

            btnColorsList.forEach(function(item1){
                item1.addEventListener('click', function(e){
                    let btn = e.target;
                    if(btn.dataset.id){
                        let id = btn.dataset.id;
                        moreImages.forEach((item2)=>{
                            if(item2.dataset.id == id){
                                imageArea.style.backgroundImage = `url('${item2.dataset.src}')`;
                            }
                        })
                    }
                })
            })
        })
    }
});*/

(function (window) {

    if (!!window.JCCatalogProductSubscribe)
    {
        return;
    }

    var subscribeButton = function(params)
    {
        subscribeButton.superclass.constructor.apply(this, arguments);
        this.nameNode = BX.create('span', {
            props : { id : this.id },
            style: typeof(params.style) === 'object' ? params.style : {},
            text: params.text
        });
        this.buttonNode = BX.create('span', {
            attrs: { className: params.className },
            style: { marginBottom: '0', borderBottom: '0 none transparent' },
            children: [this.nameNode],
            events : this.contextEvents
        });
        if (BX.browser.IsIE())
        {
            this.buttonNode.setAttribute("hideFocus", "hidefocus");
        }
    };
    BX.extend(subscribeButton, BX.PopupWindowButton);

    window.JCCatalogProductSubscribe = function(params)
    {
        this.buttonId = params.buttonId;
        this.buttonClass = params.buttonClass;
        this.jsObject = params.jsObject;
        this.ajaxUrl = '/bitrix/components/bitrix/catalog.product.subscribe/ajax.php';
        this.alreadySubscribed = params.alreadySubscribed;
        this.urlListSubscriptions = params.urlListSubscriptions;
        this.listOldItemId = {};

        this.elemButtonSubscribe = null;
        this.elemPopupWin = null;
        this.defaultButtonClass = 'bx-catalog-subscribe-button';

        this._elemButtonSubscribeClickHandler = BX.delegate(this.subscribe, this);
        this._elemHiddenClickHandler = BX.delegate(this.checkSubscribe, this);

        BX.ready(BX.delegate(this.init,this));
    };

    window.JCCatalogProductSubscribe.prototype.init = function()
    {
        if (!!this.buttonId)
        {
            this.elemButtonSubscribe = BX(this.buttonId);
            this.elemHiddenSubscribe = BX(this.buttonId+'_hidden');
        }

        if (!!this.elemButtonSubscribe)
        {
            BX.bind(this.elemButtonSubscribe, 'click', this._elemButtonSubscribeClickHandler);
        }

        if (!!this.elemHiddenSubscribe)
        {
            BX.bind(this.elemHiddenSubscribe, 'click', this._elemHiddenClickHandler);
        }

        this.setButton(this.alreadySubscribed);
    };

    window.JCCatalogProductSubscribe.prototype.checkSubscribe = function()
    {
        if(!this.elemHiddenSubscribe || !this.elemButtonSubscribe) return;

        if(this.listOldItemId.hasOwnProperty(this.elemButtonSubscribe.dataset.item))
        {
            this.setButton(true);
        }
        else
        {
            BX.ajax({
                method: 'POST',
                dataType: 'json',
                url: this.ajaxUrl,
                data: {
                    sessid: BX.bitrix_sessid(),
                    checkSubscribe: 'Y',
                    itemId: this.elemButtonSubscribe.dataset.item
                },
                onsuccess: BX.delegate(function (result) {
                    if(result.subscribe)
                    {
                        this.setButton(true);
                        this.listOldItemId[this.elemButtonSubscribe.dataset.item] = true;
                    }
                    else
                    {
                        this.setButton(false);
                    }
                }, this)
            });
        }
    };

    window.JCCatalogProductSubscribe.prototype.subscribe = function()
    {
        this.elemButtonSubscribe = BX.proxy_context;
        if(!this.elemButtonSubscribe) return false;

        BX.ajax({
            method: 'POST',
            dataType: 'json',
            url: this.ajaxUrl,
            data: {
                sessid: BX.bitrix_sessid(),
                subscribe: 'Y',
                itemId: this.elemButtonSubscribe.dataset.item,
                siteId: BX.message('SITE_ID')
            },
            onsuccess: BX.delegate(function (result) {
                if(result.success)
                {
                    this.createSuccessPopup(result);
                    this.setButton(true);
                    this.listOldItemId[this.elemButtonSubscribe.dataset.item] = true;
                }
                else if(result.contactFormSubmit)
                {
                    this.initPopupWindow();
                    this.elemPopupWin.setTitleBar(BX.message('CPST_SUBSCRIBE_POPUP_TITLE'));
                    var form = this.createContentForPopup(result);
                    this.elemPopupWin.setContent(form);
                    this.elemPopupWin.setButtons([
                        new subscribeButton({
                            text: BX.message('CPST_SUBSCRIBE_BUTTON_NAME_POPUP'),
                            className : 'btn btn-primary',
                            events: {
                                click : BX.delegate(function() {
                                    if(!this.validateContactField(result.contactTypeData))
                                    {
                                        return false;
                                    }
                                    BX.ajax.submitAjax(form, {
                                        method : 'POST',
                                        url: this.ajaxUrl,
                                        processData : true,
                                        onsuccess: BX.delegate(function (resultForm) {
                                            resultForm = BX.parseJSON(resultForm, {});
                                            if(resultForm.success)
                                            {
                                                this.createSuccessPopup(resultForm);
                                                this.setButton(true);
                                                this.listOldItemId[this.elemButtonSubscribe.dataset.item] = true;
                                            }
                                            else if(resultForm.error)
                                            {
                                                if(resultForm.hasOwnProperty('setButton'))
                                                {
                                                    this.listOldItemId[this.elemButtonSubscribe.dataset.item] = true;
                                                    this.setButton(true);
                                                }
                                                var errorMessage = resultForm.message;
                                                if(resultForm.hasOwnProperty('typeName'))
                                                {
                                                    errorMessage = resultForm.message.replace('USER_CONTACT',
                                                        resultForm.typeName);
                                                }
                                                BX('bx-catalog-subscribe-form-notify').style.color = 'red';
                                                BX('bx-catalog-subscribe-form-notify').innerHTML = errorMessage;
                                            }
                                        }, this)
                                    });
                                }, this)
                            }
                        }),
                        new subscribeButton({
                            text : BX.message('CPST_SUBSCRIBE_BUTTON_CLOSE'),
                            className : 'btn',
                            events : {
                                click : BX.delegate(function() {
                                    this.elemPopupWin.destroy();
                                }, this)
                            }
                        })
                    ]);
                    this.elemPopupWin.show();
                }
                else if(result.error)
                {
                    if(result.hasOwnProperty('setButton'))
                    {
                        this.listOldItemId[this.elemButtonSubscribe.dataset.item] = true;
                        this.setButton(true);
                    }
                    this.showWindowWithAnswer({status: 'error', message: result.message});
                }
            }, this)
        });
    };

    window.JCCatalogProductSubscribe.prototype.validateContactField = function(contactTypeData)
    {
        var inputFields = BX.findChildren(BX('bx-catalog-subscribe-form'),
            {'tag': 'input', 'attribute': {id: 'userContact'}}, true);
        if(!inputFields.length || typeof contactTypeData !== 'object')
        {
            BX('bx-catalog-subscribe-form-notify').style.color = 'red';
            BX('bx-catalog-subscribe-form-notify').innerHTML = BX.message('CPST_SUBSCRIBE_VALIDATE_UNKNOW_ERROR');
            return false;
        }

        var contactTypeId, contactValue, useContact, errors = [], useContactErrors = [];
        for(var k = 0; k < inputFields.length; k++)
        {
            contactTypeId = inputFields[k].getAttribute('data-id');
            contactValue = inputFields[k].value;
            useContact = BX('bx-contact-use-'+contactTypeId);
            if(useContact && useContact.value == 'N')
            {
                useContactErrors.push(true);
                continue;
            }
            if(!contactValue.length)
            {
                errors.push(BX.message('CPST_SUBSCRIBE_VALIDATE_ERROR_EMPTY_FIELD').replace(
                    '#FIELD#', contactTypeData[contactTypeId].contactLable));
            }
        }

        if(inputFields.length == useContactErrors.length)
        {
            BX('bx-catalog-subscribe-form-notify').style.color = 'red';
            BX('bx-catalog-subscribe-form-notify').innerHTML = BX.message('CPST_SUBSCRIBE_VALIDATE_ERROR');
            return false;
        }

        if(errors.length)
        {
            BX('bx-catalog-subscribe-form-notify').style.color = 'red';
            for(var i = 0; i < errors.length; i++)
            {
                BX('bx-catalog-subscribe-form-notify').innerHTML = errors[i];
            }
            return false;
        }

        return true;
    };

    window.JCCatalogProductSubscribe.prototype.reloadCaptcha = function()
    {
        BX.ajax.get(this.ajaxUrl+'?reloadCaptcha=Y', '', function(captchaCode) {
            BX('captcha_sid').value = captchaCode;
            BX('captcha_img').src = '/bitrix/tools/captcha.php?captcha_sid='+captchaCode+'';
        });
    };

    window.JCCatalogProductSubscribe.prototype.createContentForPopup = function(responseData)
    {
        if(!responseData.hasOwnProperty('contactTypeData'))
        {
            return null;
        }

        var contactTypeData = responseData.contactTypeData, contactCount = Object.keys(contactTypeData).length,
            styleInputForm = '', manyContact = 'N', content = document.createDocumentFragment();

        if(contactCount > 1)
        {
            manyContact = 'Y';
            styleInputForm = 'display:none;';
            content.appendChild(BX.create('p', {
                text: BX.message('CPST_SUBSCRIBE_MANY_CONTACT_NOTIFY')
            }));
        }

        content.appendChild(BX.create('p', {
            props: {id: 'bx-catalog-subscribe-form-notify'}
        }));

        for(var k in contactTypeData)
        {
            if(contactCount > 1)
            {
                content.appendChild(BX.create('div', {
                    props: {
                        className: 'bx-catalog-subscribe-form-container'
                    },
                    children: [
                        BX.create('div', {
                            props: {
                                className: 'checkbox'
                            },
                            children: [
                                BX.create('lable', {
                                    props: {
                                        className: 'bx-filter-param-label'
                                    },
                                    attrs: {
                                        onclick: this.jsObject+'.selectContactType('+k+', event);'
                                    },
                                    children: [
                                        BX.create('input', {
                                            props: {
                                                type: 'hidden',
                                                id: 'bx-contact-use-'+k,
                                                name: 'contact['+k+'][use]',
                                                value: 'N'
                                            }
                                        }),
                                        BX.create('input', {
                                            props: {
                                                id: 'bx-contact-checkbox-'+k,
                                                type: 'checkbox'
                                            }
                                        }),
                                        BX.create('span', {
                                            props: {
                                                className: 'bx-filter-param-text'
                                            },
                                            text: contactTypeData[k].contactLable
                                        })
                                    ]
                                })
                            ]
                        })
                    ]
                }));
            }
            content.appendChild(BX.create('div', {
                props: {
                    id: 'bx-catalog-subscribe-form-container-'+k,
                    className: 'bx-catalog-subscribe-form-container',
                    style: styleInputForm
                },
                children: [
                    BX.create('div', {
                        props: {
                            className: 'bx-catalog-subscribe-form-container-label'
                        },
                        text: BX.message('CPST_SUBSCRIBE_LABLE_CONTACT_INPUT').replace(
                            '#CONTACT#', contactTypeData[k].contactLable)
                    }),
                    BX.create('div', {
                        props: {
                            className: 'bx-catalog-subscribe-form-container-input'
                        },
                        children: [
                            BX.create('input', {
                                props: {
                                    id: 'userContact',
                                    className: '',
                                    type: 'text',
                                    name: 'contact['+k+'][user]'
                                },
                                attrs: {'data-id': k}
                            })
                        ]
                    })
                ]
            }));
        }
        if(responseData.hasOwnProperty('captchaCode'))
        {
            content.appendChild(BX.create('div', {
                props: {
                    className: 'bx-catalog-subscribe-form-container'
                },
                children: [
                    BX.create('span', {props: {className: 'bx-catalog-subscribe-form-star-required'}, text: '*'}),
                    BX.message('CPST_ENTER_WORD_PICTURE'),
                    BX.create('div', {
                        props: {className: 'bx-captcha'},
                        children: [
                            BX.create('input', {
                                props: {
                                    type: 'hidden',
                                    id: 'captcha_sid',
                                    name: 'captcha_sid',
                                    value: responseData.captchaCode
                                }
                            }),
                            BX.create('img', {
                                props: {
                                    id: 'captcha_img',
                                    src: '/bitrix/tools/captcha.php?captcha_sid='+responseData.captchaCode+''
                                },
                                attrs: {
                                    width: '180',
                                    height: '40',
                                    alt: 'captcha',
                                    onclick: this.jsObject+'.reloadCaptcha();'
                                }
                            })
                        ]
                    }),
                    BX.create('div', {
                        props: {className: 'bx-catalog-subscribe-form-container-input'},
                        children: [
                            BX.create('input', {
                                props: {
                                    id: 'captcha_word',
                                    className: '',
                                    type: 'text',
                                    name: 'captcha_word'
                                },
                                attrs: {maxlength: '50'}
                            })
                        ]
                    })
                ]
            }));
        }
        var form = BX.create('form', {
            props: {
                id: 'bx-catalog-subscribe-form'
            },
            children: [
                BX.create('input', {
                    props: {
                        type: 'hidden',
                        name: 'manyContact',
                        value: manyContact
                    }
                }),
                BX.create('input', {
                    props: {
                        type: 'hidden',
                        name: 'sessid',
                        value: BX.bitrix_sessid()
                    }
                }),
                BX.create('input', {
                    props: {
                        type: 'hidden',
                        name: 'itemId',
                        value: this.elemButtonSubscribe.dataset.item
                    }
                }),
                BX.create('input', {
                    props: {
                        type: 'hidden',
                        name: 'siteId',
                        value: BX.message('SITE_ID')
                    }
                }),
                BX.create('input', {
                    props: {
                        type: 'hidden',
                        name: 'contactFormSubmit',
                        value: 'Y'
                    }
                })
            ]
        });

        form.appendChild(content);

        return form;
    };

    window.JCCatalogProductSubscribe.prototype.selectContactType = function(contactTypeId, event)
    {
        var contactInput = BX('bx-catalog-subscribe-form-container-'+contactTypeId), visibility = '',
            checkboxInput = BX('bx-contact-checkbox-'+contactTypeId);
        if(!contactInput)
        {
            return false;
        }

        if(checkboxInput != event.target)
        {
            if(checkboxInput.checked)
            {
                checkboxInput.checked = false;
            }
            else
            {
                checkboxInput.checked = true;
            }
        }

        if (contactInput.currentStyle)
        {
            visibility = contactInput.currentStyle.display;
        }
        else if (window.getComputedStyle)
        {
            var computedStyle = window.getComputedStyle(contactInput, null);
            visibility = computedStyle.getPropertyValue('display');
        }

        if(visibility === 'none')
        {
            BX('bx-contact-use-'+contactTypeId).value = 'Y';
            BX.style(contactInput, 'display', '');
        }
        else
        {
            BX('bx-contact-use-'+contactTypeId).value = 'N';
            BX.style(contactInput, 'display', 'none');
        }
    };

    window.JCCatalogProductSubscribe.prototype.createSuccessPopup = function(result)
    {
        this.initPopupWindow();
        this.elemPopupWin.setTitleBar(BX.message('CPST_SUBSCRIBE_POPUP_TITLE'));
        var content = BX.create('div', {
            props:{
                className: 'bx-catalog-popup-content'
            },
            children: [
                BX.create('p', {
                    props: {
                        className: 'bx-catalog-popup-message'
                    },
                    text: result.message
                })
            ]
        });
        this.elemPopupWin.setContent(content);
        this.elemPopupWin.setButtons([
            new subscribeButton({
                text : BX.message('CPST_SUBSCRIBE_BUTTON_CLOSE'),
                className : 'btn btn-primary',
                events : {
                    click : BX.delegate(function() {
                        this.elemPopupWin.destroy();
                    }, this)
                }
            })
        ]);
        this.elemPopupWin.show();
    };

    window.JCCatalogProductSubscribe.prototype.initPopupWindow = function()
    {
        this.elemPopupWin = BX.PopupWindowManager.create('CatalogSubscribe_'+this.buttonId, null, {
            autoHide: false,
            offsetLeft: 0,
            offsetTop: 0,
            overlay : true,
            closeByEsc: true,
            titleBar: true,
            closeIcon: true,
            contentColor: 'white'
        });
    };

    window.JCCatalogProductSubscribe.prototype.setButton = function(statusSubscription)
    {
        this.alreadySubscribed = Boolean(statusSubscription);
        if(this.alreadySubscribed)
        {
            this.elemButtonSubscribe.className = this.buttonClass + ' ' + this.defaultButtonClass + ' disabled';
            this.elemButtonSubscribe.innerHTML = '<span>' + BX.message('CPST_TITLE_ALREADY_SUBSCRIBED') + '</span>';
            BX.unbind(this.elemButtonSubscribe, 'click', this._elemButtonSubscribeClickHandler);
        }
        else
        {
            console.log(this.elemButtonSubscribe.innerHTML, BX.message('CPST_SUBSCRIBE_BUTTON_NAME'));
            this.elemButtonSubscribe.className = this.buttonClass + ' ' + this.defaultButtonClass;
            this.elemButtonSubscribe.innerHTML = '<span>' + BX.message('CPST_SUBSCRIBE_BUTTON_NAME') + '</span>';
            BX.bind(this.elemButtonSubscribe, 'click', this._elemButtonSubscribeClickHandler);
        }
    };

    window.JCCatalogProductSubscribe.prototype.showWindowWithAnswer = function(answer)
    {
        answer = answer || {};
        if (!answer.message) {
            if (answer.status == 'success') {
                answer.message = BX.message('CPST_STATUS_SUCCESS');
            } else {
                answer.message = BX.message('CPST_STATUS_ERROR');
            }
        }
        var messageBox = BX.create('div', {
            props: {
                className: 'bx-catalog-subscribe-alert'
            },
            children: [
                BX.create('span', {
                    props: {
                        className: 'bx-catalog-subscribe-aligner'
                    }
                }),
                BX.create('span', {
                    props: {
                        className: 'bx-catalog-subscribe-alert-text'
                    },
                    text: answer.message
                }),
                BX.create('div', {
                    props: {
                        className: 'bx-catalog-subscribe-alert-footer'
                    }
                })
            ]
        });
        var currentPopup = BX.PopupWindowManager.getCurrentPopup();
        if(currentPopup) {
            currentPopup.destroy();
        }
        var idTimeout = setTimeout(function () {
            var w = BX.PopupWindowManager.getCurrentPopup();
            if (!w || w.uniquePopupId != 'bx-catalog-subscribe-status-action') {
                return;
            }
            w.close();
            w.destroy();
        }, 3500);
        var popupConfirm = BX.PopupWindowManager.create('bx-catalog-subscribe-status-action', null, {
            content: messageBox,
            onPopupClose: function () {
                this.destroy();
                clearTimeout(idTimeout);
            },
            autoHide: true,
            zIndex: 2000,
            className: 'bx-catalog-subscribe-alert-popup'
        });
        popupConfirm.show();
        BX('bx-catalog-subscribe-status-action').onmouseover = function (e) {
            clearTimeout(idTimeout);
        };
        BX('bx-catalog-subscribe-status-action').onmouseout = function (e) {
            idTimeout = setTimeout(function () {
                var w = BX.PopupWindowManager.getCurrentPopup();
                if (!w || w.uniquePopupId != 'bx-catalog-subscribe-status-action') {
                    return;
                }
                w.close();
                w.destroy();
            }, 3500);
        };
    };

})(window);
