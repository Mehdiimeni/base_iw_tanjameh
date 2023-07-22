<?php
///controller/user/favorite.php


function favorite_product_details( $page_condition)
{

    $cart_items = array('favorite_items' => @json_decode(@$_COOKIE['favorite_items'], true));
    $user_id = array(
        'page_condition' => $page_condition,
        'currencies_conversion_id' => get_currency()
    );

    $filds = array_merge($cart_items, $user_id);

    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('product/favorite_product_details', $filds));
}
