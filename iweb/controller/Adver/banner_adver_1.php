<?php
///controller/adver/banner_adver_1.php

function get_banner_adver_data($page_name_system,$adver_number)
{
    $objIAPI = set_server();
    
    $filds = array('page_name_system' => $page_name_system, 'adver_number' => $adver_number);
    return json_decode($objIAPI->GetPostApi('adver/adver_banner', $filds));

}

function get_banner_adver_product($page_name_system,$adver_number)
{
    $objIAPI = set_server();
    
    $filds = array('page_name_system' => $page_name_system, 'adver_number' => $adver_number);
    return json_decode($objIAPI->GetPostApi('adver/adver_product', $filds));
}

function get_product_details($IdRow)
{
    $objIAPI = set_server();
    
    $filds = array('id_row' => $IdRow, 'MainUrl'=>$objIAPI->MainUrl , 'LocalName'=>$objIAPI->LocalName );
    return json_decode($objIAPI->GetPostApi('product/adver_product_details', $filds));
}