// hide dropdown cart icon
$(".cart").mouseenter(function () {
    $("#cart-items").removeClass("d-block");
    $("#bag-empty").removeClass("d-block");
});

/* Set rates + misc */
var taxRate = 0.09;
var shippingRate = 15.00; 
var fadeTime = 300;

/* Assign actions */
$('.product-quantity select').change( function() {
  updateQuantity(this);
});

$('.product-removal a').click( function() {
  removeItem(this);
});

$('.wishList').click( function() {
  removeItem(this);
});

/* Recalculate cart */
function recalculateCart()
{
  var subtotal = 0;
  
  /* Sum up row totals */
  $('.product').each(function () {
    subtotal += parseFloat($(this).find('.product-line-price').text());
  });
  
  /* Calculate totals */
  var tax = subtotal * taxRate;
  var shipping = (subtotal > 0 ? shippingRate : 0);
  var total = subtotal + tax + shipping;

//If there is a valid promoCode, and subtotal < 10 subtract from total
var promoPrice = parseFloat($('.promo-value').text());
if (promoPrice) {
  if (subtotal >= 10) {
    total -= promoPrice;
  } else {
    alert('سفارش بایستی بیشتر از 10 تومان باشد');
    $('.summary-promo').addClass('d-none');
    $('.summary-promo').removeClass('d-flex');
  }
}
  
  /* Update totals display */
  $('.totals-value').fadeOut(fadeTime, function() {
    $('#cart-subtotal').html(subtotal.toFixed(2));
    $('#cart-tax').html(tax.toFixed(2));
    $('#cart-shipping').html(shipping.toFixed(2));
    $('#cart-total').html(total.toFixed(2));
    if(total == 0){
      $('.checkout').fadeOut(fadeTime);
      $('.basket-exists').fadeOut(fadeTime);
      $('.basket-null').fadeIn(fadeTime);
    }else{
      $('.checkout').fadeIn(fadeTime);
    }
    $('.totals-value').fadeIn(fadeTime);
  });
}

/* Update quantity */
function updateQuantity(quantityInput)
{
  /* Calculate line price */
  var productRow = $(quantityInput).parent().parent().parent();
  var price = parseFloat(productRow.find('.product-price').text());
  var quantity = $(quantityInput).val();
  var linePrice = price * quantity;
  
  /* Update line price display and recalc cart totals */
  productRow.find('.product-line-price').each(function () {
    $(this).fadeOut(fadeTime, function() {
      $(this).text(linePrice.toFixed(2));
      recalculateCart();
      $(this).fadeIn(fadeTime);
    });
  });  
}

/* Remove item from cart */
function removeItem(removeButton)
{
  /* Remove row from DOM and recalc cart total */
  var productRow = $(removeButton).parent().parent().parent().parent().parent();
  productRow.slideUp(fadeTime, function() {
    productRow.remove();
    recalculateCart();
    //items basket
    $(".items-basket").text(($("#list-item-product li").length));
  });
}

// promotion code
var promoCode;
var promoPrice;

$('.promo-code-cta').click(function() {

  promoCode = $('#promo-code').val();

  if (promoCode == '10off' || promoCode == '10OFF') {
    //If promoPrice has no value, set it as 10 for the 10OFF promocode
    if (!promoPrice) {
      promoPrice = 10;
    } else if (promoCode) {
      promoPrice = promoPrice * 1;
    }
  } else if (promoCode != '') {
    $('.result-promo-code').text('کد تخفیف اشتباه میباشد، لطفا تصحیح نمایید');
    promoPrice = 0;
  }
  //If there is a promoPrice that has been set (it means there is a valid promoCode input) show promo
  if (promoPrice) {
    $('.result-promo-code').text("کد تخفیف اعمال شد");
    $('.summary-promo').removeClass('d-none');
    $('.summary-promo').addClass('d-flex');
    $('.promo-value').text(promoPrice.toFixed(2));
    recalculateCart(true);
  }
});

// input promotion show button cta
$("#promo-code").on("input", function() {
  $(this).next().toggle(this.value != "");
});

// validation form
var spinner = $('#loader');
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()

      }
      // show spinner when validation form
      if (form.checkValidity()) {
      console.log("validation");
      spinner.show();
      }

      form.classList.add('was-validated')
    }, false)
  })
})()

// show choice address
$(".show-choice-address").click(function(){
  $(".delivery-address").toggle();
$(".choice-address").toggle();
});










