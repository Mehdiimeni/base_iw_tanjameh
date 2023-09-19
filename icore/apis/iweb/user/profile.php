<?php
require_once "../global/CommonInclude.php";

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

