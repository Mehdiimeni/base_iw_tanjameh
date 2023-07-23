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
        "iw_user_id = $user_id",
        "id,iw_user_order_status_id,iw_user_address,last_modify",
        TableIWUserShoppingCart
    );
    $arr_shopping_cart = array();

    foreach ($obj_all_shoping_cart as $all_shoping_cart) {

        $status_name = $objORM->Fetch("id = $all_shoping_cart->iw_user_order_status_id ", "status", TableIWUserOrderStatus)->status;
        $address_details = $objORM->Fetch("id = $all_shoping_cart->iw_user_address", "NicName,Address,PostCode", TableIWUserAddressDetails);
        $payment_amount = $objORM->Fetch("iw_user_shopping_cart_id = $all_shoping_cart->id ", "Amount", TableIWAPaymentState)->Amount;
        $currencies_conversion_id = $objORM->Fetch("shopping_cart_id = $all_shoping_cart->id ", "currencies_conversion_id", TableIWAUserInvoice)->currencies_conversion_id;
        $iw_currencies_id2 = $objORM->Fetch("id = $currencies_conversion_id ", "iw_currencies_id2", TableIWACurrenciesConversion)->iw_currencies_id2;
        $currency_name = $objORM->Fetch("id = $iw_currencies_id2 ", "Name", TableIWACurrencies)->Name;

        $arr_shopping_cart[] = array(

            'id' => $all_shoping_cart->id,
            'status_name' => $status_name->id,
            'address_name' => $address_details->NicName,
            'address' => $address_details->Address,
            'post_code' => $address_details->PostCode,
            'last_modify' => $all_shoping_cart->last_modify,
            'payment_amount' => $payment_amount,
            'currency_name' => $currency_name
        );
    }

    echo json_decode($arr_shopping_cart);

} else {
    echo false;
}