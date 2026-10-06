'use strict';
$(document).ready(function () {
    let removebtns = document.getElementsByClassName("remove-product-cart");

    for (let n = 0; n < removebtns.length; n++) {
        removebtns[n].addEventListener("click", function () {
            this.parentNode.style.display = 'none';
        });
    }

    $(".basket-color-filter").mouseenter(function (e) {
        const currColorBasket = $(e.currentTarget).parent().find(".choose-color-basket");
        if (currColorBasket) {
            $(currColorBasket).css("display", "flex");
        }
    });
    $(".choose-color-basket").mouseleave(function (e) {
        $(e.currentTarget).css("display", "none");
    });
});

let isOpenedSearchMobile = false;

const toggleSearch = () => {
    if (window.innerWidth <= 768) {
        const container = window.innerWidth <= 768 ? '.nav-mobile-main ' : ''
        const searchButton = document.querySelector(`${container}.bx-searchtitle button`);
        const searchInput = document.querySelector(`${container}.bx-searchtitle input`);
        const searchForm = document.querySelector(`${container}.bx-searchtitle form`);


        if (searchButton && searchInput) {
            if (isOpenedSearchMobile) {
                if (!searchInput.value) {
                    isOpenedSearchMobile = false;
                    searchInput.style.width = '0';
                    searchInput.style.padding = '0';
                    searchInput.style.border = 'none';
                    searchButton.style.borderRadius = '10px';
                    searchButton.style.borderLeft = '1px solid #d5dadc';
                } else {
                    searchForm.submit();
                }
            } else {
                searchInput.style.width = '100%';
                searchInput.style.padding = '6px 12px';
                searchInput.style.border = '1px solid #d5dadc';
                searchButton.style.borderRadius = '0 10px 10px 0';
                searchButton.style.borderLeft = 'none';
                isOpenedSearchMobile = true;
            }
        }
    }
}