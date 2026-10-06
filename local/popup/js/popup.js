let showedBannerPopupCounter = localStorage.getItem('showedBannerPopupCounter3') || 0;
if (!showedBannerPopupCounter || showedBannerPopupCounter < 3) {
    $('body').addClass('header-showed')
} else {
    showedBannerPopupCounter++
    localStorage.setItem('showedBannerPopupCounter3', showedBannerPopupCounter);
}

$('.header-banner__close').click(function () {
    $('body').removeClass('header-showed')
    showedBannerPopupCounter++
    localStorage.setItem('showedBannerPopupCounter3', showedBannerPopupCounter);
});
