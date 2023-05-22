<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


require dirname(__FILE__, 5) . "/vendor/autoload.php";
SessionTools::init();

$objGlobalVar = new GlobalVarTools();

$response = array();
$response['host'] = json_decode($objGlobalVar->ServerVarToJson())->HTTP_HOST;

echo json_encode($response);