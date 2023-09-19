<?php
require_once "../global/CommonInclude.php";

if (!empty($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    if (!empty($_POST['Name']) and !empty($_POST['CellNumber'])) {


        $Name = $_POST['Name'];
        $CellNumber = $_POST['CellNumber'];
        $NationalCode = $_POST['NationalCode'];
        $Fashionpreference = $_POST['Fashionpreference'];


        $Enabled = true;
        $SCondition = "( CellNumber = '$CellNumber'  or NationalCode = '$NationalCode'  )  and id <> $user_id ";

        if (!$objORM->DataExist($SCondition, TableIWUser, 'id')) {

            $stat = false;
            $stat_detials = "11"; // user not exist or disabled

        } else {

            $Online = true;
            $modify_ip = (new IPTools('../../../idefine/'))->getUserIP();
            $now_modify = date("Y-m-d H:i:s");
            $str_change = " Name= '$Name',CellNumber= '$CellNumber',pre_refrence='$Fashionpreference',NationalCode='$NationalCode' ";
            $objORM->DataUpdate("id = $user_id ", $str_change, TableIWUser);

            $stat = true;
            $stat_detials = "20"; // user edit

        }

    } else {

        $stat = false;
        $stat_detials = "10"; // user or pass null

    }

    $arr_edit_profile_detials = array(
        'stat' => $stat,
        'stat_detials' => $stat_detials,
    );


} else {

    $arr_edit_profile_detials = array(
        'stat' => false,
        'stat_detials' => 12
    );

}

echo json_encode($arr_edit_profile_detials);