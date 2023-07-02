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

        $MenuGroupIdKey = @$objORM->Fetch($condition, "IdKey", TableIWNewMenu)->IdKey;
        $condition = " Enabled = 1 and GroupIdKey = '$MenuGroupIdKey' ";
        if ($objORM->DataExist($condition, TableIWNewMenu2)) {

            $Menu2GroupIdKey = @$objORM->Fetch($condition, "IdKey", TableIWNewMenu2)->IdKey;

            $condition2 = "Enabled = 1 and GroupIdKey = '$Menu2GroupIdKey' and NewMenuId = '$MenuGroupIdKey ' ";
            if ($objORM->DataExist($condition2, TableIWNewMenu3)) {
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
} else {
    echo false;
}