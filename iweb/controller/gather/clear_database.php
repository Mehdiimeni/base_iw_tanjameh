<?php
///controller/gather/clear_database.php


function clear_database()
{
    $objIAPI = set_server();
    return json_decode($objIAPI->GetGeneralApi('gather/clear_database'));
}
