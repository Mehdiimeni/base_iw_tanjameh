<?php
///controller/user/myaccount_orders.php

function all_user_order()
{
    if ( base64_decode($_COOKIE['user_id']) == null) {
        return false;
    } else {
        $filds = array('user_id' =>(int) base64_decode($_COOKIE['user_id']));
        $objIAPI = set_server();
        return json_decode($objIAPI->GetPostApi('user/all_user_order', $filds));

    }
}