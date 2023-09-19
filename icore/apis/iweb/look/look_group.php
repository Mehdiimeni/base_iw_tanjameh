<?php
require_once "../global/CommonInclude.php";


if (!empty($_POST['user_id'])) {

    $user_id = $objACLTools->CleanStr($_POST['user_id']);
    echo $objORM->FetchJsonWhitoutCondition(TableIWUserLookGroup, "enabled = 1", "id,name");

} else {

    echo false;

}
