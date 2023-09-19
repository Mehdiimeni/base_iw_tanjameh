<?php
require_once "../global/CommonInclude.php";

if (
    !empty($_POST['user_id'])
) {

    $user_id = $objACLTools->CleanStr($_POST['user_id']);
    echo @$objORM->FetchJson(ViewIWUserAddress, " enabled = 1 and user_id = $user_id ", "*");

} else {
    echo false;
}