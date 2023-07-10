<?php


require_once "../vendor/autoload.php";
SessionTools::init();
require_once "../idefine/conf/root.php";
require_once "../idefine/conf/tablename.php";


$objGlobalVar = new GlobalVarTools();
$objFileToolsDBInfo = (new FileTools(IW_DEFINE_FROM_PANEL . "conf/online.iw"))->KeyValueFileReader();

if ((new IPTools(IW_DEFINE_FROM_PANEL))->getHostAddressLoad() == 'localhost')
    $objFileToolsDBInfo = (new FileTools(IW_DEFINE_FROM_PANEL . "conf/local.iw"))->KeyValueFileReader();

$objORM = new DBORM((new MySQLConnection($objFileToolsDBInfo))->getConn());
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");

(new MakeDirectory)->MKDir(IW_REPOSITORY_FROM_PANEL . 'log/error/', 'iweb', 0755);
$objInitTools = new InitTools($objFileToolsInit->KeyValueFileReader(), IW_REPOSITORY_FROM_PANEL . 'log/error/iweb/viewerror.log');


// add weight to product
if (isset($_GET['mainname']) and isset($_GET['mainidkey'])) {
    $id = @$_GET['mainidkey'];
    $LocalName = @$_GET['mainname'];
    $objORM->DataUpdate(" id = $id" , "  LocalName = '$LocalName'  ", TableIWNewMenu);
}
if (isset($_GET['subname']) and isset($_GET['subidkey'])) {
    $id = @$_GET['subidkey'];
    $LocalName = @$_GET['subname'];
    $objORM->DataUpdate(" id = $id" , "  LocalName = '$LocalName'  ", TableIWNewMenu2);
}
if (isset($_GET['sub2name']) and isset($_GET['sub2idkey'])) {
    $id = @$_GET['sub2idkey'];
    $LocalName = @$_GET['sub2name'];
    $objORM->DataUpdate(" id = $id" , "  LocalName = '$LocalName'  ", TableIWNewMenu3);
}

if (isset($_GET['sub4name']) and isset($_GET['sub4idkey'])) {
    $id = @$_GET['sub4idkey'];
    $LocalName = @$_GET['sub4name'];
    $objORM->DataUpdate(" id = $id" , "  LocalName = '$LocalName'  ", TableIWNewMenu4);
}
/*
// add weight to main
if (isset($_GET['w_main']) and isset($_GET['main_name']) ) {
    $Weight = @$_GET['w_main'];
    $main_name = @$_GET['main_name'];
    $iw_product_weight_id = $objORM->Fetch(" Weight = '$Weight'", 'id', TableIWWebWeightPrice)->id;

    if ($iw_product_weight_id != null) {
        $objORM->DataUpdate("  Name = '$main_name'  ", " iw_product_weight_id = '$iw_product_weight_id'", TableIWWebMainMenu);
    }

}


// add weight to sub
if (isset($_GET['w_sub']) and isset($_GET['sub_name']) ) {
    $Weight = @$_GET['w_sub'];
    $sub_name = $objGlobalVar->getUrlEncode(@$_GET['sub_name']);
    $iw_product_weight_id = $objORM->Fetch(" Weight = '$Weight'", 'id', TableIWWebWeightPrice)->id;

    if ($iw_product_weight_id != null) {
        $objORM->DataUpdate("  Name = '$sub_name'  ", " iw_product_weight_id = '$iw_product_weight_id'", TableIWWebSubMenu);
    }

}

// add weight to sub2
if (isset($_GET['w_sub2']) and isset($_GET['sub2_name']) ) {
    $Weight = @$_GET['w_sub2'];
    $sub2_name = $objGlobalVar->getUrlEncode(@$_GET['sub2_name']);
    $iw_product_weight_id = $objORM->Fetch(" Weight = '$Weight'", 'id', TableIWWebWeightPrice)->id;

    if ($iw_product_weight_id != null) {
        $objORM->DataUpdate("  Name = '$sub2_name'  ", " iw_product_weight_id = '$iw_product_weight_id'", TableIWWebSub2Menu);
    }

}

*/