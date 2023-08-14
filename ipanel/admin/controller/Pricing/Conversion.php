<?php
//Conversion.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = true;
$strListHead = (new ListTools())->TableHead(array( FA_LC["currency1"], FA_LC["currency2"], FA_LC["rate"],FA_LC['last_update']), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];
$ToolsIcons[] = $arrToolsIcon["delete"];

$strListBody = '';
foreach ($objORM->FetchAllWhitoutCondition('iw_currencies_id1,iw_currencies_id2,Rate,last_modify,created_time,modify_id,Enabled,id', TableIWACurrenciesConversion) as $ListItem) {

    $ListItem->modify_id == null ? $ListItem->modify_id = FA_LC["no_viewed"] : FA_LC["viewed"];

    $SCondition = "id = '$ListItem->iw_currencies_id1'";
    $ListItem->iw_currencies_id1 = @$objORM->Fetch($SCondition,'Name',TableIWACurrencies)->Name;

    $SCondition = "id = '$ListItem->iw_currencies_id2'";
    $ListItem->iw_currencies_id2 = @$objORM->Fetch($SCondition,'Name',TableIWACurrencies)->Name;

    $ListItem->Rate = $objGlobalVar->NumberFormat($ListItem->Rate);
    $ListItem->last_modify = $ListItem->created_time.' '.$ListItem->last_modify;

    if ($ListItem->Enabled == false) {
        $ToolsIcons[2] = $arrToolsIcon["inactive"];
    } else {
        $ToolsIcons[2] = $arrToolsIcon["active"];
    }

    if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->act != 'move') {

        $ToolsIcons[4] = $arrToolsIcon["move"];

    } elseif ($objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->act == 'move' and @$objGlobalVar->RefFormGet()[0] == $ListItem->id) {
        $ToolsIcons[4] = $arrToolsIcon["movein"];
        $ToolsIcons[5] = $arrToolsIcon["closemove"];
        $objGlobalVar->setGetVar('chin', $ListItem->id);


    } else {

        $ToolsIcons[4] = $arrToolsIcon["moveout"];
        $urlAppend = $ToolsIcons[4][3] . '&chto=' . $ListItem->id . '&chin=' . @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->chin;
        $ToolsIcons[4][3] = $urlAppend;

    }
    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 4, $objGlobalVar->en2Base64($ListItem->id . '::==::' . TableIWACurrenciesConversion, 0));
}





