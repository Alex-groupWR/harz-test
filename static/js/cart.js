
// let currentTab = 0; // Current tab is set to be the first tab (0)
// showTab(currentTab); // Display the current tab

// function showTab(n) {
//   // This function will display the specified tab of the form...
//   let x = document.getElementsByClassName("tab");
//   x[n].style.display = "block";
//   //... and fix the Previous/Next buttons:
//   if (n === 0) {
//     document.getElementById("prevBtn").style.display = "none";
//   } else {
//     document.getElementById("prevBtn").style.display = "inline";
//   }
//   if (n === (x.length - 1)) {
//     document.getElementById("nextBtn").innerHTML = "В магазин";
//   } else {
//     document.getElementById("nextBtn").innerHTML = "Оформить заказ";
//   }
//   //... and run a function that will display the correct step indicator:
//   fixStepIndicator(n)
// }

// function nextPrev(n) {
//   // This function will figure out which tab to display
//   let x = document.getElementsByClassName("tab");
//   // Exit the function if any field in the current tab is invalid:
//   if (n === 1 && !validateForm()) return false;
//   // Hide the current tab:
//   x[currentTab].style.display = "none";
//   // Increase or decrease the current tab by 1:
//   currentTab = currentTab + n;
//   // if you have reached the end of the form...
//   if (currentTab >= x.length) {
//     // ... the form gets submitted:
//     document.getElementById("orderForm").submit();
//     return false;
//   }
//   // Otherwise, display the correct tab:
//   showTab(currentTab);
// }

// function validateForm() {
//   // debugger;
//   // This function deals with validation of the form fields
//   let x, y, i, valid = true;
//   x = document.getElementsByClassName("tab");
//   y = x[currentTab].getElementsByTagName("input");
//   // A loop that checks every input field in the current tab:
//   for (i = 0; i < y.length; i++) {
//     // remove invalid and correct here
//     y[i].classList.remove("invalid", "correct");

//     // If a field is empty...
//     if (y[i].value === "") {
//       // add an "invalid" class to the field:
//       y[i].className += " invalid";
//       // and set the current valid status to false
//       valid = false;
//     } else { //if (i >= 1) {
//       // add an "correct" class:
//       y[i].className += " correct";
//     }
//   }
//   // If the valid status is true, mark the step as finished and valid:
//   if (valid) {
//     document.getElementsByClassName("step")[currentTab].className += " finish";
//   }
//   return valid; // return the valid status
// }

// function fixStepIndicator(n) {
//   // This function removes the "active" class of all steps...
//   let i, x = document.getElementsByClassName("step");
//   for (i = 0; i < x.length; i++) {
//     x[i].className = x[i].className.replace(" active", "");
//   }
//   //... and adds the "active" class on the current step:
//   x[n].className += " active";
// }

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