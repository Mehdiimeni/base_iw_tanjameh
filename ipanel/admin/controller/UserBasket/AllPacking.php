<?php
//AllPacking.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = true;


//Count show
$arrListcount = [25, 50, 100, 200, 500];
$strCountShow = '';
foreach ($arrListcount as $Listcount) {
    $strSelected = '';
    if (@$_GET['CountShow'] == $Listcount and isset($_GET['CountShow']))
        $strSelected = 'selected';
    $strCountShow .= '<option ' . $strSelected . ' value="' . $Listcount . '" >' . $Listcount . '</option>';
}


if (isset($_POST['SubmitF'])) {

    $CountShow = @$_POST['CountShow'];


    $strGetUrl = '';

    if ($CountShow != '')
        $strGetUrl .= '&CountShow=' . $CountShow;

    $objGlobalVar->JustUnsetGetVar(array('CountShow'));
    JavaTools::JsTimeRefresh(0, '?part=UserBasket&page=AllPacking&ln=' . @$strGlobalVarLanguage . $strGetUrl);

}

$strListHead = (new ListTools())->TableHead(array(FA_LC["name"], FA_LC['cart_number']), FA_LC["tools"]);


$ToolsIcons[] = $arrToolsIcon["view"];


if (@$_GET['CountShow'] != '') {
    $strLimit = @$_GET['CountShow'];
} else {
    $strLimit = '25';
}


$strListBody = '';
$SCondition = " status = 'bought' or status = 'preparation' or packing_number is null   group by user_shopping_cart_id ";
$item_list = " user_name, user_shopping_cart_id,invoice_id,Enabled ";

foreach ($objORM->FetchAll($SCondition, $item_list, ViewIWUserCart) as $ListItem) {


    $ListItem->user_name = '<a target="_blank" href="?ln=&part=UserBasket&page=Packing&cart_id=' . $ListItem->user_shopping_cart_id . '">' . $ListItem->user_name . '</a>';

    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 2, $objGlobalVar->en2Base64(@$ListItem->invoice_id . '::==::' . TableIWAUserInvoice, 0));
}



