function emptyCart() {
  $.ajax({
    url: "Controller/ajax-cartRemove.php",
    type: "POST",
    success: function (data) {
      if (data == "1") {
        location.reload();
      }
    },
  });
}

$(document).on("click", ".emptyBtn", emptyCart);

function checkDark() {
  if (localStorage.getItem("isDarkMode") === "true") {
    document.body.classList.add("dark-mode");
  }
}

$(document).ready(checkDark);

function changeTheme() {
  $("body").toggleClass("dark-mode");
  if (localStorage.getItem("isDarkMode") === "true") {
    localStorage.setItem("isDarkMode", false);
  } else {
    localStorage.setItem("isDarkMode", true);
  }
}

$(document).on("click", ".themeBtn", changeTheme);

function placeOrder() {
  $.ajax({
    url: "Controller/ajax-order.php",
    type: "POST",
    success: function (data) {
      if (data == "1") {
        alert("Order Placed! Thanks for Shopping");
        location.reload();
      }
      else {
        alert("Try again!");
      }
    },
  });
}

$(document).on("click", ".OrderBtn", placeOrder);
