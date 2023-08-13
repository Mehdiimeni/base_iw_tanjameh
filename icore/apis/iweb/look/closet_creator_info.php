<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";
$objFileToolsDBInfo = db_info();
$objORM = db_orm($objFileToolsDBInfo);

if (!empty($_POST['look_id'])) {

    $look_id = $_POST['look_id'];

    if ($objORM->DataExist(" id = $look_id  and enabled = 1 and stat = 1", TableIWUserLookPage)) {

        $user_id = $objORM->Fetch(" id = $look_id ", "user_id", TableIWUserLookPage)->user_id;

        $objFileToolsInit = new FileTools("../../../idefine/conf/init.iw");
        $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
        $objShowFile->SetRootStoryFile('./irepository/img/');


        $obj_all_shoping_cart = $objORM->FetchAll(
            "user_id = $user_id   order by invoice_id asc limit 7",
            "*",
            ViewIWUserCart
        );
        $arr_shopping_cart = array();



        foreach ($obj_all_shoping_cart as $all_shoping_cart) {

            $obj_product_diteils = array();
            $objArrayImage = explode("==::==", $all_shoping_cart->images);
            $image_one_address = $objShowFile->image_address_edit('../../../../', $objShowFile->FileLocation("attachedimage"), $objArrayImage[0], $all_shoping_cart->product_name, 336, '');
            $image_one_address = str_replace('../../../../', '', $image_one_address);


            $arr_shopping_cart[] = array(

                'images_address' => $image_one_address,
                'product_name' => $all_shoping_cart->product_name,
                'colour' => $all_shoping_cart->colour,
                'size_text' => $all_shoping_cart->size_text,
                'product_id' => $all_shoping_cart->api_products_id,
            );
        }

        echo json_encode($arr_shopping_cart);

    } else {
        echo false;
    }

} else {
    echo false;
}