// let showedBannerCounter = localStorage.getItem('isShowedBannerPopup') || 0;

 //if (!showedBannerCounter) {


    // showedBannerCounter++
//     $('body').prepend(`<section class="banner-popup-after-wrapper">
// 						        <article class="banner-popup-after">
// 						        	<button class="banner-popup-after-close">
// 							        	<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
//                                             <path d="M28 2.82L25.18 0L14 11.18L2.82 0L0 2.82L11.18 14L0 25.18L2.82 28L14 16.82L25.18 28L28 25.18L16.82 14L28 2.82Z" fill="#6C4098"/>
//                                         </svg>
// 							        </button>
// 						            <h1 class="banner-popup-after-title">
// 						                Крупнейший цифровой стоматологический конгресс
// 						            </h1>
// 						            <h2 class="banner-popup-after-title-small">
// 						                28-29 октября, москва
// 						            </h2>
// 						            <p class="banner-popup-after-descr">
// 						                <span class="banner-popup-after-descr-part"><span>12</span>экспертов</span>
// 						                <span class="banner-popup-after-descr-part"><span>2</span>дня</span>
// 						                <span class="banner-popup-after-descr-part"><span>200+</span>участников</span>
// 						            </p>
// 						            <a id="banner-popup-btn" href="https://2cifra-feedback.ru/congress?utm_source=harzlabs&utm_medium=cold&utm_campaign=popup&utm_content=1popup&utm_term=popup" target="_blank" class="button">
// 						                подробнее
// 						            </a>
// 						            <p class="banner-popup-after-subtitle">-10% по промокоду harzlabs</p>
// 						        </article>
// 						    </section>`)
//     setTimeout(function () {
//         $('.banner-popup-after-wrapper').css('opacity', '1');
//     }, 1000);
//     $('.banner-popup-after-wrapper').click(function (e) {
//         if (e.target.classList[0] == 'banner-popup-after-wrapper') {
//             localStorage.setItem('isShowedBannerPopup', showedBannerCounter);
//             $('.banner-popup-after-wrapper').css('opacity', '0');
//             setTimeout(function () {
//                 $('.banner-popup-after-wrapper').css('display', 'none')
//             }, 1000)
//         }
//     })
//     $('.banner-popup-after-close').click(function () {
//         localStorage.setItem('isShowedBannerPopup', showedBannerCounter);
//         $('.banner-popup-after-wrapper').css('opacity', '0');
//         setTimeout(function () {
//             $('.banner-popup-after-wrapper').css('display', 'none')
//         }, 1000)
//     });
//     $('#banner-popup-btn').click(function () {
//         localStorage.setItem('isShowedBannerPopup', showedBannerCounter);
//         $('.banner-popup-after-wrapper').css('opacity', '0');
//         setTimeout(function () {
//             $('.banner-popup-after-wrapper').css('display', 'none')
//         }, 1000)
//     });


//      $('body').addClass('header-showed')
// } else {
//      localStorage.setItem('isShowedBannerPopup', true)
//      showedBannerCounter = 1
// }
//
//  $('.header-banner__close').click(function () {
//      $('body').removeClass('header-showed')
//      localStorage.setItem('isShowedBannerPopup', true)
//  });


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