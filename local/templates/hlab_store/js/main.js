'use strict';

// MAIN PAGE 
function getStyleLink(parentSelector, activeClass) {
  const parents = document.querySelectorAll(`${parentSelector}`);
  const mainSection = document.querySelector('.main-section');
  const linkMainPage = document.querySelector('.navbar-link');
  const screenWidth = window.screen.width;
  const bgs = [
    'company-bg',
    'products-bg',
    'support-bg',
    'dealers-bg',
    'news-bg'
  ];
  const links = [
    'company',
    'products',
    'support',
    'dealers',
    'news'
  ]

  parents.forEach((parent, idx) => {
    parent.onmouseenter = (e) => {
      parent.classList.add(activeClass);
      mainSection.style.backgroundImage = `url(../img/${bgs[idx]}.png)`;
    };
    parent.onmouseleave = (e) => {
      parent.classList.remove(activeClass);
      mainSection.style.backgroundImage = `url(../img/${bgs[idx]}.png)`;
    };
    parent.onclick = (e) => {
      if (screenWidth <= 1024) {
        parents.forEach(p => p.classList.remove(activeClass));
        e.currentTarget.classList.add(activeClass);
        mainSection.style.backgroundImage = `url(../img/${bgs[idx]}.png)`;
      } else {
        document.location.href = `${links[idx]}.html`;
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

  function hideSearchCollapse(e) {
    let searchPanelElement = $("#collapsibleSearch"); // тут указываем ID элемента
    if (!searchPanelElement.is(e.target) // если клик был не по нашему блоку
      && searchPanelElement.has(e.target).length === 0) { // и не по его дочерним элементам
      searchPanelElement.collapse('hide'); // скрываем его
      $(document).off('click', hideSearchCollapse);
    }
  }

  $(".icon-btn-search").click(function (e) {
    let searchPanelElement = $("#collapsibleSearch");
    let isSearchPanelVisible = searchPanelElement.is(":visible");
    if (isSearchPanelVisible) {
      $(document).off('click', hideSearchCollapse);
    } else {
      window.setTimeout(() => {$(document).on('click', hideSearchCollapse)});
    }
    $("#collapsibleSearch").collapse('toggle');
  });
});