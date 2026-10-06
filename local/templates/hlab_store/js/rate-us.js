jQuery(document).ready(function($) {

    const dt = new DataTransfer();


    // function removeFilesItem(target) {
    //     let name = $(target).prev().text();
    //     let input = $(target).closest('.input-file-row').find('input[type=file]');
    //     $(target).closest('.input-file-list-item').remove();
    //     for (let i = 0; i < dt.items.length; i++) {
    //         if (name === dt.items[i].getAsFile().name) {
    //             dt.items.remove(i);
    //         }
    //     }
    //     input[0].files = dt.files;
    // }

    $('.input-file input[type=file]').on('change', function () {
        let $files_list = $(this).closest('.input-file').find('.rate-us__file-list');
        $files_list.empty();

        for (var i = 0; i < this.files.length; i++) {
            let new_file_input = '' +
                '<span class="input-file-list-name">' + this.files.item(i).name + '</span>' +
                '';
            $files_list.append(new_file_input);
            dt.items.add(this.files.item(i));
        }

        this.files = dt.files;
    });

    $('input[type=radio][name=material]').on('change', function() {
        const materialVal = $(this).val();

        if (materialVal == 10) {
            $('.rate-us__problems').css('display', 'none')
        } else {
            $('.rate-us__problems').css('display', 'block')
        }
    });

    $('input[type=checkbox][name=problem]').each(function(i, input) {
        $(input).on('change', function() {
           // console.log($(this).val(), $(this).is(':checked'))
            const problemVal = $(this).val();
            const problemChecked =  $(this).is(':checked')
            $('input[type=checkbox][name=problem]').each(function(i) {
                if ($(this).val() !== problemVal) {
                    $(this).prop('checked', false);
                }
            })

            if (problemVal == 'no' && problemChecked) {
                $('.rate-us__problem--no').css('display', 'block')
            } else {
                $('.rate-us__problem--no').css('display', 'none')
            }

            if (problemVal == 'yes' && problemChecked) {
                $('#tech').css('display', 'block')
            } else {
                $('#tech').css('display', 'none')
            }
        });
    })


    $( ".rate-us__form" ).on( "submit", function( event ) {
        event.preventDefault();
        const material = $('input[type=radio][name=material]:checked').val()
        const materialCh = $('input[type=radio][name=material]').is(':checked')
        const materialProblem = $('input[type=checkbox][name=problem]:checked').val()
        const techSupport = $('input[type=radio][name=technicalSupport]:checked').val()
        const techSupportCh = $('input[type=radio][name=technicalSupport]').is(':checked')
        const sales = $('input[type=radio][name=sales]:checked').val()
        const delivery = $('input[type=radio][name=delivery]:checked').val()
        const deliveryCh = $('input[type=radio][name=delivery]').is(':checked')
        const comment = $('.rate-us__textarea').val()
        const errors = $('.rate-us__errors')
        const errorsText = errors.find('span')
        const lang = $('[data-lang]').attr('data-lang')
        const files = $('.rate-us__file')[0].files
        const order = $('input[name=order]').val()
        const email = $('input[name=email]').val()
        const phone = $('input[name=phone]').val()

        const errorsFields = []
        if (!materialCh) {
            errorsFields.push(
                $('input[type=radio][name=material]').closest('.rate-us__mini-section').find('h2').text()
            )
        }

        if (material < 10 && materialCh && materialProblem == 'yes' && !techSupportCh) {
            errorsFields.push(
                $('input[type=radio][name=technicalSupport]').closest('.rate-us__mini-section').find('h2').text()
            )
        }

        if (!deliveryCh) {
            errorsFields.push(
                $('input[type=radio][name=delivery]').closest('.rate-us__mini-section').find('h2').text()
            )
        }

        if (errorsFields.length) {
            errors.css('display', 'block')
            let text = '';
            errorsFields.map((err, i) => {
                let nextSep = i == errorsFields.length - 1 ? '' : ', '
                text += '"' + err + '"' + nextSep
            })
            errorsText.text(text)
        } else {
            console.log(sales, $('input[type=radio][name=sales]:checked').val())
            errors.css('display', 'none')
            const sMaterial = material ? material : ''
            const sMaterialPr = materialProblem == 'yes' ? 'Да' : (materialProblem == 'no' ? 'Нет' : '')
            const sTech = techSupport ? techSupport : ''
            const sSales = sales ? sales : ''
            const sDelivery = delivery ? delivery : ''

            const commentCommon = "Сайт - " + lang + ",\n" +
                "Номер заказа - " + order + ",\n" +
                "Email - " + email + ",\n" +
                "Телефон - " + phone + ",\n" +
"Качество материала - " + sMaterial + ",\n" +
"Обращались ли в техподдержку? - " + sMaterialPr  + ",\n" +
"Общение с отделом техподдержки - " + sTech + ",\n" +
"Общение с отделом продаж - " + sSales + ",\n" +
"Доставка - " + sDelivery + ",\n" +
"Комментарии к заказу - " + comment + ",\n";

            const formData = new FormData();
            formData.append('COMMENT', JSON.stringify(commentCommon));

            const fields = {
                'UF_CRM_1713267588': lang,
                'UF_CRM_1713267611': order,
                'EMAIL': JSON.stringify(
                    {
                        'VALUE': email,
                        'VALUE_TYPE': 'WORK'
                    }
                ),
                'PHONE': JSON.stringify(
                    {
                        'VALUE': phone,
                        'VALUE_TYPE': 'WORK'
                    }
                ),
                'UF_CRM_1713267674': sMaterial,
                'UF_CRM_1713267693': sMaterialPr,
                'UF_CRM_1713267718': sTech,
                'UF_CRM_1713267742': sSales,
                'UF_CRM_1713267763': sDelivery,
                'UF_CRM_1713267788': comment,
                'SOURCE_ID': 18
            }
            formData.append('FIELDS', JSON.stringify(fields));

            $.each($("input[type='file']")[0].files, function(i, file) {
                formData.append('FILES[]', file);
            });

            $.ajax({
                type: 'POST',
                url: '/local/php_interface/sendQROrderReview.php',
                cache: false,
                contentType: false,
                processData: false,
                data : formData,
                success: function(result){
                    console.log(result);
                    $('.rate-us__btn').text($('.rate-us__btn').attr('data-success'))
                    $('.rate-us__btn').prop('disabled', true)

                },
                error: function(err){
                    console.log(err);
                }
            })
        }
    });
})