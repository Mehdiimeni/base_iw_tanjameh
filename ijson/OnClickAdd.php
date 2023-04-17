<?php

$objWishlist = isset($_COOKIE["wishlist"]) ? $_COOKIE["wishlist"] : "[]";
$objWishlist = (array)json_decode($objWishlist);

$objComparison = isset($_COOKIE["comparison"]) ? $_COOKIE["comparison"] : "[]";
$objComparison = (array)json_decode($objComparison);

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
    $strExpireDate = date("m-d-Y", strtotime('+1 day'));
    $UserIdKey = @$_SESSION['_IWUserIdKey'];
    $UserSessionId = session_id();


    $Enabled = 1;
    $SCondition = "  ( UserIdKey = '$UserIdKey' or UserSessionId = '$UserSessionId' ) and  ProductId = '$ProductId' and  ExpireDate = '$strExpireDate' ";

    if (!$objORM->DataExist($SCondition, TableIWUserTempCart)) {


        $objTimeTools = new TimeTools();
        $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
        $ModifyTime = $objTimeTools->jdate("H:i:s");
        $ModifyDate = $objTimeTools->jdate("Y/m/d");


        $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;

        $InSet = "";
        $InSet .= " Enabled = '$Enabled' ,";
        $InSet .= " ProductId = '$ProductId' ,";
        $InSet .= " ExpireDate = '$strExpireDate' ,";
        $InSet .= " UserIdKey = '$UserIdKey' ,";
        $InSet .= " UserSessionId = '$UserSessionId' ,";
        $InSet .= " ModifyIP = '$ModifyIP' ,";
        $InSet .= " ModifyTime = '$ModifyTime' ,";
        $InSet .= " ModifyDate = '$ModifyDate' ,";
        $InSet .= " ModifyStrTime = '$ModifyStrTime' ";

        $objORM->DataAdd($InSet, TableIWUserTempCart);


    }
}
// del from TableIWUserTempCart
if ($_GET['rebasket']) {
    $ProductId = @$_GET['rebasket'];
    $UserIdKey = @$_SESSION['_IWUserIdKey'];
    $UserSessionId = session_id();
    $objORM->DeleteRow(" ProductId = '$ProductId' and ( UserIdKey = '$UserIdKey' or UserSessionId = '$UserSessionId' )  ", TableIWUserTempCart);
}


// add weight to product
if (isset($_GET['w_product']) and isset($_GET['product_id'])) {
    $ProductId = @$_GET['product_id'];
    $Weight = @$_GET['w_product'];
    $WeightIdKey = $objORM->Fetch(" Weight = '$Weight'", 'IdKey', TableIWWebWeightPrice)->IdKey;

    if ($WeightIdKey != null) {
        $objORM->DataUpdate("  ProductId = '$ProductId'  ", " WeightIdKey = '$WeightIdKey'", TableIWAPIProducts);
    }

}

// add weight to main
if (isset($_GET['w_main']) and isset($_GET['main_name'])) {
    $Weight = @$_GET['w_main'];
    $main_name = @$_GET['main_name'];
    $WeightIdKey = $objORM->Fetch(" Weight = '$Weight'", 'IdKey', TableIWWebWeightPrice)->IdKey;

    if ($WeightIdKey != null) {
        $objORM->DataUpdate("  Name = '$main_name'  ", " WeightIdKey = '$WeightIdKey'", TableIWWebMainMenu);
    }

}


// add weight to sub
if (isset($_GET['w_sub']) and isset($_GET['sub_name'])) {
    $Weight = @$_GET['w_sub'];
    $sub_name = $objGlobalVar->getUrlEncode(@$_GET['sub_name']);
    $WeightIdKey = $objORM->Fetch(" Weight = '$Weight'", 'IdKey', TableIWWebWeightPrice)->IdKey;

    if ($WeightIdKey != null) {
        $objORM->DataUpdate("  Name = '$sub_name'  ", " WeightIdKey = '$WeightIdKey'", TableIWWebSubMenu);

        $SCondition = " PCategory = '$sub_name' ";
        foreach ($objORM->FetchAll($SCondition, 'IdKey,WeightIdKey', TableIWAPIProducts) as $ListItem) {

            if ($ListItem->WeightIdKey == '') {
                $USet = " WeightIdKey = '$WeightIdKey'";
                $UCondition = " IdKey = '$ListItem->IdKey' ";
                $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);

            } else {
                $WeightInProduct = $objORM->Fetch(" IdKey = '$ListItem->WeightIdKey'", 'Weight', TableIWWebWeightPrice)->Weight;

                if ($WeightInProduct >= $Weight) {
                    continue;
                } else {
                    $USet = " WeightIdKey = '$WeightIdKey'";
                    $UCondition = " IdKey = '$ListItem->IdKey' ";
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
    $WeightIdKey = $objORM->Fetch(" Weight = '$Weight'", 'IdKey', TableIWWebWeightPrice)->IdKey;

    if ($WeightIdKey != null) {
        $objORM->DataUpdate("  Name = '$sub2_name'  ", " WeightIdKey = '$WeightIdKey'", TableIWWebSub2Menu);

        $SCondition = " PGroup = '$sub2_name' ";
        foreach ($objORM->FetchAll($SCondition, 'IdKey,WeightIdKey', TableIWAPIProducts) as $ListItem) {

            if ($ListItem->WeightIdKey == '') {
                $USet = " WeightIdKey = '$WeightIdKey'";
                $UCondition = " IdKey = '$ListItem->IdKey' ";
                $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);

            } else {
                $WeightInProduct = $objORM->Fetch(" IdKey = '$ListItem->WeightIdKey'", 'Weight', TableIWWebWeightPrice)->Weight;

                if ($WeightInProduct >= $Weight) {
                    continue;
                } else {
                    $USet = " WeightIdKey = '$WeightIdKey'";
                    $UCondition = " IdKey = '$ListItem->IdKey' ";
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
    $WeightIdKey = $objORM->Fetch(" Weight = '$Weight'", 'IdKey', TableIWWebWeightPrice)->IdKey;

    if ($WeightIdKey != null) {
        $objORM->DataUpdate("  Name = '$sub4_name'  ", " WeightIdKey = '$WeightIdKey'", TableIWWebSub4Menu);

        $SCondition = " Attribute REGEXP '$sub4_name' ";
        foreach ($objORM->FetchAll($SCondition, 'IdKey,WeightIdKey', TableIWAPIProducts) as $ListItem) {

            if ($ListItem->WeightIdKey == '') {
                $USet = " WeightIdKey = '$WeightIdKey'";
                $UCondition = " IdKey = '$ListItem->IdKey' ";
                $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);

            } else {
                $WeightInProduct = $objORM->Fetch(" IdKey = '$ListItem->WeightIdKey'", 'Weight', TableIWWebWeightPrice)->Weight;

                if ($WeightInProduct >= $Weight) {
                    continue;
                } else {
                    $USet = " WeightIdKey = '$WeightIdKey'";
                    $UCondition = " IdKey = '$ListItem->IdKey' ";
                    $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);

                }

            }
        }
    }

}


// add order number
if (isset($_GET['order_nu']) and isset($_GET['order_id'])) {

    $IdKey = $_GET['order_id'];
    $OrderNu = $_GET['order_nu'];

    $UCondition = " IdKey = '$IdKey'";
    $USet = " OrderNu = '$OrderNu', ChkState = 'bought' ";
    $objORM->DataUpdate($UCondition, $USet, TableIWAUserMainCart);

}

// add sorting number
if (isset($_GET['sorting_nu']) and isset($_GET['sorting_id'])) {

    $IdKey = $_GET['sorting_id'];
    $SortingNu = $_GET['sorting_nu'];

    $UCondition = " IdKey = '$IdKey'";
    $USet = " SortingNu = '$SortingNu', ChkState = 'preparation' ";
    $objORM->DataUpdate($UCondition, $USet, TableIWAUserMainCart);

}


// add tracking number
if (isset($_GET['tracking_nu']) and isset($_GET['tracking_id'])) {

    $PackingNu = $_GET['tracking_id'];
    $TrackingNu = $_GET['tracking_nu'];
    $TrackingNu = str_replace(' ', '', $TrackingNu);
    $TrackingNu = str_replace('-', '', $TrackingNu);
    $TrackingNu = str_replace('_', '', $TrackingNu);

    $UCondition = " PackingNu = '$PackingNu'";
    $USet = " TrackingNu = '$TrackingNu', ChkState = 'booking' ";
    $objORM->DataUpdate($UCondition, $USet, TableIWAUserMainCart);

}

// add first page currency
if (isset($_GET['currency_nu']) and isset($_GET['currency_id'])) {

    $CurrencyIdKey = $_GET['currency_id'];
    $CurrencyNu = $_GET['currency_nu'];
    $CurrencyNu = str_replace(' ', '', $CurrencyNu);
    $CurrencyNu = explode(".",$CurrencyNu);
    $CurrencyNu = str_replace(',', '', $CurrencyNu[0]);

    $UCondition = " IdKey = '$CurrencyIdKey'";
    $USet = " Rate = '$CurrencyNu',";
    $USet .= " ModifyIP = '$ModifyIP' ,";
    $USet .= " ModifyTime = '$ModifyTime' ,";
    $USet .= " ModifyDate = '$ModifyDate' ,";
    $USet .= " ModifyStrTime = '$ModifyStrTime' ";
    $objORM->DataUpdate($UCondition, $USet, TableIWACurrenciesConversion);

}



