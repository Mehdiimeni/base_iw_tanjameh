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

        // give none

        $none_status_id = $objORM->Fetch("status = 'none'", "id", TableIWUserOrderStatus)->id;

        //find cart id if not exist create cart state change when user buy product

        if (!$objORM->DataExist(" iw_user_id = $user_id and iw_user_order_status_id = $none_status_id ", TableIWUserShoppingCart, 'id')) {

            $str_change = "
            iw_user_id= $user_id,
            iw_user_order_status_id = $none_status_id,
            last_modify = '$now_modify',
            modify_id = $user_id,
            modify_ip = '$modify_ip'";

            $shopping_cart_id = $objORM->DataAdd($str_change, TableIWUserShoppingCart);

        } else {

            $shopping_cart_id = $objORM->Fetch(" iw_user_id = $user_id and iw_user_order_status_id = $none_status_id ", "id", TableIWUserShoppingCart)->id;
        }



        $currencies_conversion_id = trim($_POST['currencies_conversion_id']);
        foreach ($_POST['cart_data'] as $key => $value) {

            $obj_product_variants = @$objORM->Fetch(
                "product_id = $key",
                'price_current,iw_api_products_id,id',
                TableIWApiProductVariants
            );

            if (!$objORM->DataExist(" product_id = $key  ", TableIWUserTempCart, 'id')) {

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
            iw_user_shopping_cart_id = $shopping_cart_id,
            last_modify = '$now_modify',
            modify_id = $user_id,
            modify_ip = '$modify_ip'";

                $objORM->DataAdd($str_change, TableIWUserTempCart);

            } else {

                $objORM->DataUpdate(
                    "iw_user_shopping_cart_id = $shopping_cart_id and iw_user_id= $user_id and product_id= $key ",
                    "qty=$value",
                    TableIWUserTempCart

                );
            }

        
            if (isset($_COOKIE['cart_items'])) {
                unset($_COOKIE['cart_items']);
                setcookie('cart_items', '', -1, '/');
            }


        }

        echo true;

    } else {
        echo false;
    }

} else {
    echo false;
}