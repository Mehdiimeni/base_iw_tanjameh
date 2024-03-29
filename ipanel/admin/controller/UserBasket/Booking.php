<?php
//booking.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$Enabled = true;
$ToolsIcons[] = $arrToolsIcon["reverse_basket"];

$strListHead = (new ListTools())->TableHead(array(FA_LC["user"], FA_LC["pack"], FA_LC["weight"], FA_LC["tracking_number"], FA_LC["address_label"]), FA_LC["tools"]);


$strListBody = '';
@$_GET['s'] != null ? $getStart = @$_GET['s'] : $getStart = 0;
@$_GET['e'] != null ? $getEnd = @$_GET['e'] : $getEnd = 100;


$strListBody = '';
$SCondition = "  status = 'packing' group by packing_number limit " . $getStart . " , " . $getEnd;
$item_list = " user_name,packing_number,packing_weight,tracking_number,last_modify,user_shopping_cart_id,invoice_id ,Enabled ";

foreach ($objORM->FetchAll($SCondition, $item_list, ViewIWUserCart) as $ListItem) {


    $ListItem->tracking_number = '<input type="text" dir="ltr" class="tracking_number" data-cart="' . $ListItem->user_shopping_cart_id . '" data-invoice="'.$ListItem->invoice_id.'"  size="16" id="' . $ListItem->packing_number . '" value="' . $ListItem->tracking_number . '">';
    $ListItem->last_modify = '<a target="_blank" href="?ln=&part=Users&page=AddressLabelBook&packing_number=' . $ListItem->packing_number . '">' . FA_LC["download"] . '</a>';


    if ($ListItem->Enabled == false) {
        $ToolsIcons[2] = $arrToolsIcon["inactive"];
    } else {
        $ToolsIcons[2] = $arrToolsIcon["active"];
    }


    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 5, $objGlobalVar->en2Base64($ListItem->invoice_id . '::==::' . TableIWAUserInvoice, 0));
}