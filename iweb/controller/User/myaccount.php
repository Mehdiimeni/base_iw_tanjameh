<?php
///controller/user/myaccount.php
function last_shopping_cart()
{
    if ( base64_decode($_COOKIE['user_id']) == null) {
        return false;
    } else {
        $filds = array('user_id' =>(int) base64_decode($_COOKIE['user_id']));
        $objIAPI = set_server();
        return json_decode($objIAPI->GetPostApi('user/last_shopping_cart', $filds));

    }
}