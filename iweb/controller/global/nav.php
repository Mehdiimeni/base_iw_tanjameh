<?php
///controller/global/nav.php

function get_nav()
{
    $objIAPI = set_server();
    return json_decode($objIAPI->GetGeneralApi('menu/nav'));
}

function get_user_acl($UserIdKey)
{
    $filds = array('user_idkey'=> $UserIdKey);
    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('user/login',$filds));
}

