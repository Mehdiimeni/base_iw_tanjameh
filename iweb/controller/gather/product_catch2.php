<?php
///controller/gather/product_catch2.php
function product_catch2()
{
    $objIAPI = set_server();
    return json_decode($objIAPI->GetGeneralApi('gather/product_catch2'));
}