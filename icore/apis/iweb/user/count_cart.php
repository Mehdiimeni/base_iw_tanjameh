<?php
require_once "../global/CommonInclude.php";

if (!empty($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $count_cart = $objORM->Fetch("iw_user_id = $user_id", "COUNT(id) as count", TableIWUserTempCart)->count;
    echo $count_cart;
}