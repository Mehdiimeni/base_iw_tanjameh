<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";
if (!empty($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

        $Enabled = true;
        $SCondition = "id <> $user_id  or Enabled = 0 ";

        if (!$objORM->DataExist($SCondition, TableIWUser, 'id')) {

            $stat = false;
            $stat_detials = "11"; // user not exist or disabled

        } else {

            echo @$objORM->FetchJson(TableIWUser, " enabled = 1 and id = $user_id ", "*");

        }


} else {

    echo false;

}

