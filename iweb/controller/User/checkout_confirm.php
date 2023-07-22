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

    if (get_user_id() == null) {
        return false;
    } else {
        $filds = array('user_id' => get_user_id());
        $objIAPI = set_server();
        return json_decode($objIAPI->GetPostApi('user/default_address', $filds));

    }

}

function get_user_id()
{

    isset($_SESSION['user_id']) and $_SESSION['user_id'] > 0  ? $UserId = $_SESSION['user_id'] : $UserId = (int) base64_decode($_COOKIE['user_id']);
    $_SESSION['user_id'] = $UserId;
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