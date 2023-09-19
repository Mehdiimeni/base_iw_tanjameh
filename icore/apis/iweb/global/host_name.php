<?php
require_once "./CommonInclude.php";

$response = array();
$response['host'] = json_decode($objGlobalVar->ServerVarToJson())->HTTP_HOST;

echo json_encode($response);