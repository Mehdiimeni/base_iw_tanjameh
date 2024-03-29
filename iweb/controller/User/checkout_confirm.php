<?php
///controller/user/checkout_confirm.php
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
function get_user_address_default()
{

    if ( base64_decode($_COOKIE['user_id']) == null) {
        return false;
    } else {
        $filds = array('user_id' =>(int) base64_decode($_COOKIE['user_id']));
        $objIAPI = set_server();
        return json_decode($objIAPI->GetPostApi('user/default_address', $filds));

    }

}



function get_user_acl()
{
    if ( base64_decode($_COOKIE['user_id']) == null) {
        return false;
    } else {

        if (file_exists('./irepository/log/login/user/' . base64_decode($_COOKIE['user_id']) . '.iw')) {

            return true;
        } else {
            return false;
        }

    }

}

function get_cart_info()
{
    $cart_items = array('products_id' => @json_decode(@$_COOKIE['cart_items'], true));
    $user_id = array(
        'user_id' =>(int) base64_decode($_COOKIE['user_id']),
        'currencies_conversion_id' => get_currency()
    );

    $filds = array_merge($cart_items, $user_id);

    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('user/cart', $filds));

}