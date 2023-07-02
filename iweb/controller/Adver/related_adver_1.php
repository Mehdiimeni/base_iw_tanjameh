<?php
///controller/adver/related_adver_1.php
function get_related_adver_data($page_name_system, $item, $adver_related)
{
    $objIAPI = set_server();

    $filds = array(
        'page_name_system' => $page_name_system,
        'item' => $item,
        'adver_related' => $adver_related
    );
    return json_decode($objIAPI->GetPostApi('adver/adver_related', $filds));

}

function get_related_adver_product($page_name_system, $item, $adver_related)
{
    $objIAPI = set_server();

    $filds = array(
        'page_name_system' => $page_name_system,
        'item' => $item,
        'adver_related' => $adver_related
    );
    return json_decode($objIAPI->GetPostApi('adver/adver_product_related', $filds));
}