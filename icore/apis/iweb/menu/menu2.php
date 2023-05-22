<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include dirname(__FILE__, 4) . "/iassets/include/DBLoader.php";

$gender = strtolower($_POST['gender']);
$category = $_POST['category'];
$GroupIdKey = @$objORM->Fetch( " Enabled = 1 and Name = '$category' ", "IdKey" , TableIWNewMenu2)->IdKey;
echo @$objORM->FetchJson(TableIWNewMenu3, " Enabled = 1 and GroupIdKey = '$GroupIdKey' ", 'Name,LocalName');