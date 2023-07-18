<?php
///controller/global/top.php

function set_server()
{
    $_SERVER['HTTP_HOST'] != 'localhost' ? $server_address = 'https://' . $_SERVER['HTTP_HOST'] : $server_address = $_SERVER['HTTP_HOST'];

    $objIAPI = new IAPI($server_address, 'iweb');
    $objIAPI->SetLocalProjectName('tanjameh');
    return $objIAPI;
}

function get_currency($currency_id = 1)
{
    return $currency_id;
}

function get_user_id()
{

    isset($_SESSION['user_id']) ? $UserId = $_SESSION['user_id'] : $UserId = @base64_decode($_COOKIE['user_id']);
    return $UserId;

}

function get_user_acl()
{
    if (get_user_id() == null) {
        return false;
    } else {

        if (file_exists('./irepository/log/login/user/' . get_user_id() . '.iw')) {

            return true;
        } else {
            return false;
        }

    }

}


function get_website_data()
{
    $objIAPI = set_server();
    return json_decode($objIAPI->GetGeneralApi('global/top_page'));

}

function get_website_alert($type)
{
    $objIAPI = set_server();
    return json_decode($objIAPI->GetGeneralApi('global/website_alert'));
}


function get_cart_count()
{
    $objIAPI = set_server();

    $cart_list = array(
        'user_id' => get_user_id(),
    );

    $count_cart = (int) $objIAPI->GetPostApi('user/cart_temp', $cart_list);

    if (!empty(@$_COOKIE['cart_items'])) {
        $cart_items = json_decode(@$_COOKIE['cart_items'], true);
        if (!empty($cart_items)) {
            $count_cart += count($cart_items);
        }
    }

    return $count_cart;

}

function get_favorite_count()
{
    if (!empty(@$_COOKIE['favorite_items'])) {
        $favorite_items = json_decode(@$_COOKIE['favorite_items'], true);
        if (!empty($favorite_items)) {
            return count($favorite_items);
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}