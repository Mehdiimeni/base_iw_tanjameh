<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";
$objFileToolsDBInfo = db_info();
$objORM = db_orm($objFileToolsDBInfo);

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