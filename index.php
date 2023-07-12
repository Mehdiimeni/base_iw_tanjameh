<?php
//index.php 

require "./iweb/vendor/autoload.php";
SessionTools::init();

$objIAPI = new IAPI($_SERVER["HTTP_HOST"], "iweb");
$objIAPI->SetLocalProjectName("tanjameh");


$jsonHost = json_decode($objIAPI->GetGeneralApi("global/host_name"));


if (str_contains($jsonHost->host, "localhost")) {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}


//error_reporting(E_ALL);

$objFileToolsInit = new FileTools("./icore/idefine/conf/init.iw");

(new MakeDirectory)->MKDir("./irepository/log/error/", "iweb", 0755);
$objInitTools = new InitTools($objFileToolsInit->KeyValueFileReader(), "./irepository/log/error/iweb/viewerror.log");


include "./iweb/lang/" . $objInitTools->getLang() . "_web.php";
include "./iweb/lang/" . $objInitTools->getLang() . "_product.php";

require("./iweb/core/caller.php");
require("./iweb/core/urls.php");
exit();