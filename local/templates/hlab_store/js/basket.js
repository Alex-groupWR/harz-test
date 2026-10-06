'use strict';

let weight = 'kilo';

function getInformation(parentSelector, activeClass) {
  const elements = document.querySelectorAll(`${parentSelector} div`);

  elements.forEach(elem => {
    elem.addEventListener('click', (e) => {
      if (e.target.getAttribute('data-color')) {
        color = e.target.getAttribute('data-color');
      } else {
        weight = e.target.getAttribute('id');
      }

      elements.forEach(elem => {
        elem.classList.remove(activeClass);
      })

      const targetElement = e.target.nodeName === 'SPAN' ? e.target.parentNode : e.target;
      targetElement.classList.add(activeClass);

    });
  })

}

getInformation('#weightBusket', 'choose-weight-item-active');
getInformation('#weightBusket2', 'choose-weight-item-active');
getInformation('#weightBusket3', 'choose-weight-item-active');

getInformation('#color', 'choose-color-item-active');
getInformation('#colorProduct', 'choose-color-item-active');



// price

const plusElement = document.querySelector('.plus'),
  minusElement = document.querySelector('.minus'),
  addProductblock = document.querySelector('.add-product'),
  priceElement = document.querySelector('.price');

let itemsCounter = 1;
const onPlusClick = (e) => {
  itemsCounter++;
  updatePrice();
}
const onMinusClick = (e) => {
  itemsCounter = itemsCounter > 1 ? itemsCounter - 1 : 1;
  updatePrice();
}
const updatePrice = () => {
  if (itemsCounter === 0) {
    addProductblock.classList.remove('active');
    priceElement.value = `1`;
  } else {
    priceElement.value = `${itemsCounter}`;
    addProductblock.classList.add('active');
  }
}


if (plusElement) {
  plusElement.addEventListener("click", onPlusClick);
}
if (minusElement) {
  minusElement.addEventListener("click", onMinusClick);
}
updatePrice();


let removebtns = document.getElementsByClassName("remove-product-cart");
let q;

for (n = 0; n < removebtns.length; n++) {
  removebtns[n].addEventListener("click", function () {
    this.parentNode.style.display = 'none';
  });
}