<?php
require_once "../global/CommonInclude.php";


if (
    !empty($_POST['user_id'])
) {

    $user_id = $objACLTools->CleanStr($_POST['user_id']);
    echo @$objORM->FetchJson(ViewIWUserAddress, " enabled = 1 and user_id = $user_id  ", "*","is_default DESC , id DESC");


} else {
    echo false;
}