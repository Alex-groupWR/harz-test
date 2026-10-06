let isShowedBanner = localStorage.getItem('isShowedBanner');

if (!isShowedBanner) {
    setTimeout(function () {
        $('body').prepend(`<section class="banner-popup-after-wrapper">
						        <article class="banner-popup-after">
						        	<button class="banner-popup-after-close">
							        	<svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                                           <path d="M33 2.8875L30.1125 0L16.5 13.6125L2.8875 0L0 2.8875L13.6125 16.5L0 30.1125L2.8875 33L16.5 19.3875L30.1125 33L33 30.1125L19.3875 16.5L33 2.8875Z" fill="#6E368C"/>
                                        </svg>
							        </button>
							        <img class="banner-popup-after-img" src="/local/templates/hlab_store/img/tg.svg">
						            <h1 class="banner-popup-after-title">
						                Будь с нами в Telegram!
						            </h1>
						            <p class="banner-popup-after-descr">
						                Делимся новостями, показываем кейсы и рассказываем про горячие новинки
						            </p>
						            <a id="banner-popup-btn" href="https://t.me/harzlabs" target="_blank" class="button">
						                Подписаться
						            </a>
						        </article>
						    </section>`)
        setTimeout(function () {
            $('.banner-popup-after-wrapper').css('opacity', '1');
        }, 1000);
        $('.banner-popup-after-wrapper').click(function (e) {
            if (e.target.classList[0] == 'banner-popup-after-wrapper') {
                localStorage.setItem('isShowedBanner', true);
                $('.banner-popup-after-wrapper').css('opacity', '0');
                setTimeout(function () {
                    $('.banner-popup-after-wrapper').css('display', 'none')
                }, 1000)
            }
        })
        $('.banner-popup-after-close').click(function () {
            localStorage.setItem('isShowedBanner', true);
            $('.banner-popup-after-wrapper').css('opacity', '0');
            setTimeout(function () {
                $('.banner-popup-after-wrapper').css('display', 'none')
            }, 1000)
        });
        $('#banner-popup-btn').click(function () {
            localStorage.setItem('isShowedBanner', true);
            $('.banner-popup-after-wrapper').css('opacity', '0');
            setTimeout(function () {
                $('.banner-popup-after-wrapper').css('display', 'none')
            }, 1000)
        });
    }, 20000);
}

