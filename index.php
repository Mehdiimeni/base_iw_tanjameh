<?php
//index.php 

require dirname(__FILE__, 1) . "/iweb/vendor/autoload.php";
SessionTools::init();

$objIAPI = new IAPI($_SERVER['HTTP_HOST'], 'iweb');
$objIAPI->SetLocalProjectName('tanjameh');


$jsonHost = json_decode($objIAPI->GetGeneralApi('global/host_name'));

/*
if (str_contains($jsonHost->host, 'localhost')) {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}
*/

error_reporting(E_ALL);

$objFileToolsInit = new FileTools(dirname(__FILE__, 1) . "/icore/idefine/conf/init.iw");

(new MakeDirectory)->MKDir(dirname(__FILE__, 1) . '/irepository/log/error/', 'iweb', 0755);
$objInitTools = new InitTools($objFileToolsInit->KeyValueFileReader(), dirname(__FILE__, 1) . '/irepository/log/error/iweb/viewerror.log');

include dirname(__FILE__, 1) . "/iweb/lang/" . $objInitTools->getLang() . "_web.php";




require(dirname(__FILE__, 1) . "/iweb/core/caller.php");
require(dirname(__FILE__, 1) . "/iweb/core/urls.php");
exit();