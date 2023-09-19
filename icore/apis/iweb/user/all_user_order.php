<?php
require_once "../global/CommonInclude.php";

if (!empty($_POST['user_id'])) {

    $user_id = $_POST['user_id'];

    $obj_all_shoping_cart = $objORM->FetchAll(
        "user_id = $user_id group by user_shopping_cart_id order by invoice_id asc",
        "*",
        ViewIWUserCart
    );
    $arr_shopping_cart = array();

    foreach ($obj_all_shoping_cart as $all_shoping_cart) {

        $arr_shopping_cart[] = array(

            'id' => $all_shoping_cart->user_shopping_cart_id,
            'status_name' => $all_shoping_cart->status,
            'address' => $all_shoping_cart->address,
            'post_code' => $all_shoping_cart->post_code,
            'last_modify' => $all_shoping_cart->last_modify,
            'payment_amount' => ($all_shoping_cart->amount/10),
            'payment_track_number' => $all_shoping_cart->TraceNo,
            'currency_name' => $all_shoping_cart->currency_name
        );
    }

    echo json_encode($arr_shopping_cart);

} else {
    echo false;
}