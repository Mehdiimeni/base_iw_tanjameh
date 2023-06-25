<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";


if (isset($_POST['gender'])) {

    $gender = strtolower($_POST['gender']);
    $condition_statement = "  Enabled = 1 AND PGender = '$gender' and ProductType IS NOT NULL  GROUP BY ProductType ORDER BY ProductType ASC limit 16 ";
    if ($objORM->DataExist($condition_statement, TableIWAPIProducts)) {
        echo @$objORM->FetchJsonWhitoutCondition(TableIWAPIProducts, $condition_statement, 'ProductType');
    } else {
        echo false;
    }
} else {
    echo false;
}