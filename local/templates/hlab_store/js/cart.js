let closebtns = document.getElementsByClassName("remove-product-order");
let n;

for (n = 0; n < closebtns.length; n++) {
  closebtns[n].addEventListener("click", function () {
    this.parentNode.style.display = 'none';
  });
}

const containerAddBlock = document.querySelectorAll('.add-block');
for (let j = 0; j < containerAddBlock.length; j++) {
  const currentContainer = containerAddBlock[j];
  const plusElement = currentContainer.querySelector('.plus'),
    minusElement = currentContainer.querySelector('.minus'),
    addProductblock = currentContainer.querySelector('.add-product'),
    priceElement = currentContainer.querySelector('.price');

  let itemsCounter = 1;
  const onPlusClick = () => {
    itemsCounter++;
    updatePrice();
  }
  const onMinusClick = () => {
    itemsCounter = itemsCounter > 1 ? itemsCounter - 1 : 1;
    updatePrice();
  }
  const updatePrice = () => {
    /*if (itemsCounter === 0) {
      addProductblock.classList.remove('active');
      priceElement.value = `1`;
    } else {
      priceElement.value = `${itemsCounter}`;
      addProductblock.classList.add('active');
    }*/
  }


  if (plusElement) {
    plusElement.addEventListener("click", onPlusClick);
  }
  if (minusElement) {
    minusElement.addEventListener("click", onMinusClick);
  }
  updatePrice();
}

const containerWeightBlock = document.querySelectorAll('.choose-weight');

for (let k = 0; k < containerWeightBlock.length; k++) {
  let currentContainerWeight = containerWeightBlock[k];

  let btns = currentContainerWeight.getElementsByClassName("choose-weight-item");
  // debugger;
  for (let i = 0; i < btns.length; i++) {
    btns[i].addEventListener("click", function () {
      let current = currentContainerWeight.getElementsByClassName("choose-weight-item-active");
      current[0].className = current[0].className.replace(" choose-weight-item-active", "");
      this.className += " choose-weight-item-active";
    });
  }
}
$(document).ready(function () {
  $(".input-promo").change(function () {
    $(".name-promo span").innerHTML = $(this).val();
    $(this).addClass("active-promo");
    $(this).placeholder = "Промокод применен!";
  });
});

$(function () {
  $("label input[type=radio]:checked").parent("label").addClass("lblRadioOn");
  $("label.lblRadioOff").click(function () {
    var $radtagname = $(this).find("input:radio").attr("name");
    if ($("label.lblRadioOff radio:checked")) {
      $("input[name=" + $radtagname + "]").each(function () {
        if ($(this).parent("label").hasClass("lblRadioOn")) {
          $(this).parent("label").removeClass("lblRadioOn");
        }
      });
      $(this).addClass("lblRadioOn");
    }
  });
});