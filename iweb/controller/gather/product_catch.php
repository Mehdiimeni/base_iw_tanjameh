<?php
///controller/gather/product_catch.php
function set_server()
{
    $_SERVER['HTTP_HOST'] != 'localhost' ? $server_address = 'https://'.$_SERVER['HTTP_HOST'] : $server_address = $_SERVER['HTTP_HOST'];

    $objIAPI = new IAPI($server_address, 'iweb');
    $objIAPI->SetLocalProjectName('tanjameh');
    return $objIAPI;
}

function get_currency($currency_id = 1)
{
    return $currency_id;
}
function product_catch()
{
    $objIAPI = set_server();
    $filds = array(
        'iw_company_id'=> 1 //asos
    );
    return json_decode($objIAPI->GetPostApi('gather/product_catch', $filds));
}