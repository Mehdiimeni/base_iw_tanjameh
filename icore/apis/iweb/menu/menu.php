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

    if ($objORM->DataExist($condition, TableIWNewMenu,'id')) {

        $MenuGroupIdKey = @$objORM->Fetch($condition, "id", TableIWNewMenu)->id;
        $condition = " Enabled = 1 and iw_new_menu_id = '$MenuGroupIdKey' ";
        if ($objORM->DataExist($condition, TableIWNewMenu2,'id')) {

            $Menu2GroupIdKey = @$objORM->Fetch($condition, "id", TableIWNewMenu2)->id;

            $condition2 = "Enabled = 1 and iw_new_menu_2_id  = '$Menu2GroupIdKey' ";
            if ($objORM->DataExist($condition2, TableIWNewMenu3,'id')) {
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