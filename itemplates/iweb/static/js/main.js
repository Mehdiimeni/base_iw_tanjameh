// callback for ltr or rtl direction
function callbackOwlCarousel() {
  var mydir = $("html").attr("dir");
  if (mydir == 'rtl') {
      var rtl = true;
      navText = ['<i class="fa-solid fa-arrow-right"></i>', '<i class="fa-solid fa-arrow-left"></i>'];
  }
  else{
      var rtl = false
      var navText = ['<i class="fa-solid fa-arrow-left"></i>','<i class="fa-solid fa-arrow-right"></i>'];
      }
  
  return {rtl , navText};
}
const values = callbackOwlCarousel()
const rtlVal = values.rtl
const navTextVal = values.navText

// carousel index page
jQuery(document).ready(function($) {
    var owl_animIndex = $('.animIndex');
    $('.animIndex').owlCarousel({
      items: 1,
      loop: false,
      nav:true,
      rtl: rtlVal,
      dots:false,
      animateOut: 'fadeOut',
      lazyLoad:true,
      mouseDrag:false,
      touchDrag:false,
      autoplay:true,
      autoplayTimeout:4000,
      autoplayHoverPause:true,
      margin: 10,
      navText : navTextVal,
      navContainer: '.index-owl-nav',
    });
var btn_play=$('.btn-play')
var btn_stop=$('.btn-stop')
    $('.play').on('click',function(){
owl_animIndex.trigger('play.owl.autoplay',[4000]);
btn_play.hide();
btn_stop.fadeIn(500);
})
$('.stop').on('click',function(){
owl_animIndex.trigger('stop.owl.autoplay');
btn_stop.hide();
btn_play.fadeIn(500);
})
// owl center nonloop
$(".owl-item-2").owlCarousel({
  loop: false,
  items:2,
  nav:true,
  rtl: rtlVal,
  lazyLoad:true,
  dots:false,
  navText : navTextVal,
  margin: 17,
});
$('.owl-center-nonloop').owlCarousel({
  loop: false,
  nav:true,
  rtl: rtlVal,
  lazyLoad:true,
  dots:false,
  navText : navTextVal,
  margin: 17,
            responsive:{
    0:{
        items:2,
    },
    700:{
        items:4,
    },
    1000:{
        items:5
    }
}
});

$('.owl-autowidth').owlCarousel({
  autoWidth:true,
  loop: false,
  nav:true,
  rtl: rtlVal,
  lazyLoad:true,
  dots:false,
  navText : navTextVal,
  margin: 17,
            responsive:{
    0:{
        items:2,
    },
    700:{
        items:4,
    },
    1000:{
        items:5
    }
}
});
  });

// click login & register link  
  function goLogin() {
    localStorage.setItem("login", "true");
  }
  function goRegister() {
    localStorage.setItem("register", "true");
  }
  
// validate for disabling form submissions if there are invalid fields
function validateForm() {
  'use strict'
  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.form-validation')
  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }
  form.classList.add('was-validated')
    }, false)
  })
}

// scroll back to top
$(document).ready(function() {
  $(window).scroll(function() {
    if ($(this).scrollTop() > 50) {
      $('#back-to-top').fadeIn();
    } else {
      $('#back-to-top').fadeOut();
    }
  });
  // scroll body to 0px on click
  $('#back-to-top').click(function() {
    $('body,html').animate({
      scrollTop: 0
    }, 400);
    return false;
  });
});

// heart button like and dislike
$(".btn-heart").click(function() {
  var counter = parseFloat($(".heartCounter").text());
  var heartCounter = $(".heartCounter");
  if ( $(this).hasClass( "dislike" ) ) {
    $(this).removeClass("dislike")
    $(this).html('<i class="fa-solid fa-heart text-orange" aria-hidden="true"></i>');
    counter = counter + 1;
    heartCounter.text(counter);
  }
  if ( $(this).hasClass( "like" ) ) {
    $(this).addClass("dislike")
    $(this).html('<i class="fa-regular fa-heart" aria-hidden="true"></i>');
    counter = counter - 1;
    heartCounter.text(counter);
  }
  $(this).toggleClass("like");
});

// change button click brand follow
$(document).on('click', '.clike-follow', function() {

  var brandName = $(this).parent().find(".brandName");

  if ( $(this).hasClass( "notfollow" ) ) {
    $(this).removeClass("notfollow");
    $(this).html('<i class="fa-solid fa-check me-2"></i><span>دنبال شده</span>');
    const toastLiveExample = document.getElementById('brandFollowToast');
    const toast = new bootstrap.Toast(toastLiveExample);
    toast.show()

    if($("#boxBrandSelected")){
      $("#boxBrandSelected").append(
        `
        <li class="brandItem col nav-hover">
          <div class="border-bottom px-1 py-2 d-flex align-items-center">
            <a href="${brandName.attr("data-url")}" class="text-decoration-none text-dark">${brandName.text()}</a>
            <button class="btn border-1 rounded-0 btn-outline-dark ms-auto d-flex align-items-center clike-follow follow"><i class="fa-solid fa-check me-2"></i><span>دنبال شده</span></button>
        </div>
        </li>
        `
      )
    }
  }
  if ( $(this).hasClass( "follow" ) ) {
    $(this).addClass("notfollow");
    $(this).html('<i class="fa-solid fa-plus me-2"></i><span>دنبال کنید</span>');
    
    if($("#boxBrandSelected")){
      $(this).closest(".brandItem").remove();
    }
  }
  $(this).toggleClass("follow");
});

// brand search autocomplete
function brand_search(){
  const search = document.getElementById('brand_search')
const matchList = document.getElementById('brand_match_list')
// Search and filter
const searchBrand = async searchText => {
    const brands = ["adidas","puma","nike","boss","jean","ALDO","ASICS"];
    // Get matches to current text input
    let matchs = brands.filter(user => {
        const regex = new RegExp(`^${searchText}`, 'gi')
        return user.match(regex)
    })
    if (searchText.length === 0) {
        matchs = []
        matchList.innerHTML = ''
    }
    // Output
    outputHtml(matchs);
}
const outputHtml = matchs => {
    if (matchs.length > 0) {
        const html = matchs.map(match => `
            <div class="ms-3 py-2 d-flex border-bottom align-items-center">
              <span class="">${match}</span>
              <button class="btn border-1 rounded-0 btn-outline-dark ms-auto d-flex align-items-center clike-follow notfollow"><i class="fa-solid fa-plus me-2"></i><span>دنبال کنید</span></button>
          </div>
        `).join('')
        matchList.innerHTML = html
    }
}
search.addEventListener('input', () => searchBrand(search.value))
}

// clear icon in input
$(".clearable").each(function() {
  const matchList = document.getElementById('brand_match_list')
  const $inp = $(this).find("input:text"),
  $cle = $(this).find(".clearable__clear");
  $inp.on("input", function(){
  $cle.toggle(!!this.value);
});
$cle.on("touchstart click", function(e) {
  e.preventDefault();
  $inp.val("").trigger("input");
  matchList.innerHTML = ''
  });
});

// select all checkbox
$("#checkall").click(function(){
  if ($(this).hasClass('allChecked')) {
    $('input[type="checkbox"]', '#choiceAll').prop('checked', false);
} else {
    $('input[type="checkbox"]', '#choiceAll').prop('checked', true);
}
$(this).toggleClass('allChecked');     
});

// search whith filter items
 function searchFilter() {
  var input, filter, ul, li, label, i, txtValue;
  input = document.getElementById('search_filter');
  filter = input.value.toUpperCase();
  ul = document.getElementById("ul_search_filter");
  li = ul.getElementsByTagName('li');

  for (i = 0; i < li.length; i++) {
    label = li[i].getElementsByTagName("label")[0];
    // console.log(label.textContent)
    txtValue = label.textContent || label.innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      li[i].style.display = "";
    } else {
      li[i].style.display = "none";
    }
  }
}

// Range Price Slider
function getVals(){
  // Get slider values
  let parent = this.parentNode;
  let slides = parent.getElementsByTagName("input");
    let slide1 = parseFloat( slides[0].value );
    let slide2 = parseFloat( slides[1].value );
  // Neither slider will clip the other, so make sure we determine which is larger
  if( slide1 > slide2 ){ let tmp = slide2; slide2 = slide1; slide1 = tmp; }
  
  let displayElement = parent.getElementsByClassName("rangeValues")[0];
  let rangeMin = document.getElementById("rangeMin");
  let rangeMax = document.getElementById("rangeMax");
  displayElement.innerHTML = slide1 + " تومان  -- " + slide2 + " تومان ";
  rangeMin.setAttribute('data-value', slide1);
  rangeMax.setAttribute('data-value', slide2);
}
window.onload = function(){
  // Initialize Sliders
  let sliderSections = document.getElementsByClassName("range-slider");
      for( let x = 0; x < sliderSections.length; x++ ){
        let sliders = sliderSections[x].getElementsByTagName("input");
        for( let y = 0; y < sliders.length; y++ ){
          if( sliders[y].type ==="range" ){
            sliders[y].oninput = getVals;
            // Manually trigger event first time to display values
            sliders[y].oninput();
          }
        }
      }
}

// show div
function showDiv(){
$('#btn_showDiv').hide();
$('#show_div').fadeIn(100);
$('#show_div').addClass("d-inline-block")
}

// product box change when hover
$(".product-box a").hover(function(){
  var parents = $(this).parents(".product")
  var img = $(this).attr("data-img");
  var price = $(this).attr("data-price");
  var detail = $(this).attr("data-detail");
  var size = [$(this).attr("data-size")];
parents.find(".product-img img").attr("src", img);

// var array = ["New li 1", "New li 2", "New li 3"];
// size.forEach(element => console.log(element));
parents.find('.product-size').empty();
  $.each(size, function( key, value ) {
    parents.find('.product-size').append('<li>' + value + '</li>');
  });

parents.find(".product-price").text(price);
parents.find(".product-detail").text(detail);
});

$(".product-box a").mouseleave(function(){
  var parents = $(this).parents(".product")
  var img = $(".product-box a:first").attr("data-img");
  var detail = $(".product-box a:first").attr("data-detail");
  parents.find(".product-img img").attr("src", img);
  parents.find(".product-detail").text(detail);
});

// feedback 
$("input[name$='feedback']").click(function() {
  $("div#feedback_two").show();
  $("div#feedback_one").hide();
});
$("#feedback_send").click(function(){
  $("div#feedback_three").show();
  $("div#feedback_two").hide();
});
$("#feedback_submit").click(function(){
  $("div#feedback_end").show();
  $("div#feedback_three").hide();
});
$("#feedback_form").submit(function(e) {
  e.preventDefault(); // avoid to execute the actual submit of the form.
  var form = $(this);
  var actionUrl = form.attr('action');
  $.ajax({
      type: "POST",
      url: actionUrl,
      data: form.serialize(), // serializes the form's elements.
      success: function(data)
      {
        console.log(data); 
      }
  });
});

// newsletter submit
$('#newsletter').submit(function (e) {
  e.preventDefault();
  'use strict'
  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.form-validation')
  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }
      if (form.checkValidity()) {
        $form = $(this)
        var formData = new FormData(this);
  $.ajax({
      url: window.location.pathname,
      type: 'POST',
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
        $('#newsletter').toggle(300);
        $('#newsletterResult').append(`
        <i class="fa fa-message fs-1"></i>
        <div>
          <h6 class="fw-bold">Welcome aboard!</h6>
          <h6>we sent you a welcome email</h6>
          <small class="my-3 d-block">amir@hotmail.com</small>
          <h6>you'r subscribe</h6>
        </div>
        `);
      }
    });
        }

  form.classList.add('was-validated')
  })
  });

// dropdown size box in product page
function myDropdown() {
  document.getElementById("myDropdown").classList.toggle("show"); //adding a class show
}
 // Close the dropdown if the user clicks outside of it
 window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
     var dropdowns = document.getElementsByClassName("mydropdown-content");
     var i;
     for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
           openDropdown.classList.remove('show');
        }
     }
  }
}
$("#myDropdown").on('click',function(event){
    event.stopPropagation();
  });

$(".list-size button").click(function(){
  var available = $(this).find(".available").text();
  var btn = $(this).parents(".size-box").find(".dropbtn");
  if (available !== ''){
    btn.text(available);
    btn.val(true);
    document.getElementById("myDropdown").classList.remove("show");
  }else{
    btn.text('انتخاب اندازه');
    btn.val(false);
  }
});

  $(".formNotifyMe").submit(function(e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
      if($(this).parent().find(".was-validated").length !== 0){
        $(this).parent().find('.resultNotify').show(200);
    $(this).hide();
    }
  });

// add to cart
$(function(){
  var total_Price = $("#total-price").text();
  var bag_empty = $("#bag-empty");
  var total_text = $("#total-text");
  var cartTitle = $("#cartTitle")
  if(total_Price == ''){
    bag_empty.addClass("d-block");
  }else{
    bag_empty.removeClass("d-block");
  }
  $("#cart-items").hide();

  $(".cart").mouseenter(function () {
  $("#cart-items").slideDown(100);
  });
  $(".cart").mouseleave(function () {
    $("#cart-items").slideUp(500);
    });

  $(".items-basket").text(($("#list-item-product").children().length));
  
  $("#addToCart").on("click", function () {
    if($(".dropbtn").val() == 'true'){        
      bag_empty.removeClass("d-block");
    total_text.addClass("d-block p-2");
    cartTitle.addClass("d-block") ;
    var deliveryPrice = parseFloat($("#delivery-price").text());
      // add spinner to button cart
      var addToCart = $("#addToCart");
      addToCart.attr('disabled', true);
        addToCart.html(`
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        افزودن به سبد ...
        `);
      setTimeout(function(){
        addToCart.removeClass('btn-dark');
        addToCart.addClass('btn-success');
        addToCart.html('<i class="fa-solid fa-check"></i>');
      }, 1000)
      setTimeout(function(){
        addToCart.prop('disabled', false);
        addToCart.removeClass('btn-success');
        addToCart.addClass('btn-dark');
        addToCart.text('افزودن به سبد خرید');
      }, 3000)

    $("#cart-items").slideDown();
    $(".cartSm").slideToggle(500);
    setTimeout(function(){
     $(".cartSm").slideUp();
      $("#cart-items").slideUp();        
   }, 4000)
    //add items to basket
    $('.item-detail-product').each(function () {
      var brand = $(this).find(".product-brand").text();
      var brandHref = $(this).find(".product-brand").attr('href');
      var name = $(this).find(".product-title").text();
      var firstColorImg = $(this).find("#firstColorImg").attr('src');
      var remove = "<a href='#' class='remove-cart text-decoration-none text-body-tertiary d-inline-block'>حذف مورد</a>";
      var wishList = "<a href='#' class='wishList text-decoration-none text-body-tertiary d-inline-block'>انتقال به علاقمندی</a>";
      var size = $(this).find("#btnSize").text();
      var cena = (parseFloat($(this).find(".prices").children(".product-price").text()));
        $("#list-item-product").addClass("p-2 overflow-y-scroll");
      $("#list-item-product").append(`
      <li class="hstack gap-1 align-items-start mb-5 li-item">
      <img src='${firstColorImg}' class="width-42" alt=""> 
      <div class="b-animate b-dark font-x-s w-100">
        <div class="hstack">
        <a href="${brandHref}" class="d-inline-block text-decoration-none text-dark mb-2">${brand}</a>
        <h6 class="fw-semibold ms-auto"><span class='eachPrice'>${cena}</span> تومان</h6>
        </div>
        <a class="d-block text-decoration-none text-dark fs-6">${name}</a>
        <p class="text-body-secondary m-0">اندازه: <span class="sizeItem">${size}</span></p>
        <p class="text-body-secondary">تعداد: <span>1</span></p>
        ${remove}
        <div class="vr mx-1"></div>
        ${wishList}
      </div>
    </li>
      `);

      //number of items in basket
      $(".items-basket").text(($("#list-item-product").children().length));
      $(".items-basket").text();
      
        //calculate total price
        var totalPrice = 0;
          $(".eachPrice").each(function (){       
            var cenaEach = parseFloat($(this).text());
            totalPrice+=cenaEach;
          });
          $("#total-price").text(totalPrice + deliveryPrice);

    });

    function removeWish(){
      var totalPrice = 0;
      $(".eachPrice").each(function (){ 
        var cenaEach = parseFloat($(this).text());
        totalPrice+=cenaEach;
      });
      $("#total-price").text(totalPrice + deliveryPrice);
      $(".items-basket").text(($("#list-item-product").children().length));

      if(totalPrice == 0){
        bag_empty.addClass("d-block");
        total_text.removeClass("d-block p-2"); 
        cartTitle.removeClass("d-block"); 
          };
    }
    //remove & wish items from basket
    $(".wishList").on('click', function(){
      $(this).parents(".li-item").html('<small class="text-body-secondary m-auto">به لیست علاقمندی، اضافه شد</small>');
      $(this).parents(".li-item").remove();
      removeWish();
    });
    $(".remove-cart").on('click', function(){
      $(this).parents(".li-item").remove();
      removeWish();
    });
    }// end if
    else{
    $(this).addClass("dropbtn");
    myDropdown(); 
    }
    
  });
})

// effect megamenu
$('.has-megamenu').on('show.bs.dropdown', function(e){
  $(this).find('.dropdown-menu').first().stop(true, true).slideDown(300);
});

$('.has-megamenu').on('hide.bs.dropdown', function(e){
  $(this).find('.dropdown-menu').first().stop(true, true).slideUp(300);
});

// helpfull button
$(".btn-helpfull").click(function() {
  if ( $(this).hasClass( "nothelpfull" ) ) {
    $(this).removeClass("nothelpfull")
    $(this).addClass('box-shadow fw-semibold');
    $(this).text('مفیده ؟ ' + '(' + $(this).attr("data-number") + ')');
  }
  if ( $(this).hasClass( "helpfull" ) ) {
    $(this).addClass("nothelpfull")
    $(this).removeClass('box-shadow fw-semibold');
  }
  $(this).toggleClass("helpfull");
});

// image lazy load
let lazyImages = [...document.querySelectorAll(".lazy-image")];
let inAdvance = 300;
function lazyLoad() {
  lazyImages.forEach((image) => {
    if (image.offsetTop < window.innerHeight + window.pageYOffset + inAdvance) {
      image.src = image.dataset.src;
      image.onload = () => image.classList.add("loaded");
    }
    image.parentElement.classList.remove("placeholder");
  });
  // if all loaded removeEventListener
}
lazyLoad();
// window.addEventListener("scroll", _.throttle(lazyLoad, 16));
// window.addEventListener("resize", _.throttle(lazyLoad, 16));

// releases
$(".btn-pluse").click(function(){
  console.log("hiden")
$(this).parents().find(".modal-body").hide();
$(this).parents().find(".modal-footer").hide();
$(this).parents().find(".pluse-form").addClass("d-inline-block");
});

// search all website
$(".icon-search").click(function(){
  $(".search-box").toggleClass("is-active");
  $(".icon-search").toggleClass("not-active");
  $(".search-form input").focus();
});
$("#searchClose").click(function() {
  $(".search-box").removeClass("is-active");
  $(".icon-search").removeClass("not-active");
  $(".search-box input").val("");
});

$(document).click(function() {
  $(".search-box").removeClass("is-active");
  $(".icon-search").removeClass("not-active");
  $(".search-box input").val("");
});
$(".search-box, .search-form").click(function(e) {
    e.stopPropagation();
});

$(document).keypress(function(e) {
  if(e.which == 13) {
    $(".search-box, .search-form").removeClass("is-active");
  $(".icon-search").removeClass("not-active");
    $(".search-box input").val("");
  }
});

// search autocomplete
function all_search(){
  const search = document.getElementById('all_search')
const matchList = document.getElementById('all_match_list')
// Search and filter
const allSearch = async searchText => {
    const items = ["adidas","puma","nike","boss","jean","ALDO","ASICS"];
    // Get matches to current text input
    let matchs = items.filter(user => {
        const regex = new RegExp(`^${searchText}`, 'gi')
        return user.match(regex)
    })
    if (searchText.length === 0) {
        matchs = []
        matchList.innerHTML = ''
    }
    // Output
    outputHtml(matchs);
}
const outputHtml = matchs => {
    if (matchs.length > 0) {
        const html = matchs.map(match => `
            <a href="#" class="nav-link nav-hover py-2 px-4 d-flex border-bottom align-items-center">
              <span class="">${match}</span>
              <i class="fa fa-search ms-auto" aria-hidden="trues"></i>
          </a>
        `).join('')
        matchList.innerHTML = html
    }
}
search.addEventListener('input', () => allSearch(search.value))
}

// feedback helpful
$('.btnPositive').click(function() {
  if($('.btnPositive').html('<i class="fa-regular fa-thumbs-up"></i>')) {
      $('.btnPositive').html('<i class="fa-solid fa-thumbs-up"></i>');
      $('.btnNegative').html('<i class="fa-regular fa-thumbs-down"></i>');
  }
  else {
      $('.btnPositive').html('<i class="fa-regular fa-thumbs-up"></i>');
  }
  });
  
  $('.btnNegative').click(function() {
  if($('.btnNegative').html('<i class="fa-regular fa-thumbs-down"></i>')) {
      $('.btnNegative').html('<i class="fa-solid fa-thumbs-down"></i>');
      $('.btnPositive').html('<i class="fa-regular fa-thumbs-up"></i>');
  }
  else {
      $('.btnNegative').html('<i class="fa-regular fa-thumbs-down"></i>');
  }
  });

  // contact radio order
  $('.radioOrder input[type="radio"]').click(function(){
    var inputValue = $(this).attr("value");
    if(inputValue == 'yes'){
      $(".boxOrder").show();
      $(".orderNumber").show();
    }
    if(inputValue == 'no'){
      $(".boxOrder").show();
      $(".orderNumber").hide();
    }
  });


// filter products
$(".form-filter").submit(function (e) {
  e.preventDefault(); // avoid to execute the actual submit of the form.
  var form = $(this);
  var actionUrl = form.attr('action');
 var uri = new URI();
 var input= form.find('input');
 input.map(function(){
    if ($(this).is(':checked') || $(this).attr('type') == 'range'){
      var data_info= $(this).attr('data-info');
      var data_value= $(this).attr('data-value');
      uri.addQuery(data_info, data_value);
      if((uri.hasQuery("price-min") === true) || (uri.hasQuery("price-max")  === true)){
        uri.setSearch("price-min", $('#rangeMin').attr('data-value'));
        uri.setSearch("price-max", $('#rangeMax').attr('data-value'));
      }
      return false; 
    }
    else{
      var data_info= $(this).attr('data-info');
      var data_value= $(this).attr('data-value');
          uri.removeQuery(data_info, data_value)
          return false; 
        }
      });
      $(this).closest(".dropdown-menu").prev().dropdown("toggle");
  $.ajax({
    type: "POST",
    url: actionUrl,
    data: form.serialize(), // serializes the form's elements.
    success: function (data) {
      window.history.pushState({}, null, uri);
    }
  });
});

