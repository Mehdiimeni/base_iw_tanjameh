<?php
///controller/global/top.php


 function get_website_data()
{ 
    $objIAPI = new IAPI($_SERVER['HTTP_HOST'],'iweb');
$objIAPI->SetLocalProjectName('tanjameh');
$objIAPI->GetGeneralApi('global/top_page');
return json_decode( $objIAPI->GetGeneralApi('global/top_page'));


}

function get_website_alert($type)
{ 
    include dirname(__FILE__,4) . "/iassets/include/DBLoader.php";
    $Enabled = BoolEnum::BOOL_TRUE();

   return  @$objORM->Fetch(" Enabled = $Enabled and alert_type = '$type' ", '*', TableIWWebSiteAlert);
}

