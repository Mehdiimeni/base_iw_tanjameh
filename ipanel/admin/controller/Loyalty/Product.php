<?php
//Product.php

$apiMainName = 'Product';

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = BoolEnum::BOOL_TRUE();
$strListHead = (new ListTools())->TableHead(array(FA_LC["name"], FA_LC["row"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];

$strListBody = '';

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objRNLS2 = new RNLS2Connection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, "");


foreach ($objGlobalVar->ObjectJsonToSelectArray($objRNLS2->connect(), 1) as $ListItem) {

    if ($ListItem->IsActive == false) {
        $ToolsIcons[2] = $arrToolsIcon["inactiveapi"];
    } else {
        $ToolsIcons[2] = $arrToolsIcon["activeapi"];
    }


    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 2, $objGlobalVar->en2Base64($ListItem->Id . '::==::' . $apiMainName, 0));
}







