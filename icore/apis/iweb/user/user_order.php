<?php
require_once "../global/CommonInclude.php";

if (!empty($_POST['user_id'])) {

    $user_id = $_POST['user_id'];
    $cart_id = $_POST['cart_id'];

    $obj_all_shoping_cart = $objORM->FetchAll(
        "user_id = $user_id and user_shopping_cart_id = $cart_id  order by invoice_id asc",
        "*",
        ViewIWUserCart
    );
    $arr_shopping_cart = array();

    $objFileToolsInit = new FileTools("../../../idefine/conf/init.iw");
    $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
    $objShowFile->SetRootStoryFile('./irepository/img/');

    foreach ($obj_all_shoping_cart as $all_shoping_cart) {




        $obj_product_diteils = array();


        $objArrayImage = explode("==::==", $all_shoping_cart->images);
        $objShowFile->ShowImage('../../../../', $objShowFile->FileLocation("attachedimage"), $objArrayImage[0], $all_shoping_cart->product_name, 336, '');
        $image_one_address = $objShowFile->FileLocation("attachedimage") . 'thumbnail/' . $objShowFile->NameChSize($objShowFile->FileLocation("attachedimage"), $objArrayImage[0], 336);



        $arr_shopping_cart[] = array(

            'last_modify' => $all_shoping_cart->last_modify,
            'BankName' => $all_shoping_cart->BankName,
            'TraceNo' => $all_shoping_cart->TraceNo,
            'images_address' => $image_one_address,
            'product_name' => $all_shoping_cart->product_name,
            'payment_amount' => ($all_shoping_cart->amount/10),
            'colour' => $all_shoping_cart->colour,
            'size_text' => $all_shoping_cart->size_text,
            'city' => $all_shoping_cart->city,
            'address' => $all_shoping_cart->address,
            'post_code' => $all_shoping_cart->post_code,
            'country_name' => $all_shoping_cart->country_name,
            'currency_name' => $all_shoping_cart->currency_name,
            'product_id' => $all_shoping_cart->api_products_id
        );
    }

    echo json_encode($arr_shopping_cart);

} else {
    echo false;
}