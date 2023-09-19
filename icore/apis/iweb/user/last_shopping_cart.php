<?php
require_once "../global/CommonInclude.php";

if (!empty($_POST['user_id'])) {
    $user_id = $_POST['user_id'];


    echo $objORM->FetchJson(
        TableIWUserShoppingCart,
        "iw_user_id = $user_id",
        "id,last_modify",
        'id DESC',
        1
    );
} else {
    echo false;
}