<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";


if (isset($_POST['gender'])) {
    $gender = strtolower($_POST['gender']);
    $condition = " Enabled = 1 and Name = '$gender' ";

    if ($objORM->DataExist($condition, TableIWNewMenu)) {

        $GroupIdKey = @$objORM->Fetch($condition, "IdKey", TableIWNewMenu)->IdKey;
        $condition = " Enabled = 1 and GroupIdKey = '$GroupIdKey' ";
        if ($objORM->DataExist($condition, TableIWNewMenu2)) {
            echo @$objORM->FetchJson(TableIWNewMenu2, $condition, 'Name,LocalName');
        } else {
            echo false;
        }
    } else {
        echo false;
    }
} else {
    echo false;
}