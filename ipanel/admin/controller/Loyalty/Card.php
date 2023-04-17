<?php
//Card.php

$apiMainName = 'Card?$expand=CardHolder';

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = BoolEnum::BOOL_TRUE();
$strListHead = (new ListTools())->TableHead(array(FA_LC["card_name"], FA_LC["pan_hash"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["active"];

$strListBody = '';

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objRNLS2 = new RNLS2Connection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, "");

$arrSortTo = array('Title', 'PanHash');
foreach ($objGlobalVar->ObjectJsonToSelectArray($objRNLS2->connect(), 1) as $ListItem) {

    if ($ListItem->IsActive == false) {
        $ToolsIcons[1] = $arrToolsIcon["inactiveapi"];
    } else {
        $ToolsIcons[1] = $arrToolsIcon["activeapi"];
    }
    $ListItem->PanHash = (new ListTools())->MaskingCart($ListItem->PanHash, 1);

    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 2, $objGlobalVar->en2Base64($ListItem->Id . '::==::' . $apiMainName, 0), $arrSortTo);
}





