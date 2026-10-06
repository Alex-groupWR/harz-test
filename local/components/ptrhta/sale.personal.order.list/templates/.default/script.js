jQuery(document).ready(function($) {
    $('.sale-personal-order-detail-block-payment--sber').on('click', function() {
        const paymentId = $(this).attr('data-id');
        const paymentContent = $('.payment-content--' + paymentId).html()
        $('body').prepend(`<section class="banner-popup-after-wrapper">
						        <article class="banner-popup-after">
						        	<button class="banner-popup-after-close">
							        	<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <path d="M28 2.82L25.18 0L14 11.18L2.82 0L0 2.82L11.18 14L0 25.18L2.82 28L14 16.82L25.18 28L28 25.18L16.82 14L28 2.82Z" fill="#6C4098"/>
                                        </svg>
							        </button>
						           ${paymentContent}
						        </article>
						    </section>`)
        setTimeout(function () {
            $('.banner-popup-after-wrapper').css('opacity', '1');
        }, 500);

        $('.banner-popup-after-wrapper').click(function (e) {
            if (e.target.classList[0] == 'banner-popup-after-wrapper') {
                $('.banner-popup-after-wrapper').css('opacity', '0');
                setTimeout(function () {
                    $('.banner-popup-after-wrapper').css('display', 'none')
                    $('.banner-popup-after-wrapper').remove()
                }, 500)
            }
        })
        $('.banner-popup-after-close').click(function () {
            $('.banner-popup-after-wrapper').css('opacity', '0');
            setTimeout(function () {
                $('.banner-popup-after-wrapper').css('display', 'none')
                $('.banner-popup-after-wrapper').remove()
            }, 500)
        });
    })
})
