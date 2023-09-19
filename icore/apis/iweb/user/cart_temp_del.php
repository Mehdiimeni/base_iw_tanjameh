<?php
require_once "../global/CommonInclude.php";

$now_modify = date("Y-m-d H:i:s");
$modify_ip = (new IPTools('../../../idefine/'))->getUserIP();

if (!empty($_POST['user_id'])) {
    if (!empty($_POST['product_id'])) {
        if (!empty($_POST['cart_id'])) {

            $iw_user_id = $_POST['user_id'];
            $product_id = $_POST['product_id'];
            $iw_user_shopping_cart_id = $_POST['cart_id'];

            $objORM->DeleteRow(
                " iw_user_id = $iw_user_id and product_id = $product_id and  iw_user_shopping_cart_id = $iw_user_shopping_cart_id  ",
                TableIWUserTempCart
            );
        } else {
            echo false;
        }

    } else {
        echo false;
    }

} else {
    echo false;
}