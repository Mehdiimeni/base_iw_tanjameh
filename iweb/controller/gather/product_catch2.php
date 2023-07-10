<?php
///controller/gather/product_catch2.php
function product_catch2()
{
    $objIAPI = set_server();
    $filds = array(
        'iw_company_id'=> 1 //asos
    );
    return json_decode($objIAPI->GetPostApi('gather/product_catch2', $filds));
}