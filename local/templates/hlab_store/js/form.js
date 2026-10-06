$(document).ready(function () {
    // $('.modal form').submit(function (event) {
    //     event.preventDefault();
    //     let self = this;
    //     $.ajax($(self).attr('action'), {
    //         method: $(self).attr('method'),
    //         dataType: 'json',
    //         data: $(self).serializeArray(),
    //         success: function (data) {
    //             if(data.success === false) {
    //                 $(self).find('label').removeClass('form__input--error');
    //                 $.each(data.errors, function(index, obj){
    //                     $(self).find('input[name="' + obj.field + '"]').parent('label').addClass('form__input--error');
    //                 });
    //                 return false;
    //             }
    //             let wrapper = $(self).find('.form__wrapper');
    //             $(wrapper).html('<div class="form__title">' + data.message + '</div><div class="form__desc">' + data.description + '</div>');
    //         },
    //         error: function () {
    //             let div = $(self).find('.form__desc.error');
    //             if (typeof(div) !== 'undefined')
    //                 div.html('Send form error. Again...');
    //             else
    //                 $(self).find('.form__wrapper').append('<div class="form__desc error">Send form error.</div>');
    //         }
    //     });
    //     return false;
    // });

    $('.call form').submit(function (event) {
        event.preventDefault();
        let self = this;
        $.ajax($(self).attr('action'), {
            method: $(self).attr('method'),
            dataType: 'json',
            data: $(self).serializeArray(),
            success: function (data) {
                if(data.success === false) {
                    $(self).find('label').removeClass('form__input--error');
                    $.each(data.errors, function(index, obj){
                        $(self).find('input[name="' + obj.field + '"]').parent('label').addClass('form__input--error');
                    });
                    return false;
                }
                let wrapper = $(self).find('.form__wrapper');
                $(wrapper).html('<div class="form__title">' + data.message + '</div><div class="form__desc">' + data.description + '</div>');
            },
            error: function () {
                let div = $(self).find('.form__desc.error');
                if (typeof(div) !== 'undefined')
                    div.html('Send form error. Again...');
                else
                    $(self).find('.form__wrapper').append('<div class="form__desc error">Send form error.</div>');
            }
        });
        return false;
    });

    $('.manufacturing__form form').submit(function (event) {
        event.preventDefault();
        let self = this;
        $.ajax($(self).attr('action'), {
            method: $(self).attr('method'),
            dataType: 'json',
            data: $(self).serializeArray(),
            success: function (data) {
                if(data.success === false) {
                    $(self).find('label').removeClass('form__input--error');
                    $.each(data.errors, function(index, obj){
                        $(self).find('input[name="' + obj.field + '"]').parent('label').addClass('form__input--error');
                    });
                    return false;
                }
                let wrapper = $(self).find('.form__wrapper');
                $(wrapper).html('<div class="form__title">' + data.message + '</div><div class="form__desc">' + data.description + '</div>');
            },
            error: function () {
                let div = $(self).find('.form__desc.error');
                if (typeof(div) !== 'undefined')
                    div.html('Send form error. Again...');
                else
                    $(self).find('.form__wrapper').append('<div class="form__desc error">Send form error.</div>');
            }
        });
        return false;
    });

    $('.backward__link').click(function(e) {e.preventDefault();window.history.back();return false;});

    $('.search__delete').on('click', function(){
        $(this).parent().find('.search_text-js').val('');
    });

    $('.js-delivery-data-block').on('click', function(e){
        e.preventDefault();
        let ddb = $('.delivery-data-block');
        if($(this).hasClass('active')) return false;
        $(this).siblings('input').val(1);
        //$(ddb).find('.dropdown-field').val(200).change();
        //$(ddb).find('.bx-ui-sls-fake').val('Москва').change();
        $(this).addClass('active');
        $(ddb).fadeIn(300);
        return false;
    });

	if(!$('.js-delivery-data-block').hasClass('active')) {
		$('#ID_DELIVERY_ID_68').click();
	}
});