<?php
///controller/user/myaccount_order_detail.php
function user_order($cart_id)
{
    if (base64_decode($_COOKIE['user_id']) == null) {
        return false;
    } else {
        $filds = array(
            'user_id' => (int) base64_decode($_COOKIE['user_id']),
            'cart_id' => $cart_id
        );
        $objIAPI = set_server();
        return json_decode($objIAPI->GetPostApi('user/user_order', $filds));

    }
}