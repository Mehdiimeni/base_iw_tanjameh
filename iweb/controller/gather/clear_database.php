<?php
///controller/gather/clear_database.php


function clear_database()
{
    $objIAPI = set_server();
    $filds = array(
        'iw_company_id'=> 1 //asos
    );
    return json_decode($objIAPI->GetPostApi('gather/clear_database', $filds));
}
