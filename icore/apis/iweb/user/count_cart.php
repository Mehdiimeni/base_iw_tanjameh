<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";
$objFileToolsDBInfo = db_info();
$objORM = db_orm($objFileToolsDBInfo);

if (!empty($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $count_cart = $objORM->Fetch("iw_user_id = $user_id", "COUNT(id) as count", TableIWUserTempCart)->count;
    echo $count_cart;
}