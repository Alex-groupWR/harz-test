let map;
let infoWindow;
let infoStorage;
const features = [
  {
    label: "1",
    location: {
      lat: 54.97715835976526,
      lng: 9.507181271163773,
    },
    title: "Limon Dental",
    name: "Limon Dental",
    description:
      "Limon Dental",
  },
  // {
  //   label: "2",
  //   location: {
  //     lat: 54.97715835976526,
  //     lng: 9.507181271163773,
  //   },
  //   title: "SoluNOiD",
  //   name: "SoluNOiD",
  //   description:
  //     "SoluNOiD",
  // },
  {
    label: "3",
    location: {
      lat: 31.223838676637666,
      lng: 29.95235362527242,
    },
    title: "RaSPart",
    name: "RaSPart",
    description:
      "RaSPart",
  },
  {
    label: "4",
    location: {
      lat: 47.525017007317324,
      lng: 19.223180400000004,
    },
    title: "3D NYOMTATO SHOPPE",
    name: "3D NYOMTATO SHOPPE",
    description:
      "3D NYOMTATO SHOPPE",
  },
  {
    label: "5",
    location: {
      lat: 40.631984214213816,
      lng: 22.964888032074388,
    },
    title: "ANASTASIADI A D CO DENTAL PRODUCTS",
    name: "ANASTASIADI A D CO DENTAL PRODUCTS",
    description:
      "ANASTASIADI A D CO DENTAL PRODUCTS",
  },
  {
    label: "6",
    location: {
      lat: 31.88204511553482,
      lng: 34.81034994232754,
    },
    title: "Malisa dent",
    name: "Malisa dent",
    description:
      "Malisa dent",
  }
];

function initMap() {
  const centerMap = {lat: 46.396, lng: -25.065};
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 2.5,
    center: centerMap,
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

  for (const key in features) {
    const feature = features[key];
    const marker = new google.maps.Marker({
      position: feature.location,
      map: map,
      zIndex: 30,
      icon: svgMarker
    });

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
  // Set the map event handlers.
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
  $(".btn-be-dealer").click(function () {
    $(".form-become-dealer").css("display", "none");
    $(this).css("display", "none");
    $(".thanks-be-dealer").css("display", "block");
  });
  // $(".select-items div").last().addClass("other-dealers");
  $(".select-items div").click(function () {
    if ($(".select-items div").last().hasClass('same-as-selected')) {
      $(".no-dealer").css("display", "block");
      $(".dealers-block").css("display", "none");
      $(".page-content .page-section.page-dealers .be-dealer").css({"position": "absolute", "bottom": "59px", "left": "15%", "width": "253px"});
    } else {
      $(".no-dealer").css("display", "none");
      $(".dealers-block").css("display", "block");
      $(".page-content .page-section.page-dealers .be-dealer").css({"position": "relative", "bottom": "inherit", "left": "inherit", "width": "219px", "margin-bottom": "20px"});
    }
  });
});