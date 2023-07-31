<?php

$objWishlist = isset($_COOKIE["wishlist"]) ? $_COOKIE["wishlist"] : "[]";
$objWishlist = (array) json_decode($objWishlist);

$objComparison = isset($_COOKIE["comparison"]) ? $_COOKIE["comparison"] : "[]";
$objComparison = (array) json_decode($objComparison);

if (!in_array(@$_GET['wishlist'], $objWishlist)) {
    array_push($objWishlist, $_GET['wishlist']);

}


if (isset($_GET['rewishlist'])) {
    $key = array_search(@$_GET['rewishlist'], $objWishlist);
    if (false !== $key) {
        unset($objWishlist[$key]);
    }

}

setcookie("wishlist", json_encode($objWishlist), time() + (80000), "/");


if (!in_array(@$_GET['comparison'], $objComparison)) {
    array_push($objComparison, $_GET['comparison']);

}

if (isset($_GET['recomparison'])) {
    $key = array_search(@$_GET['recomparison'], $objComparison);
    if (false !== $key) {
        unset($objComparison[$key]);
    }

}

setcookie("comparison", json_encode($objComparison), time() + (80000), "/");


require_once "../icore/vendor/autoload.php";
SessionTools::init();
require_once "../icore/idefine/conf/root.php";
require_once "../icore/idefine/conf/tablename.php";


$objGlobalVar = new GlobalVarTools();
$objFileToolsDBInfo = (new FileTools(IW_DEFINE_FROM_PANEL . "conf/online.iw"))->KeyValueFileReader();

if ((new IPTools(IW_DEFINE_FROM_PANEL))->getHostAddressLoad() == 'localhost')
    $objFileToolsDBInfo = (new FileTools(IW_DEFINE_FROM_PANEL . "conf/local.iw"))->KeyValueFileReader();

$objORM = new DBORM((new MySQLConnection($objFileToolsDBInfo))->getConn());
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");

(new MakeDirectory)->MKDir(IW_REPOSITORY_FROM_PANEL . 'log/error/', 'iweb', 0755);
$objInitTools = new InitTools($objFileToolsInit->KeyValueFileReader(), IW_REPOSITORY_FROM_PANEL . 'log/error/iweb/viewerror.log');

/*
$objAddtToCart = isset($_COOKIE["addtocart"]) ? $_COOKIE["addtocart"] : "[]";
$arrAddtToCart = (array)json_decode($objAddtToCart);

if (!in_array(@$_GET['basket'], $arrAddtToCart))
    array_push($arrAddtToCart, @$_GET['basket']);

if (isset($_GET['rebasket'])) {
    $key = array_search(@$_GET['rebasket'], $arrAddtToCart);
    if (false !== $key) {
        unset($arrAddtToCart[$key]);
    }

}
setcookie("addtocart", json_encode($arrAddtToCart), time() + (80000), "/");
*/


// add to TableIWUserTempCart
if (isset($_GET['basket'])) {
    $objAclTools = new ACLTools();
    include IW_DEFINE_FROM_PANEL . "lang/" . $objInitTools->getLang() . ".php";


    $ProductId = @$_GET['basket'];
    $expire_date = date("m-d-Y", strtotime('+1 day'));
    $UserId = @$_SESSION['_IWUserId'];
    $UserSessionId = session_id();


    $Enabled = 1;
    $SCondition = "  ( UserId = '$UserId' or UserSessionId = '$UserSessionId' ) and  ProductId = $ProductId and  expire_date = '$expire_date' ";

    if (!$objORM->DataExist($SCondition, TableIWUserTempCart)) {


        $objTimeTools = new TimeTools();
        $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();




        $now_modify = date("Y-m-d H:i:s");

        $InSet = "";
        $InSet .= " Enabled = $Enabled ,";
        $InSet .= " ProductId = $ProductId ,";
        $InSet .= " expire_date = '$expire_date' ,";
        $InSet .= " UserId = '$UserId' ,";
        $InSet .= " UserSessionId = '$UserSessionId' ,";
        $InSet .= " modify_ip = '$modify_ip' ,";
        $InSet .= " last_modify = '$now_modify' ";

        $objORM->DataAdd($InSet, TableIWUserTempCart);


    }
}



// add weight to product
if (isset($_GET['w_product']) and isset($_GET['product_id'])) {
    $ProductId = @$_GET['product_id'];
    $Weight = @$_GET['w_product'];
    $iw_product_weight_id = $objORM->Fetch(" Weight = '$Weight'", 'id', TableIWWebWeight)->id;

    if ($iw_product_weight_id != null) {
        $objORM->DataUpdate("  ProductId = $ProductId  ", " iw_product_weight_id = '$iw_product_weight_id'", TableIWAPIProducts);
    }

}

// add weight to main
if (isset($_GET['w_main']) and isset($_GET['main_name'])) {
    $Weight = @$_GET['w_main'];
    $main_name = @$_GET['main_name'];
    $iw_product_weight_id = $objORM->Fetch(" Weight = '$Weight'", 'id', TableIWWebWeight)->id;

    if ($iw_product_weight_id != null) {
        $objORM->DataUpdate("  Name = '$main_name'  ", " iw_product_weight_id = '$iw_product_weight_id'", TableIWWebMainMenu);
    }

}


// add weight to sub
if (isset($_GET['w_sub']) and isset($_GET['sub_name'])) {
    $Weight = @$_GET['w_sub'];
    $sub_name = @$_GET['sub_name'];
    $iw_product_weight_id = $objORM->Fetch(" Weight = $Weight", 'id', TableIWWebWeight)->id;

    if ($iw_product_weight_id != null) {
        $objORM->DataUpdate("  Name = '$sub_name'  ", " iw_product_weight_id = $iw_product_weight_id", TableIWNewMenu2);

        $SCondition = " url_category = '$sub_name' ";
        foreach ($objORM->FetchAll($SCondition, 'id,iw_product_weight_id', TableIWAPIProducts) as $ListItem) {

            if ($ListItem->iw_product_weight_id == '') {
                $USet = " iw_product_weight_id = $iw_product_weight_id";
                $UCondition = " id = $ListItem->id ";
                $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);

            } else {
                $WeightInProduct = $objORM->Fetch(" id = '$ListItem->iw_product_weight_id'", 'Weight', TableIWWebWeight)->Weight;

                if ($WeightInProduct >= $Weight) {
                    continue;
                } else {
                    $USet = " iw_product_weight_id = $iw_product_weight_id";
                    $UCondition = " id = $ListItem->id ";
                    $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);

                }

            }
        }
    }

}

// add weight to sub2
if (isset($_GET['w_sub2']) and isset($_GET['sub2_name'])) {
    $Weight = @$_GET['w_sub2'];
    $sub2_name = $objGlobalVar->getUrlEncode(@$_GET['sub2_name']);
    $iw_product_weight_id = $objORM->Fetch(" Weight = '$Weight'", 'id', TableIWWebWeight)->id;

    if ($iw_product_weight_id != null) {
        $objORM->DataUpdate("  Name = '$sub2_name'  ", " iw_product_weight_id = '$iw_product_weight_id'", TableIWNewMenu3);

        $SCondition = " PGroup = '$sub2_name' ";
        foreach ($objORM->FetchAll($SCondition, 'id,iw_product_weight_id', TableIWAPIProducts) as $ListItem) {

            if ($ListItem->iw_product_weight_id == '') {
                $USet = " iw_product_weight_id = '$iw_product_weight_id'";
                $UCondition = " id = $ListItem->id ";
                $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);

            } else {
                $WeightInProduct = $objORM->Fetch(" id = '$ListItem->iw_product_weight_id'", 'Weight', TableIWWebWeight)->Weight;

                if ($WeightInProduct >= $Weight) {
                    continue;
                } else {
                    $USet = " iw_product_weight_id = '$iw_product_weight_id'";
                    $UCondition = " id = $ListItem->id ";
                    $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);

                }

            }
        }
    }

}


// add weight to sub4
if (isset($_GET['w_sub4']) and isset($_GET['sub4_name'])) {
    $Weight = @$_GET['w_sub4'];
    $sub4_name = $objGlobalVar->getUrlEncode(@$_GET['sub4_name']);
    $iw_product_weight_id = $objORM->Fetch(" Weight = '$Weight'", 'id', TableIWWebWeight)->id;

    if ($iw_product_weight_id != null) {
        $objORM->DataUpdate("  Name = '$sub4_name'  ", " iw_product_weight_id = '$iw_product_weight_id'", TableIWNewMenu4);

        $SCondition = " Attribute REGEXP '$sub4_name' ";
        foreach ($objORM->FetchAll($SCondition, 'id,iw_product_weight_id', TableIWAPIProducts) as $ListItem) {

            if ($ListItem->iw_product_weight_id == '') {
                $USet = " iw_product_weight_id = '$iw_product_weight_id'";
                $UCondition = " id = $ListItem->id ";
                $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);

            } else {
                $WeightInProduct = $objORM->Fetch(" id = '$ListItem->iw_product_weight_id'", 'Weight', TableIWWebWeight)->Weight;

                if ($WeightInProduct >= $Weight) {
                    continue;
                } else {
                    $USet = " iw_product_weight_id = '$iw_product_weight_id'";
                    $UCondition = " id = $ListItem->id ";
                    $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);

                }

            }
        }
    }

}


// add weight to product_type
if (isset($_GET['w_product_type']) and isset($_GET['product_type_name'])) {
    $Weight = @$_GET['w_product_type'];
    $product_type_name = $objGlobalVar->getUrlEncode(@$_GET['product_type_name']);
    $iw_product_weight_id = $objORM->Fetch(" Weight = $Weight ", 'id', TableIWWebWeight)->id;



    $obj_product_type = $objORM->Fetch(" Name = '$product_type_name' ", 'id', TableIWApiProductType)->id;

    if ($iw_product_weight_id != null) {
        $objORM->DataUpdate("  Name = '$product_type_name'  ", " iw_product_weight_id = $iw_product_weight_id ", TableIWApiProductType);

        $SCondition = " iw_api_product_type_id = $obj_product_type->id ";
        foreach ($objORM->FetchAll($SCondition, 'id,iw_product_weight_id', TableIWAPIProducts) as $ListItem) {

            if ($ListItem->iw_product_weight_id == '') {
                $USet = " iw_product_weight_id = $iw_product_weight_id ";
                $UCondition = " id = $ListItem->id ";
                $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);

            } else {
                $WeightInProduct = $objORM->Fetch(" id = $ListItem->iw_product_weight_id ", 'Weight', TableIWWebWeight)->Weight;

                if ($WeightInProduct >= $Weight) {
                    continue;
                } else {
                    $USet = " iw_product_weight_id = '$iw_product_weight_id'";
                    $UCondition = " id = $ListItem->id ";
                    $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);

                }

            }
        }
    }

}


// add order number
if (isset($_GET['order_nu']) and isset($_GET['order_id'])) {

    $id = $_GET['order_id'];
    $qty = $_GET['order_nu'];
    $objORM->DataUpdate(" id = $id", " qty = $qty ", TableIWAUserMainCart);

}

// add barcode number
if (isset($_GET['barcode_number']) and isset($_GET['shipping_product_id'])) {

    $barcode_number = $_GET['barcode_number'];
    $shipping_product_id = $_GET['shipping_product_id'];
    $shop_cart_id = $_GET['shop_cart_id'];
    $invoice_id = $_GET['invoice'];

    $UCondition = " id = $shipping_product_id and invoice_id = $invoice_id";
    $USet = " barcode_number = $barcode_number ";
    $objORM->DataUpdate($UCondition, $USet, TableIWShippingProduct);

    $preparation_status_id = $objORM->Fetch("status = 'preparation'", "id", TableIWUserOrderStatus)->id;
    $objORM->DataUpdate(
        "id = $invoice_id ",
        "user_order_status_id = $preparation_status_id  ",
        TableIWAUserInvoice
    );

}


// add tracking number
if (isset($_GET['tracking_nu']) and isset($_GET['packing_nu'])) {

    $tracking_number = $_GET['tracking_nu'];
    $packing_number = $_GET['packing_nu'];
    $shop_cart_id = $_GET['shop_cart_id'];
    $invoice_id = $_GET['invoice'];

    $tracking_number = str_replace(' ', '', $tracking_number);
    $tracking_number = str_replace('-', '', $tracking_number);
    $tracking_number = str_replace('_', '', $tracking_number);

    $USet = " tracking_number = '$tracking_number' ";
    $objORM->DataUpdate(" packing_number = $packing_number ", $USet, TableIWShippingProduct);

    $booking_status_id = $objORM->Fetch("status = 'booking'", "id", TableIWUserOrderStatus)->id;

    foreach ($objORM->FetchAll(" packing_number = $packing_number ", "invoice_id", TableIWShippingProduct) as $ListItem) {
        $objORM->DataUpdate(
            "id = $ListItem->invoice_id ",
            "user_order_status_id = $booking_status_id  ",
            TableIWAUserInvoice
        );
    }

}

// add first page currency
if (isset($_GET['currency_nu']) and isset($_GET['currency_id'])) {

    $Currencyid = $_GET['currency_id'];
    $CurrencyNu = $_GET['currency_nu'];
    $CurrencyNu = str_replace(' ', '', $CurrencyNu);
    $CurrencyNu = explode(".", $CurrencyNu);
    $CurrencyNu = str_replace(',', '', $CurrencyNu[0]);

    $UCondition = " id = $Currencyid";
    $USet = " Rate = $CurrencyNu,";
    $USet .= " modify_ip = '$modify_ip' ,";


    $USet .= " last_modify = '$now_modify' ";
    $objORM->DataUpdate($UCondition, $USet, TableIWACurrenciesConversion);

}