(function () {
  let a = document.querySelector('.left-sidenav-text-page'), b = null, P = 0;  // если ноль заменить на число, то блок будет прилипать до того, как верхний край окна браузера дойдёт до верхнего края элемента. Может быть отрицательным числом
  window.addEventListener('scroll', Ascroll, false);
  document.body.addEventListener('scroll', Ascroll, false);
  function Ascroll() {
    if (b == null) {
      let Sa = getComputedStyle(a, ''), s = '';
      for (let i = 0; i < Sa.length; i++) {
        if (Sa[i].indexOf('overflow') === 0 || Sa[i].indexOf('padding') === 0 || Sa[i].indexOf('border') === 0 || Sa[i].indexOf('outline') === 0 || Sa[i].indexOf('box-shadow') === 0 || Sa[i].indexOf('background') === 0) {
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
if (window.location.hash)
  scroll(0, 0);
// takes care of some browsers issue
setTimeout(function () {scroll(0, 0);}, 1);

$(function () {
  //your current click function
  $('.left-sidenav-text-page a').bind("click", function (e) {
    let anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: $(anchor.attr('href')).offset().top - 180
    }, 600);
    e.preventDefault();
  });
});

$(document).ready(function () {

  $('.slider-documents').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    autoplay: false,
    autoplaySpeed: 2000,
    dots: true,
    responsive: [
      {
        breakpoint: 1025,
        settings: {
          slidesToShow: 3
        }
      },
      {
        breakpoint: 770,
        settings: {
          slidesToShow: 2
        }
      },
      {
        breakpoint: 540,
        settings: {
          slidesToShow: 1,
          centerMode: true,
          centerPadding: '80px'
        }
      },
      {
        breakpoint: 321,
        settings: {
          slidesToShow: 1,
          centerMode: true,
          dots: true,
          centerPadding: '60px'
        }
      }
    ]
  });

  $('.slider-thanks').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    autoplay: false,
    autoplaySpeed: 2000,
    dots: true,
    responsive: [
      {
        breakpoint: 1025,
        settings: {
          slidesToShow: 3
        }
      },
      {
        breakpoint: 770,
        settings: {
          slidesToShow: 2
        }
      },
      {
        breakpoint: 540,
        settings: {
          slidesToShow: 1,
          centerMode: true,
          centerPadding: '80px'
        }
      },
      {
        breakpoint: 321,
        settings: {
          slidesToShow: 1,
          centerMode: true,
          dots: true,
          centerPadding: '60px'
        }
      }
    ]
  });
});

let map;
let infoWindow;
let infoStorage;
const features = [
  {
    location: {
      lat: 55.913262778626375,
      lng: 37.743972198356026,
    },
    title: "ОФИС",
    name: "ОФИС",
    description:
      "141002, Россия, Моск. обл., г. Мытищи, ул. Колпакова, д. 2, стр. 13, офис 265",
  },
  {
    location: {
      lat: 55.945532107792836,
      lng: 37.773841438834395,
    },
    title: "ОФИС",
    name: "ОФИС",
    description:
      "141006, Россия, Моск. обл., г. Мытищи, ул. Силикатная, д. 51А, стр. 6",
  },
  {
    location: {
      lat: 55.69834248296171,
      lng: 37.358133540675446,
    },
    title: "ОФИС",
    name: "ОФИС",
    description:
      "121205, Россия, г. Москва, тер. Инновационного Центра Сколково, Большой б-р, д. 42, стр. 1, помещение 1061",
  },
  {
    location: {
      lat: 56.95671143498952,
      lng: 24.165676942579108,
    },
    title: "ОФИС",
    name: "ОФИС",
    description:
      "Latvia, Braslas iela 22B, Riga, LV-103",
  },
];

function initMap() {
  // The location of centerMap
  const centerMap = {lat: 56.75704493391711, lng: 31.893019259112737};
  // The map, centered at centerMap
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 6,
    center: centerMap,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    styles: [
      {
        "featureType": "water",
        "elementType": "labels.text",
        "stylers": [
          {
            "visibility": "off"
          }
        ]
      },
      {
        "featureType": "water",
        "elementType": "geometry",
        "stylers": [
          {
            "color": "#d5d3dd"
          },
          {
            "lightness": 17
          }
        ]
      },
      {
        "featureType": "landscape",
        "elementType": "geometry",
        "stylers": [
          {
            "color": "#f5f5f5"
          },
          {
            "lightness": 20
          }
        ]
      },
      {
        "featureType": "road.highway",
        "elementType": "geometry.fill",
        "stylers": [
          {
            "color": "#ffffff"
          },
          {
            "lightness": 17
          }
        ]
      },
      {
        "featureType": "road.highway",
        "elementType": "geometry.stroke",
        "stylers": [
          {
            "color": "#ffffff"
          },
          {
            "lightness": 29
          },
          {
            "weight": 0.2
          }
        ]
      },
      {
        "featureType": "road.arterial",
        "elementType": "geometry",
        "stylers": [
          {
            "color": "#ffffff"
          },
          {
            "lightness": 18
          }
        ]
      },
      {
        "featureType": "road.local",
        "elementType": "geometry",
        "stylers": [
          {
            "color": "#ffffff"
          },
          {
            "lightness": 16
          }
        ]
      },
      {
        "featureType": "poi",
        "elementType": "geometry",
        "stylers": [
          {
            "color": "#f5f5f5"
          },
          {
            "lightness": 21
          }
        ]
      },
      {
        "featureType": "poi.park",
        "elementType": "geometry",
        "stylers": [
          {
            "color": "#dedede"
          },
          {
            "lightness": 21
          }
        ]
      },
      {
        "elementType": "labels.text.stroke",
        "stylers": [
          {
            "visibility": "off"
          },
          {
            "color": "#ffffff"
          },
          {
            "lightness": 16
          }
        ]
      },
      {
        "elementType": "labels.text.fill",
        "stylers": [
          {
            "saturation": 89
          },
          {
            "color": "#a6a9b8"
          },
          {
            "lightness": 1
          }
        ]
      },
      {
        "elementType": "labels.icon",
        "stylers": [
          {
            "visibility": "off"
          }
        ]
      },
      {
        "featureType": "transit",
        "elementType": "geometry",
        "stylers": [
          {
            "color": "#f2f2f2"
          },
          {
            "lightness": 19
          }
        ]
      },
      {
        "featureType": "administrative",
        "elementType": "geometry.fill",
        "stylers": [
          {
            "color": "#fefefe"
          },
          {
            "lightness": 20
          }
        ]
      },
      {
        "featureType": "administrative",
        "elementType": "geometry.stroke",
        "stylers": [
          {
            "color": "#fefefe"
          },
          {
            "lightness": 17
          },
          {
            "weight": 1.2
          }
        ]
      }
    ],
  });

  const svgMarker = {
    path:
      "M9.49951 1.18719C7.76795 1.18925 6.10789 1.87802 4.88349 3.10242C3.65909 4.32682 2.97032 5.98688 2.96826 7.71844C2.96826 13.3069 8.90576 17.5281 9.15857 17.7049C9.25855 17.7748 9.37756 17.8122 9.49951 17.8122C9.62146 17.8122 9.74047 17.7748 9.84045 17.7049C10.0933 17.5281 16.0308 13.3069 16.0308 7.71844C16.0287 5.98688 15.3399 4.32682 14.1155 3.10242C12.8911 1.87802 11.2311 1.18925 9.49951 1.18719ZM9.49995 5.34366C9.96968 5.34366 10.4289 5.48295 10.8194 5.74392C11.21 6.00489 11.5144 6.37581 11.6942 6.80979C11.8739 7.24376 11.921 7.72129 11.8293 8.182C11.7377 8.6427 11.5115 9.06589 11.1793 9.39804C10.8472 9.73019 10.424 9.95639 9.96329 10.048C9.50258 10.1397 9.02505 10.0926 8.59107 9.91287C8.1571 9.73312 7.78617 9.42871 7.52521 9.03814C7.26424 8.64757 7.12495 8.18839 7.12495 7.71866C7.12494 7.40677 7.18636 7.09793 7.30571 6.80978C7.42507 6.52162 7.60001 6.2598 7.82055 6.03926C8.04109 5.81872 8.30291 5.64378 8.59106 5.52443C8.87922 5.40508 9.18805 5.34365 9.49995 5.34366Z",
    fillColor: "#7A43A5",
    fillOpacity: 1,
    strokeWeight: 0,
    rotation: 0,
    // scale: 1,
    anchor: new google.maps.Point(19, 19),
  };
  let markers = [];
  for (const key in features) {
    const feature = features[key];
    const marker = new google.maps.Marker({
      position: feature.location,
      // map: map,
      icon: svgMarker
    });
    markers.push(marker);

    marker.addListener("click", () => {
      if (infoWindow) {
        infoWindow.close();
      }

      // Create and open a new InfoWindow
      createInfoWindow(feature, marker);
      // Define origin as the selected marker position
      map.directionsOptions = {
        origin: feature.location,
      };
      map.setZoom(15);
      map.setCenter(marker.getPosition());
    });
  }

  let mcOptions = {
    styles: [{
      url: '../img/circle.png',
      anchorText: [8, 1],
      textColor: "#fff;",
      height: 28,
      width: 28
    }],
  };
  let markerCluster = new MarkerClusterer(map, markers, mcOptions);
  map.addListener("placedetailsviewshowstart", () => {
    if (infoWindow) {
      infoWindow.close();
    }
  });
  map.addListener("placedetailsviewhidestart", () => {
    if (infoStorage) {
      createInfoWindow(infoStorage.feature, infoStorage.marker);
    }
  });
}
function createInfoWindow(feature, marker) {
  // Build the content of the InfoWindow
  const contentDiv = document.createElement("div");
  const nameDiv = document.createElement("div");
  const descriptionDiv = document.createTextNode(feature.description);
  contentDiv.classList.add("infowindow-content");
  nameDiv.classList.add("title");
  nameDiv.textContent = feature.name;
  descriptionDiv.textContent = feature.description;
  contentDiv.appendChild(nameDiv);
  contentDiv.appendChild(descriptionDiv);
  // Create and open a new InfoWindow
  infoWindow = new google.maps.InfoWindow();
  infoWindow.setContent(contentDiv);
  infoWindow.open(map, marker);
  // Store key properties of the InfoWindow for future restoration
  infoStorage = {
    feature: feature,
    marker: marker,
  };
  // Clear content storage if infoWindow is closed by the user
  infoWindow.addListener("closeclick", () => {
    if (infoStorage) {
      infoStorage = null;
    }
  });
}

$(document).ready(function () {
  if (window.innerWidth >= 1200) {
    $(window).scroll(function () {
      let currentScroll = $(this).scrollTop();
      if (currentScroll > 0) {
        $(".yellow-letters").animate({
          left: `${currentScroll - 225}px`
        }, 0);
        $("#slogan").animate({
          right: `${currentScroll - 80}px`
        }, 0);
      }
    });
  }
});

$('[data-fancybox="gallery"]').fancybox({
  protect: true,
  buttons: [
    'zoom',
    'thumbs',
    'close'
  ]
});

$(document).ready(function () {
  $(".btn-get-job").click(function () {
    $(".form-get-job").css("display", "none");
    $(this).css("display", "none");
    $(".thanks-get-job").css("display", "block");
  });
});

$(".custom-file-input").on("change", function () {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});