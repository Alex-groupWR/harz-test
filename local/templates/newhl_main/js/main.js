'use strict';

// MAIN PAGE

function getStyleLink(parentSelector, activeClass) {
    const parents = document.querySelectorAll(`${parentSelector}`);
    const mainSection = document.querySelector('.main-section');
    const linkMainPage = document.querySelector('.navbar-link');
    const videoFrame = document.querySelector('.container-video video')
    const videoSource = videoFrame.querySelector('source')
    const videoSourceMov = videoFrame.querySelector('source[type="video/quicktime"]')

    const screenWidth = window.screen.width;
    const bgs = [
        'company-bg',
        'products-bg',
        'support-bg',
        'dealers-bg',
        'news-bg'
    ];
    const links = [
        'about',
        'products',
        'support',
        'dealers',
        window.location.hostname.includes('.ru') ? 'education' : 'news'
    ]
    const videoIds = [
        'Company', 'Products', 'Support', 'Dealers', 'News'
    ]

    parents.forEach((parent, idx) => {
        parent.onmouseenter = (e) => {
            parent.classList.add(activeClass);
           // mainSection.style.backgroundImage = ;
            if (screenWidth >= 768) {
                videoSource.setAttribute('src', `/local/templates/newhl_main/video/${videoIds[idx]}.mp4`);
                videoSourceMov.setAttribute('src', `/local/templates/newhl_main/video/${videoIds[idx]}.mov`);
                const isLoaded = videoFrame.load();
                if (isLoaded !== undefined) {
                    isLoaded.then(() => videoFrame.play())
                }
            }
        };
        parent.onmouseleave = (e) => {
            parent.classList.remove(activeClass);
           //mainSection.style.backgroundImage = `none`;
        };
        parent.onclick = (e) => {
            if (screenWidth <= 768) {
                parents.forEach(p => p.classList.remove(activeClass));
                e.currentTarget.classList.add(activeClass);
                //mainSection.style.backgroundImage = `url(../img/${bgs[idx]}.png)`;
            } else {
                document.location.href = `/${links[idx]}/`;
                videoSource.setAttribute('src', `/local/templates/newhl_main/video/${videoIds[idx]}.mp4`);
                videoSourceMov.setAttribute('src', `/local/templates/newhl_main/video/${videoIds[idx]}.mov`);
                videoFrame.load();
                videoFrame.play();
            }
        }
        linkMainPage.onclick = (e) => {
            window.location.href = $(this).attr('href');
        }
    });
}

getStyleLink('.block-main-menu', 'active');


$(document).ready(function () {
    // Add down arrow icon for collapse element which is open by default
    $(".collapse.show").each(function () {
        $(this).prev(".card-header").find(".fa").addClass("triangle-down").removeClass("triangle-right");
    });

    // Toggle right and down arrow icon on show hide of collapse element
    $(".collapse").on('show.bs.collapse', function () {
        $(this).prev(".card-header").find(".fa").removeClass("triangle-right").addClass("triangle-down");
    }).on('hide.bs.collapse', function () {
        $(this).prev(".card-header").find(".fa").removeClass("triangle-down").addClass("triangle-right");
    });

    $(".icon-btn-search").click(function () {
        $(".form-search-mobile").toggle(100);
    });
    $(document).mouseup(function (e) { // событие клика по веб-документу
        let div = $(".form-search-mobile"); // тут указываем ID элемента
        if (!div.is(e.target) // если клик был не по нашему блоку
            && div.has(e.target).length === 0) { // и не по его дочерним элементам
            div.hide(); // скрываем его
        }
    });
});

//Куки верхний баннер
function cookieTopBanner() {
    const modal = document.querySelector(".top-fixed-banner");
    if (!modal) return;
    
    const closeBtn = modal.querySelector(".top-fixed-banner__close");
    
    // Проверяем, скрыт ли баннер навсегда
    if (document.cookie.includes('is_top_fixed_banner=Y')) {
        modal.classList.add("is-hidden");
        return;
    }
    
    // Проверяем счетчик закрытий
    const closeCount = getCloseCount();
    if (closeCount >= 3) {
        document.cookie = "is_top_fixed_banner=Y; max-age=31536000; path=/";
        modal.classList.add("is-hidden");
        return;
    }
    
    modal.classList.remove("is-hidden");
    
    if (closeBtn) {
        closeBtn.addEventListener("click", () => {
            const currentCount = getCloseCount();
            const newCount = currentCount + 1;
            
            if (newCount >= 3) {
                // После 3-го нажатия скрываем навсегда
                document.cookie = "is_top_fixed_banner=Y; max-age=31536000; path=/";
                // Удаляем cookie со счетчиком
                document.cookie = "top_banner_close_count=0; max-age=0; path=/";
            } else {
                // Сохраняем новый счетчик
                document.cookie = `top_banner_close_count=${newCount}; max-age=31536000; path=/`;
            }
            
            modal.classList.add("is-hidden");
        });
    }
}
function cookieTopBanner() {
    const modal = document.querySelector(".top-fixed-banner");
    if (!modal) return;
    
    const closeBtn = modal.querySelector(".top-fixed-banner__close");
    
    // Проверяем, скрыт ли баннер навсегда
    if (document.cookie.includes('is_top_fixed_banner=Y')) {
        modal.classList.add("is-hidden");
        return;
    }
    
    // Проверяем счетчик закрытий
    const closeCount = getCloseCount();
    if (closeCount >= 3) {
        document.cookie = "is_top_fixed_banner=Y; max-age=31536000; path=/";
        modal.classList.add("is-hidden");
        return;
    }
    
    modal.classList.remove("is-hidden");
    
    if (closeBtn) {
        closeBtn.addEventListener("click", () => {
            const currentCount = getCloseCount();
            const newCount = currentCount + 1;
            
            if (newCount >= 3) {
                // После 3-го нажатия скрываем навсегда
                document.cookie = "is_top_fixed_banner=Y; max-age=31536000; path=/";
                // Удаляем cookie со счетчиком
                document.cookie = "top_banner_close_count=0; max-age=0; path=/";
            } else {
                // Сохраняем новый счетчик
                document.cookie = `top_banner_close_count=${newCount}; max-age=31536000; path=/`;
            }
            
            modal.classList.add("is-hidden");
        });
    }
}
// Функция для получения текущего счетчика закрытий
function getCloseCount() {
    const name = 'top_banner_close_count=';
    const decodedCookie = decodeURIComponent(document.cookie);
    const ca = decodedCookie.split(';');
    
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return parseInt(c.substring(name.length, c.length)) || 0;
        }
    }
    return 0;
}
document.addEventListener('DOMContentLoaded', function () {
    cookieTopBanner();
});
