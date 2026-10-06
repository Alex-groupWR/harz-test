(function () {
  let a = document.querySelector('.left-sidenav-text-page'), b = null, P = 0;  // если ноль заменить на число, то блок будет прилипать до того, как верхний край окна браузера дойдёт до верхнего края элемента. Может быть отрицательным числом
  // window.addEventListener('scroll', Ascroll, false);
  // document.body.addEventListener('scroll', Ascroll, false);
  function Ascroll() {
    if (document.body.classList.contains('header-showed')) {
      P = 88;
    } else {
      P = 0;
    }

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
    scrollTop: $(anchor.attr('href')).offset().top - 180
  }, 200);
  $(anchor.attr('href')).addClass('active-nav-support');
  setTimeout(function () {
    $(anchor.attr('href')).animate({
      borderWidth: '0px',
      opacity: '1'
    });
    setTimeout(function () {
      $(anchor.attr('href')).animate({
        borderWidth: '2px'
      });
      $(anchor.attr('href')).removeClass('active-nav-support');
    }, 100);
  }, 100);
  e.preventDefault();
  return false;
});
$(document).ready(function () {
  $(".collapse").on('show.bs.collapse', function () {
    $(this).prev(".name-support").find(".fa").removeClass("triangle-right").addClass("triangle-down");
  }).on('hide.bs.collapse', function () {
    $(this).prev(".name-support").find(".fa").removeClass("triangle-down").addClass("triangle-right");
  });

  if ($(".testCompensation__calculator input").length) {
    $(".testCompensation__calculator input").on('keyup', function() {
    //  console.log('key')
      const val = $(this).val();
      if (val.length) {
        const normVal = val.replace(/[^\d,.]*/g, '')
            .replace(/([,.])[,.]+/g, '$1')
            .replace(/^[^\d]*(\d+([.,]\d{0,5})?).*$/g, '$1');

       // console.log(val, normVal, val == normVal, val != normVal)

        if (val != normVal) {
          const parent = $(this.closest('.testCompensation__calculator'))
          const err2 = $(parent).find(".testCompensation__err2");

          if (err2 && err2.length) {
            $(this).val(normVal)
            $(this).hide()
            $(err2).css('display', 'block')
          }
        }
      }
    })
  }

  if ($(".testCompensation__calculator .testCompensation__btn").length) {
    $(".testCompensation__calculator .testCompensation__btn").on('click', function() {
      const parent = $(this.closest('.testCompensation__calculator'))

      if (parent && parent.length) {
        const input = $(parent).find("input");
        const err2 = $(parent).find(".testCompensation__err2");

        if (input && input.length) {
          let val = $(input).val();
          if (val == 0 || val[val.length - 1] == '.' || val[val.length - 1] == ',') {
            const err1 = $(parent).find(".testCompensation__err1");
            $(input).hide()
            $(err1).hide()
            $(err2).css('display', 'block')
          } else {
            $(err2).hide()

            if (!val.length) {
              const err1 = $(parent).find(".testCompensation__err1");

              if (err1 && err1.length) {
                $(input).hide()
                $(err1).css('display', 'block')
              }
            } else {
              $(input).css('display', 'block')
              const copy = $(parent).find(".testCompensation__res-copy");
              const copied = $(parent).find(".testCompensation__res-copied");

              val = val.replace(',', '.');

              const res = (50 / val) * 100

              const result = $(parent).find(".testCompensation__res-text");
              $(result).text(+res.toFixed(3))
              $(copy).css('display', 'block')
              $(copied).hide()
            }
          }
        }
      }
    })
  }

  if ($('.testCompensation__res') && $('.testCompensation__res').length) {
    $('.testCompensation__res').on('click', function() {
      const parent = $(this.closest('.testCompensation__calculator'))

      if (parent && parent.length) {
        const copy = $(parent).find(".testCompensation__res-copy");
        const copied = $(parent).find(".testCompensation__res-copied");
        const res = $(parent).find(".testCompensation__res-text");

        if ($(res) && $(res).text().length) {
          let temp = $("<input>");
          $("body").append(temp);
          temp.val($(res).text()).select();
          document.execCommand("copy");
          temp.remove();
          $(copied).css('display', 'block')
          $(copy).hide()
        }

      }
    })
  }

  if ($('.testCompensation__err') && $('.testCompensation__err').length) {
    $('.testCompensation__err').on('click', function() {
      const parent = $(this.closest('.testCompensation__calculator'))

      if (parent && parent.length) {
        const input = $(parent).find("input");

        if (input && input.length) {
          $(this).hide();
          $(input).css('display', 'block');
        }
      }
    })
  }
});