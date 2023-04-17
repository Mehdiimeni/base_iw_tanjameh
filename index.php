<?php
//index.php 

require dirname(__FILE__, 1) ."/iweb/vendor/autoload.php";
SessionTools::init();



$objIAPI = new IAPI($_SERVER['HTTP_HOST'],'iweb');
$objIAPI->SetLocalProjectName('tanjameh');

$jsonHost = json_decode( $objIAPI->GetGeneralApi('global/host_name'));

if (str_contains($jsonHost->host,'localhost') )
{
    error_reporting(E_ALL);
}else{
    error_reporting(0);
}

include dirname(__FILE__, 1)."/iweb/lang/" . $objInitTools->getLang() . "_web.php";


require( dirname(__FILE__, 1)."/iweb/core/caller.php");
require( dirname(__FILE__, 1)."/iweb/core/urls.php");
exit();