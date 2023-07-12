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
    if (!empty($_POST['cart_data'])) {

        $user_id = $_POST['user_id'];
        $currencies_conversion_id = trim($_POST['currencies_conversion_id']);
        foreach ($_POST['cart_data'] as $key => $value) {

            $obj_product_variants = @$objORM->Fetch(
                "product_id = $key",
                'price_current,iw_api_products_id,id',
                TableIWApiProductVariants
            );


            $str_change = "
            Enabled= 1,
            product_id= $key,
            session_id='',
            qty=$value,
            price='$obj_product_variants->price_current',
            iw_user_id= $user_id,
            currencies_conversion_id = $currencies_conversion_id ,
            promo_code = '',
            iw_api_products_id = $obj_product_variants->iw_api_products_id,
            last_modify = '$now_modify',
            modify_id = $user_id,
            modify_ip = '$modify_ip'";

            $objORM->DataAdd($str_change, TableIWUserTempCart);


        }

        echo true;

    } else {
        echo false;
    }

} else {
    echo false;
}