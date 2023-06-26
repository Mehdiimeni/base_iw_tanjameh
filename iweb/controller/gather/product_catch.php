<?php
///controller/gather/product_catch.php
function set_server()
{
    $_SERVER['HTTP_HOST'] != 'localhost' ? $server_address = 'https://'.$_SERVER['HTTP_HOST'] : $server_address = $_SERVER['HTTP_HOST'];

    $objIAPI = new IAPI($server_address, 'iweb');
    $objIAPI->SetLocalProjectName('tanjameh');
    return $objIAPI;
}
function product_catch()
{
    $objIAPI = set_server();
    return json_decode($objIAPI->GetGeneralApi('gather/product_catch'));
}