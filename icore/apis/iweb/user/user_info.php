<?php
require_once "../global/CommonInclude.php";


if (
    !empty($_POST['user_id'])
) {

    $iw_user_id = $objACLTools->CleanStr($_POST['user_id']);

    echo @$objORM->FetchJson(
        TableIWUser,
        " id = $iw_user_id ",
        '*',
        'id',
        1
    );


} else {
    echo false;
}