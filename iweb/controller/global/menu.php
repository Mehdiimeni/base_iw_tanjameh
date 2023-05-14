<?php
///controller/global/menu.php


function get_menu($gender)
{
    $filds = array('gender' => $gender);
    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('menu/menu', $filds));

}