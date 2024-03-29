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


function get_user_acl()
{
    if (!isset($_COOKIE['user_id'])) {
        return false;
    } else {

        if (file_exists('./irepository/log/login/user/' . base64_decode($_COOKIE['user_id']) . '.iw')) {

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

    if (!isset($_COOKIE['user_id'])) {
        
        if (!empty(@$_COOKIE['cart_items'])) {
            $cart_items = json_decode(@$_COOKIE['cart_items'], true);
            if (!empty($cart_items)) {
                return count($cart_items);
            }
        }

    } else {

        $cart_list = array(
            'user_id' => (int) base64_decode($_COOKIE['user_id']),
        );


        $count_cart = (int) $objIAPI->GetPostApi('user/count_cart', $cart_list);
        if (!empty(@$_COOKIE['cart_items'])) {
            $cart_items = json_decode(@$_COOKIE['cart_items'], true);
            if (!empty($cart_items)) {
                $count_cart += count($cart_items);
            }
        }

        return $count_cart;
    }

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


$arr_adver_number = array("1", "2", "3","4");
shuffle($arr_adver_number);

define( 'Shuffle_Page' , $arr_adver_number);