'use strict';

$(document).ready(function () {
  // FILTERS ON PAGE PRODUCT
  const filterBtns = [
    {id: "ourProducts", title: "Наши продукты"},
    {id: "decorations", title: "Отделка"},
    {id: "print", title: "Печать"},
    {id: "overviewMaterials", title: "Обзор материалов"}
  ];
  filterBtns.forEach(item => {
    $(`#${item.id}`).on("hide.bs.collapse", function (e) {
      if (e.target.id !== item.id) return;
      $(`[href="#${item.id}"]`).html(`${item.title} <svg width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M7 5.5L0.25 10.2631L0.25 0.73686L7 5.5Z" fill="#867793"/>
      </svg>
      `);

    });
    $(`#${item.id}`).on("show.bs.collapse", function (e) {
      if (e.target.id !== item.id) return;
      $(`[href="#${item.id}"]`).html(`${item.title} <svg width="11" height="7" viewBox="0 0 11 7" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M5.5 7L0.736861 0.249999L10.2631 0.25L5.5 7Z" fill="#40344A"/>
      </svg>
      `);
    });
  });

  $('input:checkbox').click(function () {
    if ($(this).is(':checked')) {
      $(this).parent().addClass("checked-elem");
    } else {
      $(this).parent().removeClass("checked-elem");
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
  let a = document.querySelector('#leftSidenav'), b = null, P = 0;  // если ноль заменить на число, то блок будет прилипать до того, как верхний край окна браузера дойдёт до верхнего края элемента. Может быть отрицательным числом
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

function highlight(node, selectedElem) {
  if (selectedElem) {
    selectedElem.classList.remove('active');
  }
  node.classList.add('active');
}

let yesOrNo = document.getElementById("yesOrNo");
let selectedYesNo = null;
yesOrNo.addEventListener('click', function (event) {
  let target = event.target;
  if (target.classList.contains('elem')) {
    highlight(target, selectedYesNo);
    selectedYesNo = target;
  }
});

let selectHeight = document.getElementById("selectHeight");
let selectedHeight = selectHeight.children[0];
selectHeight.addEventListener('click', function (event) {
  let target = event.target;
  if (target.classList.contains('elem')) {
    highlight(target, selectedHeight);
    selectedHeight = target;
  }
});

let selectSlicer = document.getElementById("selectSlicer");
let selectedSlicer = null;
selectSlicer.addEventListener('click', function (event) {
  let target = event.target.nodeName === 'IMG' ? event.target.parentNode : event.target;
  if (target.classList.contains('switchSlicer')) {
    highlight(target, selectedSlicer);
    selectedSlicer = target;
  }
});
