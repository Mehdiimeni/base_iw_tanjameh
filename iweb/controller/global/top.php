<?php
///controller/global/top.php

function set_server()
{

    $objIAPI = new IAPI($_SERVER['HTTP_HOST'], 'iweb');
    $objIAPI->SetLocalProjectName('tanjameh');
    return $objIAPI;
}

function get_website_data()
{
    $objIAPI = set_server();
    return json_decode($objIAPI->GetGeneralApi('global/top_page'));

}

function get_website_alert($type)
{
    $objIAPI = set_server();
    return json_decode($objIAPI->GetGeneralApi('global/website_alert'));
}