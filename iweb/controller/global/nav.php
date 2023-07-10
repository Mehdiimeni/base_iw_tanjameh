<?php
///controller/global/nav.php

function get_nav()
{
    $objIAPI = set_server();
    return json_decode($objIAPI->GetGeneralApi('menu/nav'));
}

