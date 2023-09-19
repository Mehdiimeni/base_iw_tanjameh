<?php
require_once "../global/CommonInclude.php";

if (!empty($_POST['gender'])) {
    $gender = strtolower($_POST['gender']);
    $condition = " Enabled = 1 and Name = '$gender' ";

    if ($objORM->DataExist($condition, TableIWNewMenu,'id')) {

        $MenuGroupid = @$objORM->Fetch($condition, "id", TableIWNewMenu)->id;
        $condition = " Enabled = 1 and iw_new_menu_id = $MenuGroupid ";
        if ($objORM->DataExist($condition, TableIWNewMenu2,'id')) {

            $Menu2Groupid = @$objORM->Fetch($condition, "id", TableIWNewMenu2)->id;

            $condition2 = "Enabled = 1 and iw_new_menu_2_id  = $Menu2Groupid ";
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