// ajax script for On Click Behaver

$('a').click(function (event) {
    var id_basket = $(this).data("basket");
    var id_rebasket = $(this).data("rebasket");
    var id_quickview = $(this).data("quickview");
    var id_comparison = $(this).data("comparison");
    var id_recomparison = $(this).data("recomparison");
    var id_wishlist = $(this).data("wishlist");
    var id_rewishlist = $(this).data("rewishlist");
if(id_basket || id_rebasket || id_comparison || id_recomparison || id_wishlist || id_rewishlist) {
    $.ajax({
        type: 'GET',
        url: '../ijson/OnClickAdd.php',
        data: {
            basket: id_basket,
            rebasket: id_rebasket,
            quickview: id_quickview,
            comparison: id_comparison,
            recomparison: id_recomparison,
            wishlist: id_wishlist,
            rewishlist: id_rewishlist,
            access_token: $("#access_token").val()
        },
        success: function (result) {

            location.reload();

        }
    });
}
});
/*
$('#ShowAddToCart').click(function(){
    var span1_value = document.getElementById("Span1AddCart").innerText;
    span1_value = span1_value+1;
    alert (span1_value);
    $('#AddToCart').find('span').text(span1_value);
});

 */

$(document).ready(function(){
    $(".weight-product").on('change', function postinput(){
        var wproduct = $(this).val(); // this.value
        var productid = $(this).attr('id');
        $.ajax({
            url: '../ijson/OnClickAdd.php',
            data: { w_product: wproduct , product_id : productid },
            type: 'get'
        }).done(function(responseData) {
            console.log('Done: ', responseData);
        }).fail(function() {
            console.log('Failed');
        });
    });
});

$(document).ready(function(){
    $(".weight-main").on('change', function postinput(){
        var wmain = $(this).val(); // this.value
        var mainname = $(this).attr('id');
        $.ajax({
            url: '../ijson/OnClickAdd.php',
            data: { w_main: wmain , main_name : mainname },
            type: 'get'
        }).done(function(responseData) {
            console.log('Done: ', responseData);
        }).fail(function() {
            console.log('Failed');
        });
    });
});

$(document).ready(function(){
    $(".weight-sub").on('change', function postinput(){
        var wsub = $(this).val(); // this.value
        var subname = $(this).attr('id');
        $.ajax({
            url: '../ijson/OnClickAdd.php',
            data: { w_sub: wsub , sub_name : subname },
            type: 'get'
        }).done(function(responseData) {
            console.log('Done: ', responseData);
        }).fail(function() {
            console.log('Failed');
        });
    });
});


$(document).ready(function(){
    $(".weight-sub2").on('change', function postinput(){
        var wsub2 = $(this).val(); // this.value
        var sub2name = $(this).attr('id');
        $.ajax({
            url: '../ijson/OnClickAdd.php',
            data: { w_sub2: wsub2 , sub2_name : sub2name },
            type: 'get'
        }).done(function(responseData) {
            console.log('Done: ', responseData);
        }).fail(function() {
            console.log('Failed');
        });
    });
});


$(document).ready(function(){
    $(".weight-sub4").on('change', function postinput(){
        var wsub4 = $(this).val(); // this.value
        var sub4name = $(this).attr('id');
        $.ajax({
            url: '../ijson/OnClickAdd.php',
            data: { w_sub4: wsub4 , sub4_name : sub4name },
            type: 'get'
        }).done(function(responseData) {
            console.log('Done: ', responseData);
        }).fail(function() {
            console.log('Failed');
        });
    });
});

$(document).ready(function(){
    $(".order_number").on('change', function postinput(){
        var ordernu = $(this).val(); // this.value
        var orderid = $(this).attr('id');
        $.ajax({
            url: '../ijson/OnClickAdd.php',
            data: { order_nu: ordernu , order_id : orderid },
            type: 'get'
        }).done(function(responseData) {
            console.log('Done: ', responseData);
        }).fail(function() {
            console.log('Failed');
        });
    });
});


$(document).ready(function(){
    $(".sorting_number").on('change', function postinput(){
        var sortingnu = $(this).val(); // this.value
        var sortingid = $(this).attr('id');
        $.ajax({
            url: '../ijson/OnClickAdd.php',
            data: { sorting_nu: sortingnu , sorting_id : sortingid },
            type: 'get'
        }).done(function(responseData) {
            console.log('Done: ', responseData);
        }).fail(function() {
            console.log('Failed');
        });
    });
});

$(document).ready(function(){
    $(".tracking_number").on('change', function postinput(){
        var trackingnu = $(this).val(); // this.value
        var trackingid = $(this).attr('id');
        $.ajax({
            url: '../ijson/OnClickAdd.php',
            data: { tracking_nu: trackingnu , tracking_id : trackingid },
            type: 'get'
        }).done(function(responseData) {
            console.log('Done: ', responseData);
        }).fail(function() {
            console.log('Failed');
        });
    });
});

$(document).ready(function(){
    $(".currency_ex").on('change', function postinput(){
        var currencynu = $(this).val(); // this.value
        var currencyid = $(this).attr('id');
        $.ajax({
            url: '../ijson/OnClickAdd.php',
            data: { currency_nu: currencynu , currency_id : currencyid },
            type: 'get'
        }).done(function(responseData) {
            console.log('Done: ', responseData);
        }).fail(function() {
            console.log('Failed');
        });
    });
});
