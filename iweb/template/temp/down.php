<?php
///template/temp/down.php
?>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>-->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<script src="./itemplates/iweb/static/js/jquery.min.js"></script>
<script src="./itemplates/iweb/static/js/bootstrap.bundle.min.js"></script>
<script src="./itemplates/iweb/static/owl/owl.carousel.js"></script>
<script src="./itemplates/iweb/static/js/main.js"></script>


<script>
$(document).ready(function(){

  $('button.btn-heart').click(function(){
    var product_id = $(this).val();
    $.ajax({
      url: './ijson/favorite.php',
      type: 'post',
      data: {'add_to_favorites': true, 'product_id': product_id},
      success: function(response){
        var favorite_items = JSON.parse($.cookie('favorite_items'));
        $('span.heartCounter').text(favorite_items.length);
      }
    });
  });
  
  $('button.btn-trash').click(function(){
    var product_id = $(this).data('product-id');
    $.ajax({
      url: './ijson/favorite.php',
      type: 'post',
      data: {'remove_from_favorites': true, 'product_id': product_id},
      success: function(response){
        var favorite_items = JSON.parse($.cookie('favorite_items'));
        $('span.heartCounter').text(favorite_items.length);
      }
    });
  });
});
</script>



</body>

</html>