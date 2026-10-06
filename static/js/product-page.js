//Slider
let slideIndex = 1;
showSlides(slideIndex);

function currentSlide(n) {
  showSlides(slideIndex = n);
}



function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("wrapperSlidesProduct");
  let dots = document.getElementsByClassName("dotSlidesProduct");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex - 1].style.display = "block";
  dots[slideIndex - 1].className += " active";
}

let orderProduct = document.getElementsByClassName("orderProduct")[0];
orderProduct.addEventListener("click", function () {
  const screenWidth = window.screen.width;



  let slides = document.getElementsByClassName("wrapperSlidesProduct");
  let wrapperSlides = document.querySelectorAll(".wrapperSlidesProduct");
  let flyingImg = document.querySelector(".wrapper-flying-img:not(.clone)");

  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slides[0].style.display = "block";
  document.getElementsByClassName("orderProduct")[0].innerHTML = "В корзине";
  orderProduct.classList.add("active");

  const clone = $(flyingImg).clone().appendTo(wrapperSlides);
  $(clone).addClass('clone').css({'z-index': '999'});
  // clone;
  let basket = document.querySelectorAll(".desktop-nav-collapse .nav-item.basket");
  let targetX = $(basket).offset()['left'] + $(basket).width() - $(clone).offset()['left'] + 165;
  let targetY = $(basket).offset()['top'] - $(clone).offset()['top'] + 50;
  if (screenWidth < 767) {
    basket = document.querySelectorAll(".nav-mobile-page .nav-item.basket");
    targetX = $(basket).offset()['left'] + $(basket).width() - $(clone).offset()['left'] + 90;
    targetY = $(basket).offset()['top'] - $(clone).offset()['top'] - 150;
  }

  clone.animate({
    top: targetY,
    left: targetX,
    opacity: 0.4,
    width: 40,
  }, 1000, function () {
    $(this).remove();
  });
});



$(document).ready(function () {
  (function () {
    let a = document.querySelector('.left-sidenav-text-page'), b = null, P = 0;  // если ноль заменить на число, то блок будет прилипать до того, как верхний край окна браузера дойдёт до верхнего края элемента. Может быть отрицательным числом
    window.addEventListener('scroll', Ascroll, false);
    document.body.addEventListener('scroll', Ascroll, false);
    function Ascroll() {
      if (b == null) {
        let Sa = getComputedStyle(a, ''), s = '';
        for (let i = 0; i < Sa.length; i++) {
          if (Sa[i].indexOf('overflow') == 0 || Sa[i].indexOf('padding') == 0 || Sa[i].indexOf('border') == 0 || Sa[i].indexOf('outline') == 0 || Sa[i].indexOf('box-shadow') == 0 || Sa[i].indexOf('background') == 0) {
            s += Sa[i] + ': ' + Sa.getPropertyValue(Sa[i]) + '; '
          }
        }
        b = document.createElement('div');
        b.style.cssText = s + ' box-sizing: border-box; width: ' + a.offsetWidth + 'px;';
        a.insertBefore(b, a.firstChild);
        let l = a.childNodes.length;
        for (let i = 1; i < l; i++) {
          b.appendChild(a.childNodes[1]);
        }
        a.style.height = b.getBoundingClientRect().height + 'px';
        a.style.padding = '0';
        a.style.border = '0';
      }
      let Ra = a.getBoundingClientRect(),
        R = Math.round(Ra.top + b.getBoundingClientRect().height - document.querySelector('.footer').getBoundingClientRect().top + 0);  // селектор блока, при достижении верхнего края которого нужно открепить прилипающий элемент;  Math.round() только для IE; если ноль заменить на число, то блок будет прилипать до того, как нижний край элемента дойдёт до футера
      if ((Ra.top - P) <= 0) {
        if ((Ra.top - P) <= R) {
          b.className = 'stop';
          b.style.top = - R + 'px';
        } else {
          b.className = 'sticky';
          b.style.top = P + 'px';
        }
      } else {
        b.className = '';
        b.style.top = '';
      }
      window.addEventListener('resize', function () {
        a.children[0].style.width = getComputedStyle(a, '').width
      }, false);
    }
  })()

  $('.left-sidenav-text-page a').bind("click", function (e) {
    let anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: $(anchor.attr('href')).offset().top - 80
    }, 600);
    e.preventDefault();
  });

});
