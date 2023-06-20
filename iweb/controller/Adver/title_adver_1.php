<?php
///controller/adver/title_adver_1.php
function get_title_adver_data($page_name_system,$adver_number)
{
    $objIAPI = set_server();
    
    $filds = array('page_name_system' => $page_name_system, 'adver_number' => $adver_number);
    return json_decode($objIAPI->GetPostApi('adver/adver_title', $filds));

}