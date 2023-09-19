<?php
require_once "../global/CommonInclude.php";

if (!empty($_POST['user_id'])) {

    $user_id = $_POST['user_id'];


    $obj_all_shoping_cart = $objORM->FetchAll(
        "user_id = $user_id group by product_id order by invoice_id DESC  ",
        "*",
        ViewIWUserCart
    );
    $arr_shopping_cart = array();



    foreach ($obj_all_shoping_cart as $all_shoping_cart) {

        $arr_shopping_cart[] = array(

            'product_name' => $all_shoping_cart->product_name,
            'product_id' => $all_shoping_cart->api_products_id,
        );
    }

    echo json_encode($arr_shopping_cart);


} else {
    echo false;
}