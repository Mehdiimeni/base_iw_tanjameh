<?php
//Currencies.php


include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = true;
$strListHead = (new ListTools())->TableHead(array(FA_LC["row"],  FA_LC["name"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];
$ToolsIcons[] = $arrToolsIcon["delete"];

$strListBody = '';
foreach ($objORM->FetchAllWhitoutCondition('IdKey,Name,ModifyId,Enabled,IdRow', TableIWACurrencies) as $ListItem) {

    $ListItem->ModifyId == null ? $ListItem->ModifyId = FA_LC["no_viewed"] : FA_LC["viewed"];

    if ($ListItem->Enabled == BoolEnum::BOOL_FALSE()) {
        $ToolsIcons[2] = $arrToolsIcon["inactive"];
    } else {
        $ToolsIcons[2] = $arrToolsIcon["active"];
    }

    if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->act != 'move') {

        $ToolsIcons[4] = $arrToolsIcon["move"];

    } elseif ($objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->act == 'move' and @$objGlobalVar->RefFormGet()[0] == $ListItem->IdKey) {
        $ToolsIcons[4] = $arrToolsIcon["movein"];
        $ToolsIcons[5] = $arrToolsIcon["closemove"];
        $objGlobalVar->setGetVar('chin', $ListItem->IdRow);


    } else {

        $ToolsIcons[4] = $arrToolsIcon["moveout"];
        $urlAppend = $ToolsIcons[4][3] . '&chto=' . $ListItem->IdRow . '&chin=' . @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->chin;
        $ToolsIcons[4][3] = $urlAppend;

    }
    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 2, $objGlobalVar->en2Base64($ListItem->IdKey . '::==::' . TableIWACurrencies, 0));
}



