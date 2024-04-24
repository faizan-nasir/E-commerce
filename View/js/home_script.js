let offset = 3;

function checkDark() {
  if (localStorage.getItem("isDarkMode") === "true") {
    document.body.classList.add("dark-mode");
  }
}

$(document).ready(checkDark);

function defaultLoad() {
  $.ajax({
    url: "Controller/ajax-defaultload.php",
    type: "POST",
    success: function (data) {
      $(".post-container").val();
      $(".post-container").append(data);
    },
  });
}

$(window).on("load", defaultLoad);

function search() {
  if (window.location.href == "http://phpkart.com/home") {
    let search_term = $(".searchBar").val();
    if (search_term != "") {
      $.ajax({
        url: "Controller/ajax-search.php",
        type: "POST",
        data: {
          search: search_term,
        },
        success: function (data) {
          $(".searchBar").val("");
          $(".post-container").html(data);
        },
      });
    }
    else {
      alert("Enter a term to search!");
    }
  }
  else {
    alert("Go to home page to implement search!");
  }
}

$(document).on("click", ".searchBtn", search);

function loadMoreData() {
  $.ajax({
    url: "Controller/ajax-load.php",
    type: "POST",
    data: {
      offset: offset
    },
    success: function (data) {
      if (data == '') {
        alert('No more posts!');
      }
      else {
        $(".post-container").append(data);
        offset += 3;
      }
    },
  });
}

$(document).on("click", ".loadBtn", loadMoreData);

function changeTheme() {
  $("body").toggleClass("dark-mode");
  if (localStorage.getItem("isDarkMode") === "true") {
    localStorage.setItem("isDarkMode", false);
  }
  else {
    localStorage.setItem("isDarkMode", true);
  }
}

$(document).on("click", ".themeBtn", changeTheme);

function addToCart() {
  let product_id = $(this).data('productid');
  $.ajax({
    url: "Controller/ajax-add.php",
    type: "POST",
    data: {
      product_id: product_id,
    },
    success: function (data) {
      if (data == "1") {
        alert("Item added to cart!");
      }
      else {
        alert("Could not add item to cart!");
      }
    },
  });
}

$(document).on("click", ".btn-primary", addToCart);
