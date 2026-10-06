function setCookie(name, value, days) {
    const date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    const expires = "expires=" + date.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}


document.addEventListener('DOMContentLoaded', function() {
    const cookiePopup = document.querySelector('.cookie-popup');
    const acceptButton = document.querySelector('.cookie-popup__btn');

    if (!getCookie('cookiesAccepted')) {
        cookiePopup.style.opacity = '1';
        setTimeout(() => { cookiePopup.style.display = 'block'; }, 300);
    } else {
        cookiePopup.style.opacity = '0';
        setTimeout(() => { cookiePopup.style.display = 'none'; }, 300);
    }

    acceptButton.addEventListener('click', function() {
        setCookie('cookiesAccepted', 'true', 30);

        cookiePopup.style.opacity = '0';
        setTimeout(() => { cookiePopup.style.display = 'none'; }, 300);
    });
});