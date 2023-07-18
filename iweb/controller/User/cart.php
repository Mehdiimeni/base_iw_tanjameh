<?php
///controller/user/cart.php

function get_cart_info()
{
    $cart_items = array('products_id' => @json_decode(@$_COOKIE['cart_items'], true));
    $user_id = array(
        'user_id' => get_user_id(),
        'currencies_conversion_id' => get_currency()
    );

    $filds = array_merge($cart_items, $user_id);

    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('user/cart', $filds));

}

if (!empty($_GET['delitem'])) {
    $product_id = $_GET['delitem'];
    if (isset($_COOKIE['cart_items'])) {
        $cart_items = json_decode($_COOKIE['cart_items'], true);
    } else {
        $cart_items = array();
    }

    if (in_array($product_id, $cart_items)) {
        unset($cart_items[array_search($product_id, $cart_items)]);
    }
    setcookie('cart_items', json_encode(array_values($cart_items)), time() + 36000, '/');

    if (!empty($_GET['cartid'])) {

        $filds = array(
            'user_id' => get_user_id(),
            'product_id' => $product_id,
            'cart_id' => $_GET['cartid']
        );

        $objIAPI = set_server();
        json_decode($objIAPI->GetPostApi('user/cart_temp_del', $filds));

    }


    echo "<script>window.location.href = './?user=cart';</script>";
}


if (@$_POST['SubmitM'] == 'A') {
    $arr_post = (array) $_POST;
    $promo_code = $arr_post['promo-code'];

    unset($arr_post["SubmitM"]);
    unset($arr_post['promo-code']);

    $cart_list = array(
        'user_id' => get_user_id(),
        'currencies_conversion_id' => get_currency(),
        'promo_code' => $promo_code,
        'cart_data' => $arr_post
    );

    $objIAPI = set_server();
    if (json_decode($objIAPI->GetPostApi('user/cart_temp', $cart_list)))
        echo "<script>window.location.href = './?user=checkout_address';</script>";

}