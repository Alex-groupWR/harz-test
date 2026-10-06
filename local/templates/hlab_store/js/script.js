    let removebtns = document.getElementsByClassName("remove-product-cart");

    for (let n = 0; n < removebtns.length; n++) {
        removebtns[n].addEventListener("click", function () {
            this.parentNode.style.display = 'none';
        });
    }

    $(".basket-color-filter[ss!='single-color']").mouseenter(function (e) {
        const currColorBasket = $(e.currentTarget).parent().find(".choose-color-basket");
        if (currColorBasket) {
            $(currColorBasket).css("display", "flex");
        }
    });
    $(".choose-color-basket").mouseleave(function (e) {
        $(e.currentTarget).css("display", "none");
    });

    $(".search input").change(function () {
        $('input').addClass("input-search");
    });

    // if we have anchor on the url (calling from other page)
    if (window.location.hash) {
        // smooth scroll to the anchor id
        $('html,body').animate({
            scrollTop: $(window.location.hash).offset().top - 180
        }, 600, 'swing');
    }

	$(".input-search").click(function (e) {
		$(".form-search").off('mouseout');
	});

    $(".form-search").mouseover(function (e) {
        $('.form-search').addClass('form-search-visible');
    });

	$(".form-search").mouseout(function (e) {
		$('.form-search').removeClass('form-search-visible');
	});

	$(document).click(function (e) {
		if (! $('.form-search').hasClass('form-search-visible') ) return;
		if ( $(".input-search")[0] == e.target ) return;

		$('.form-search').removeClass('form-search-visible');

		$(".form-search").mouseout(function (e) {
			$('.form-search').removeClass('form-search-visible');
		});
	});