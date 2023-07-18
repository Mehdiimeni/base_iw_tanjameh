<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";

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