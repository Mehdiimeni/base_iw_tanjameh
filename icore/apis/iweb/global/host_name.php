<?php

require dirname(__FILE__, 5) . "/vendor/autoload.php";
SessionTools::init();

$objGlobalVar = new GlobalVarTools();

$response = array();
$response['host'] = json_decode($objGlobalVar->ServerVarToJson())->HTTP_HOST;

echo json_encode($response);