jQuery(document).ready(function($) {
    $('.qr__accordeon-title').on('click', function() {
        $(this).closest('.qr__accordeon-row').toggleClass('qr__accordeon-row--open')
        const target = $(this).closest('.qr__accordeon-row')
        const rows =  $('.qr__accordeon-row');
        $.each($(rows), function() {
            if ($(this)[0].outerText !== target[0].outerText) {
                $(this).removeClass('qr__accordeon-row--open')
            }
        })
    })
})
