'use strict';

$(document).ready(function () {
  // FILTERS ON PAGE PRODUCT
  const filterBtns = [
    {id: "materials", title: "Материалы"},
    {id: "merch", title: "Мерч"},
    {id: "test-materials", title: "Тестовые материалы"}
  ];
  filterBtns.forEach(item => {
    const arrowElem = $(`#${item.id}`);
    arrowElem.on("hide.bs.collapse", function (e) {
      if (e.target.id !== item.id) return;
      $(`[href="#${item.id}"]`).html(`<svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M7 6L0.25 11.1962L0.25 0.803848L7 6Z" fill="#867793"/>
      </svg>
       ${item.title}`);

    });
    arrowElem.on("show.bs.collapse", function (e) {
      if (e.target.id !== item.id) return;
      $(`[href="#${item.id}"]`).html(`<svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M6 7L0.803849 0.249999L11.1962 0.25L6 7Z" fill="#40344A"/>
      </svg>
      ${item.title}`);
    });
  });

  $('input:checkbox').on ( 'click', function () {
    if ($(this).is(':checked')) {
      $(this).parent().addClass("checked-elem");
    } else {
      $(this).parent().removeClass("checked-elem");
    }
  });

  $('.checkbox-industrial-printers').on ('click', function () {
    if ($(this).is(':checked')) {
      $(this).parent().addClass("checked-elem");
      $('.industrial-printers').css("display", "block");
      $('.materials-shop').css("display", "none");
      $('.text-form').css("display", "block");
      $('.order-industrial-printers').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        $('.text-form').css("display", "none");
        $('.thanks-order-industrial-printers').css("display", "block");
      });
      $('.btn-thanks-order-industrial-printers').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        $('.thanks-order-industrial-printers').css("display", "none");
        $('.materials-shop').css("display", "block");
        $('.checkbox-industrial-printers').trigger('click');
      });
    } else {
      $(this).parent().removeClass("checked-elem");
      $('.materials-shop').css("display", "block");
      $('.industrial-printers').css("display", "none");
    }
  });
});

let dropdown = document.getElementsByClassName("dropdown-filters-btn");
let i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function () {
    this.classList.toggle("active");
    let dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
let color = 'white'

function getColor(parentSelector, activeClass) {
  const elements = document.querySelectorAll(`${parentSelector} > div`);

  elements.forEach(elem => {
    elem.addEventListener('click', (e) => {
      if (e.target.getAttribute('data-color')) {
        color = e.target.getAttribute('data-color');
      }

      e.currentTarget.classList.toggle(activeClass);
    });
  })

}
getColor('#colors', 'choose-color-item-active');


// СКРОЛЛ ЛЕВОГО МЕНЮ ВВЕРХ ПРИ ПРИБЛИЖЕНИИ К ФУТЕРУ
(function () {
  let a = document.querySelector('.left-sidenav'), b = null, P = 0;  // если ноль заменить на число, то блок будет прилипать до того, как верхний край окна браузера дойдёт до верхнего края элемента. Может быть отрицательным числом
  if(a!=null) {
    window.addEventListener('scroll', Ascroll, false);
    document.body.addEventListener('scroll', Ascroll, false);
  }
  function Ascroll() {
    if (b == null) {

        let Sa = getComputedStyle(a, ''), s = '';
        for (let i = 0; i < Sa.length; i++) {
          if (Sa[i].indexOf('overflow') == 0 || Sa[i].indexOf('padding') == 0 || Sa[i].indexOf('border') == 0 || Sa[i].indexOf('outline') == 0 || Sa[i].indexOf('box-shadow') == 0) {
            // || Sa[i].indexOf('background') == 0
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
      R = Math.round(Ra.top + b.getBoundingClientRect().height - document.querySelector('#footer').getBoundingClientRect().top + 0);  // селектор блока, при достижении верхнего края которого нужно открепить прилипающий элемент;  Math.round() только для IE; если ноль заменить на число, то блок будет прилипать до того, как нижний край элемента дойдёт до футера
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

