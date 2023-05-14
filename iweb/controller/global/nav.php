<?php
///controller/global/nav.php

function get_nav()
{
    $objIAPI = set_server();
    return json_decode($objIAPI->GetGeneralApi('menu/nav'));
}

function get_user_acl()
{
    if (get_user_id() == null) {
        return false;
    } else {
        $filds = array('user_idkey' => get_user_id());
        $objIAPI = set_server();
        return $objIAPI->GetPostApi('user/login', $filds);

    }

}