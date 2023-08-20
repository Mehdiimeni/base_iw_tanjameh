<?php
///controller/user/myaccount_look.php


function user_look_page_info()
{
    $filds = array(
        'user_id' =>(int) base64_decode($_COOKIE['user_id'])
    );

    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('look/look_page_info', $filds));
}