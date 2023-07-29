<?php
///controller/global/menu.php


function get_menu($gender)
{
    $filds = array('gender' => $gender);
    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('menu/menu', $filds));

}

function get_category($gender,$category)
{
    $filds = array('gender' => $gender ,'category' => $category);
    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('menu/menu2', $filds));

}

