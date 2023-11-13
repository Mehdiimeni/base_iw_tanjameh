<?php
///template/temp/down.php
?>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>-->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<script src="./itemplates/iweb/static/js/jquery.min.js"></script>
<script src="./itemplates/iweb/static/js/bootstrap.bundle.min.js"></script>
<script src="./itemplates/iweb/static/owl/owl.carousel.js"></script>
<script src="./itemplates/iweb/static/js/main.js"></script>
<script src="./itemplates/iweb/static/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="./itemplates/iweb/static/js/bootstrap-select.min.js">


<script>

$(function() {
  $('.selectpicker').selectpicker();
});

$(function() {

$('.js-multiple-select').select2({
  tags: true,
  tokenSeparators: [',', ' '],
  placeholder: ''
});

});


  $(document).ready(function () {

    $('button.btn-heart').click(function () {
      var product_id = $(this).val();
      $.ajax({
        url: './ijson/favorite.php',
        type: 'post',
        data: { 'add_to_favorites': true, 'product_id': product_id },
        success: function (response) {
          var favorite_items = JSON.parse($.cookie('favorite_items'));
          $('span.heartCounter').text(favorite_items.length);
        }
      });
    });

    $('button.btn-trash').click(function () {
      var product_id = $(this).data('product-id');
      $.ajax({
        url: './ijson/favorite.php',
        type: 'post',
        data: { 'remove_from_favorites': true, 'product_id': product_id },
        success: function (response) {
          var favorite_items = JSON.parse($.cookie('favorite_items'));
          $('span.heartCounter').text(favorite_items.length);
        }
      });
    });
  });
</script>
<!--
<script>
  const selectElement = document.getElementById('mySelect');
  selectElement.addEventListener('change', (event) => {
    const selectedOption = event.target.options[event.target.selectedIndex];
    var productId = selectedOption.getAttribute('data-product-id');
    var productPrice = selectedOption.getAttribute('data-product-price');
    var value = selectedOption.value;

    $.ajax({
      url: './ijson/set_cart.php',
      type: 'post',
      data: { 'product_id': productId, 'product_count': value , 'product_price': productPrice },
      success: function (response) {

      }
    });
  });
</script>
-->

<script>



  // search autocomplete
 /* function all_search() {
    const search = document.getElementById('all_search')
    const matchList = document.getElementById('all_match_list')
    // Search and filter
    const allSearch = async searchText => {

      fetch('./ijson/search.php')
        .then(response => response.json())
        .then(data => {
          // Work with the JSON data here
          let matchs = data.filter(user => {
            const regex = new RegExp(`^${searchText}`, 'gi')
            return user.match(regex)
          })
          if (searchText.length === 0) {
            matchs = []
            matchList.innerHTML = ''
          }
          // Output
          outputHtml(matchs);
        })
        .catch(error => {
          console.error('Error fetching JSON data:', error);
        });
      // Get matches to current text input

    }
    const outputHtml = matchs => {
      if (matchs.length > 0) {
        const html = matchs.map(match => `
          <a href="?search=${match}" class="nav-link nav-hover py-2 px-4 d-flex border-bottom align-items-center">
            <span class="">${match}</span>
            <i class="fa fa-search ms-auto" aria-hidden="trues"></i>
        </a>
      `).join('')
        matchList.innerHTML = html
      }
    }
    search.addEventListener('input', () => allSearch(search.value))
  }

*/

function handleSearch() {
    const search = document.getElementById('all_search');
    const matchList = document.getElementById('all_match_list');

    const searchAndUpdate = async searchText => {
        fetch('./ijson/search.php')
            .then(response => response.json())
            .then(data => {
                let matches = data.filter(user => {
                    const regex = new RegExp(`^${searchText}`, 'gi');
                    return user.match(regex);
                });

                if (searchText.length === 0) {
                    matches = [];
                    matchList.innerHTML = '';
                }

                outputHtml(matches);
            })
            .catch(error => {
                console.error('Error fetching JSON data:', error);
            });
    };

    const outputHtml = matches => {
        if (matches.length > 0) {
            const html = matches.map(match => `
                <a href="?search=${match}" class="nav-link nav-hover py-2 px-4 d-flex border-bottom align-items-center">
                    <span class="">${match}</span>
                    <i class="fa fa-search ms-auto" aria-hidden="true"></i>
                </a>
            `).join('');

            matchList.innerHTML = html;
        }
    };

    search.addEventListener('input', () => searchAndUpdate(search.value));

    search.addEventListener('keypress', event => {
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent default form submission
            searchAndUpdate(search.value);
            window.location.href = "?search=" + encodeURIComponent(search.value);
        }
    });
}

// Call the function to set up the event listeners
handleSearch();




</script>

</body>

</html>