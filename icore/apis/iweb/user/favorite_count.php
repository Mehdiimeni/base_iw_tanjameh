<?php
require_once "../global/CommonInclude.php";

if (!empty($_POST['session_id'])) {

    $session_id = $objACLTools->CleanStr($_POST['session_id']);
    !empty($_POST['user_id']) ? $user_id = $objACLTools->CleanStr(@$_POST['user_id']) : $user_id = 0;
    echo ($objORM->DataCount("(user_id = $user_id or session_id = '$session_id')", TableIWUserFavorite));

} else {

    echo false;

}