<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";
$objFileToolsDBInfo = db_info();
$objORM = db_orm($objFileToolsDBInfo);


if (!empty($_POST['gender'])) {

    $gender = strtolower($_POST['gender']);
    $condition_statement = "  1 ORDER BY rand() ASC limit 16 ";
    if ($objORM->DataExist($condition_statement, TableIWApiBrands, 'id')) {
        echo @$objORM->FetchJsonWhitoutCondition(TableIWApiBrands, $condition_statement, '*');
    } else {
        echo false;
    }
} else {
    echo false;
}