<?php
///controller/adver/sp_adver_1.php
function get_sp_adver_data($page_name_system, $adver_number)
{
    $objIAPI = set_server();

    $filds = array('page_name_system' => $page_name_system, 'adver_number' => $adver_number);
    return json_decode($objIAPI->GetPostApi('adver/adver_sp', $filds));

}

function get_sp_adver_product($page_name_system, $adver_number)
{
    $objIAPI = set_server();

    $filds = array(
        'page_name_system' => $page_name_system,
        'adver_number' => $adver_number,
        'currencies_conversion_id' => get_currency()
    );
    return json_decode($objIAPI->GetPostApi('adver/adver_product_sp', $filds));
}