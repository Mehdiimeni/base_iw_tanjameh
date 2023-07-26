<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";

if (!empty($_POST['user_id'])) {

    $user_id = $_POST['user_id'];

    $obj_all_shoping_cart = $objORM->FetchAll(
        "user_id = $user_id",
        "*",
        ViewIWUserCart
    );
    $arr_shopping_cart = array();

    foreach ($obj_all_shoping_cart as $all_shoping_cart) {

        $arr_shopping_cart[] = array(

            'id' => $all_shoping_cart->id,
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