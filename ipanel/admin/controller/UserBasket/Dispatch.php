<?php
//Dispatch.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$Enabled = true;
$strListHead = (new ListTools())->TableHead(array(  FA_LC["user"], FA_LC["pack"],FA_LC["weight"],FA_LC["tracking_number"],FA_LC['attached_file']), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];

$strListBody = '';
@$_GET['s'] != null ? $getStart = @$_GET['s'] : $getStart = 0;
@$_GET['e'] != null ? $getEnd = @$_GET['e'] : $getEnd = 100;

$strListBody = '';
$SCondition = " (status = 'booking' or status = 'dispatch' )   group by packing_number  limit " . $getStart . " , " . $getEnd;
$item_list = " user_name,packing_number,packing_weight,tracking_number,cop_file,user_shopping_cart_id,invoice_id,Enabled ";

foreach ($objORM->FetchAll($SCondition, $item_list, ViewIWUserCart) as $ListItem) {


    if ($ListItem->Enabled == false) {
        $ToolsIcons[2] = $arrToolsIcon["inactive"];
    } else {
        $ToolsIcons[2] = $arrToolsIcon["active"];
    }

    if($ListItem->cop_file != null)
    {
        $ListItem->cop_file = '<a target="_blank" href="' . IW_REPOSITORY_FROM_PANEL . 'attach/copfile/download/' . $ListItem->cop_file . '">Cop File</a>';
       // $ListItem->CopFile .= '<a target="_blank" href="?ln=&part=UserBasket&page=Output">pdf</a>';
    }


    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 5, $objGlobalVar->en2Base64($ListItem->packing_number . '::==::' . TableIWShippingProduct, 0));
}




