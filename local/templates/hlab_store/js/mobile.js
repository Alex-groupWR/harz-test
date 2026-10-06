$(document).ready(function () {

    // Add down arrow icon for collapse element which is open by default
    $(".collapse.show").each(function () {
        // console.log('$(".collapse.show")');
        $(this).prev(".card-header").find(".fa").addClass("triangle-down").removeClass("triangle-right");
    });

    // Toggle right and down arrow icon on show hide of collapse element
    $(".collapse").on('show.bs.collapse', function () {
        console.log('show.bs.collapse');
        $(this).prev(".card-header").find(".fa").removeClass("triangle-right").addClass("triangle-down");
    }).on('hide.bs.collapse', function (e) {
        console.log('hide.bs.collapse', e);
        $(this).prev(".card-header").find(".fa").removeClass("triangle-down").addClass("triangle-right");
    });

    // calls when blackBg clicked
    const hideAllCollapses = e => { // if clicked on dark
        e.stopPropagation();

        var panelSearchMobile = $("#collapsibleSearch");
        panelSearchMobile.collapse('hide');

        var panelNavbarMobile = $("#collapsibleNavbar");
        panelNavbarMobile.collapse('hide');

        $(e.currentTarget).removeClass('visible')
        $(e.currentTarget).off( 'click' );
    }

    $(".icon-btn-search").on ( 'click', function (e) {
        e.stopPropagation();
        var panelNavbarMobile = $("#collapsibleNavbar");
        var panelSearchMobile = $("#collapsibleSearch");
        const blackBgElement = $(".menu-mobile-open");

        var isNavbarVisible = panelNavbarMobile.is(":visible");
        var isSearchVisible = panelSearchMobile.is(":visible");

        if ( isNavbarVisible ) {
            panelNavbarMobile.collapse('hide');
        }

        if ( isSearchVisible ) { // remove listener if opened
            blackBgElement.off( 'click' );
            blackBgElement.removeClass('visible') // add dark bg
            panelSearchMobile.collapse('hide'); // expand search panel
        } else { // add listener if closed
            blackBgElement.on( 'click', hideAllCollapses)
            blackBgElement.addClass('visible') // add dark bg
            panelSearchMobile.collapse('toggle'); // expand search panel
        }
    });

    $(".navbar-toggler").on ( 'click', function (e) {
        e.stopPropagation();
        var panelNavbarMobile = $("#collapsibleNavbar");
        var panelSearchMobile = $("#collapsibleSearch");
        const blackBgElement = $(".menu-mobile-open");

        var isNavbarVisible = panelNavbarMobile.is(":visible");
        var isSearchVisible = panelSearchMobile.is(":visible");

        if ( panelSearchMobile ) {
            panelSearchMobile.collapse('hide');
        }

        if (isNavbarVisible) { // remove listener if opened
            blackBgElement.off('click');
            blackBgElement.removeClass('visible') // add dark bg
            panelNavbarMobile.collapse('hide'); // expand search panel
        } else { // add listener if closed
            blackBgElement.on('click', hideAllCollapses)
            blackBgElement.addClass('visible') // add dark bg
            panelNavbarMobile.collapse('toggle'); // expand navbar panel
        }
    });
});
