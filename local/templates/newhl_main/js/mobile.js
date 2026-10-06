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
    $(".menu-main-mobile").toggle(
      function () {
        $(".menu-main-mobile").css({"margin-top": "103px"});
      });
  });
  function hideCollapsibleNavbar(e) {
    // debugger;// событие клика по веб-документу
    var div = $("#collapsibleNavbar"); // тут указываем ID элемента
    if (!div.is(e.target) // если клик был не по нашему блоку
      && div.has(e.target).length === 0) { // и не по его дочерним элементам
      $(".menu-mobile-open").removeClass('visible');
      div.collapse('hide'); // скрываем его
      $(document).off("click", "#collapsibleNavbar", hideCollapsibleNavbar);
      $("body").removeClass("modal-open");
    }
  };

  $(".navbar-toggler").click(function (e) {
    e.stopPropagation();
    $("#collapsibleNavbar").collapse('toggle');
    // $("#collapsibleSearch").collapse('hide');
    // if (!$(".menu-mobile-open").hasClass('visible')) {
    $(".menu-mobile-open").toggleClass('visible');
    // }
    // $(document).click(hideCollapsibleNavbar);
    $("body").toggleClass("modal-open");
    $("#collapsibleNavbar").on('show.bs.collapse', function () {
      $("#collapsibleSearch").collapse('hide');
      if (!$(".menu-mobile-open").hasClass('visible')) {
        $(".menu-mobile-open").removeClass('visible');
      }
    });
    $("#collapsibleNavbar").on('shown.bs.collapse', function () {
      $(document).click(hideCollapsibleNavbar);
      $("body").addClass("modal-open");
      $(".menu-mobile-open").addClass('visible');
    });
  });



  function hideCollapsibleSearch(e) {
    // debugger;// событие клика по веб-документу
    var panelSearchMobile = $("#collapsibleSearch"); // тут указываем ID элемента
    if (!panelSearchMobile.is(e.target) // если клик был не по нашему блоку
      && panelSearchMobile.has(e.target).length === 0) { // и не по его дочерним элементам
      $(".menu-mobile-open").removeClass('visible');
      panelSearchMobile.collapse('hide'); // скрываем его
      $(document).off("click", "#collapsibleSearch", hideCollapsibleSearch);
      $("body").removeClass("modal-open");
    }
  };
  $(".icon-btn-search").click(function (e) {
    e.stopPropagation();
    // $("#collapsibleNavbar").collapse('hide');
    $("#collapsibleSearch").collapse('toggle');
    // if (!$(".menu-mobile-open").hasClass('visible')) {
    $(".menu-mobile-open").toggleClass('visible');
    // }
    $("body").toggleClass("modal-open");
    // $(document).click(hideCollapsibleSearch);
    $("#collapsibleSearch").on('show.bs.collapse', function () {
      $("#collapsibleNavbar").collapse('hide');
      if (!$(".menu-mobile-open").hasClass('visible')) {
        $(".menu-mobile-open").addClass('visible');
      }
    });
    $("#collapsibleSearch").on('shown.bs.collapse', function () {
      $(document).click(hideCollapsibleSearch);
      $("body").addClass("modal-open");
      $(".menu-mobile-open").addClass('visible');
    });

  });
});