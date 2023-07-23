<?php
///controller/user/checkout_address.php
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

    isset($_SESSION['user_id']) and $_SESSION['user_id'] > 0  ? $UserId = $_SESSION['user_id'] : $UserId = (int) base64_decode($_COOKIE['user_id']);
    $_SESSION['user_id'] = $UserId;
    return $UserId;

}

function get_user_acl()
{
    if ( base64_decode($_COOKIE['user_id']) == null) {
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
    if (!empty(@$_COOKIE['cart_items'])) {
        $cart_items = json_decode(@$_COOKIE['cart_items'], true);
        if (!empty($cart_items)) {
            return count($cart_items);
        } else {
            return 0;
        }

    } else {
        return 0;
    }

}
function user_adress($post_all_data)
{


    $filds = array(
        'NicName' => $post_all_data['NicName'],
        'gender' => $post_all_data['gender'],
        'name' => $post_all_data['name'],
        'family' => $post_all_data['family'],
        'iw_country_id' => $post_all_data['iw_country_id'],
        'PostCode' => $post_all_data['PostCode'],
        'OtherTel' => $post_all_data['OtherTel'],
        'city' => $post_all_data['city'],
        'Address' => $post_all_data['Address'],
        'Description' => $post_all_data['Description'],
        'is_default' => $post_all_data['is_default'],
        'user_id' =>(int) base64_decode($_COOKIE['user_id'])
    );
        
    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('user/add_address', $filds));

}


function get_countreis()
{
    $objIAPI = set_server();
    return json_decode($objIAPI->GetGeneralApi('global/countreis'));
}

function get_user_address()
{

    if ( base64_decode($_COOKIE['user_id']) == null) {
        return false;
    } else {
        $filds = array('user_id' =>(int) base64_decode($_COOKIE['user_id']));
        $objIAPI = set_server();
        return json_decode($objIAPI->GetPostApi('user/address', $filds));

    }

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