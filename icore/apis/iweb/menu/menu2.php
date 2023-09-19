<?php
require_once "../global/CommonInclude.php";

if (!empty($_POST['gender'])) {
    $gender = strtolower($_POST['gender']);
    $gender_id_key = @$objORM->Fetch("Enabled = 1 and Name = '$gender'", "id", TableIWNewMenu)->id;

    if (!empty($_POST['category'])) {
        $category = $_POST['category'];
        $condition = " Enabled = 1 and Name = '$category' and iw_new_menu_id = $gender_id_key  ";

        if ($objORM->DataExist($condition, TableIWNewMenu2,'id')) {
            $iw_new_menu_2_id = @$objORM->Fetch($condition, "id", TableIWNewMenu2)->id;

            $condition = "Enabled = 1 and iw_new_menu_2_id = $iw_new_menu_2_id  ";
            if ($objORM->DataExist($condition, TableIWNewMenu3)) {
                echo @$objORM->FetchJson(TableIWNewMenu3, $condition, 'Name,LocalName,CatId');
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