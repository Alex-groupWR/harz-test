$(document).ready(function () {
    let isSentReview = localStorage.getItem('isSentReview') || 0;

    if (!isSentReview) {
        $('.rate-web').addClass('rate-web__active');

        $('.rate-web').on('click', function() {
            $('.rate-web__popup').addClass('rate-web__popup--active');
        })

        $('.rate__close-img').on('click', function() {
            $('.rate-web__popup').removeClass('rate-web__popup--active');
        })

        $('.rate-web__btn-close').on('click', function() {
            $('.rate-web__popup').removeClass('rate-web__popup--active');
        })
    }
    $( ".rate-web__popup-container" ).on( "submit", function( event ) {
        event.preventDefault();

        grecaptcha.ready(function() {
            grecaptcha.execute('6LdYikErAAAAALPf0KlcQQ9grE3FIJZM3WvpVvzP', {action: 'submit'}).then(function(token) {
                $('#g-recaptcha-response-rate').val(token);
               // console.log(token)
                if (token) {
                    submitForm(token);
                }
            });
        });

    });

    function submitForm(token) {
        let isError = false;
        const impression = $('input[type=radio][name=impression]:checked').val()
        const impressionCh = $('input[type=radio][name=impression]').is(':checked')

        const comment = $('.rate-web__textarea').val()
        const errors = $('.rate-web__errors');
        const errorsComment = $('.rate-web__errors-comment');

        const lang = $('.rate-web__popup[data-lang]').attr('data-lang')

        if (!impressionCh) {
            $(errors).show()
            isError = true
        } else {
            $(errors).hide()

            if (impression < 10 && (!comment || comment.length < 5)) {
                $(errorsComment).show()
                isError = true
            } else {
                $(errorsComment).hide()
            }
        }

        if (!isError) {
           // console.log(impression)
            const commentCommon = "Сайт - " + lang + ",\n" +
                "Общее впечатление от работы с сайтом - " + impression + ",\n" +
                "Пожелания по улучшению сайта - " + comment + ",\n";

            const formData = new FormData();
            formData.append('COMMENT', JSON.stringify(commentCommon));

            const fields = {
                'UF_CRM_1713267588': lang,
                'UF_CRM_1712040297': 1555 + +impression,
                'UF_CRM_1712040314': comment,
                'SOURCE_ID': 18
            }
            formData.append('FIELDS', JSON.stringify(fields));
            formData.append('TITLE', 'Оцени сайт');
            formData.append('recaptcha_token', token);

            $.ajax({
                type: 'POST',
                url: '/local/php_interface/sendQROrderReview.php',
                cache: false,
                contentType: false,
                processData: false,
                data : formData,
                success: function(result){
                   // console.log(result);
                    $('.rate-web__mini-section').hide()
                    $('.rate-web__btn-send').hide()
                    $('.rate-web__btn-close').show()

                    $('input[type=radio][name=impression]').prop('checked', false)
                    if (result == false || result == 'false' || result.res == false || result.res == 'false') {
                        $('.rate-web__errors-captcha').show()
                    } else {
                        localStorage.setItem('isSentReview', true);
                        $('.rate-web__result').show();
                        $('.rate-web').removeClass('rate-web__active');
                        $('.rate-web__popup').removeClass('.rate-web__popup--active')
                    }

                },
                error: function(err){
                    console.log(err);
                    $('.rate-web__errors-captcha').show()
                }
            })
        }
    }
});
