<?php
//ProductsPrice.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = true;
$strListHead = (new ListTools())->TableHead(array(FA_LC["row"], FA_LC["bigger"], FA_LC["smaller"], FA_LC["currency"],FA_LC['change_rate'], FA_LC['last_update']), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];
$ToolsIcons[] = $arrToolsIcon["delete"];

$strListBody = '';
foreach ($objORM->FetchAllWhitoutCondition('IdKey,Bigger,Smaller,CurrencyIdKey,ChangeRate,ModifyDate,ModifyTime,ModifyId,Enabled,IdRow', TableIWAProductPrice) as $ListItem) {


    $SCondition = "IdKey = '$ListItem->CurrencyIdKey'";
    $ListItem->CurrencyIdKey = @$objORM->Fetch($SCondition,'Name',TableIWACurrencies)->Name;



    $ListItem->ModifyDate = $ListItem->ModifyTime . ' ' . $ListItem->ModifyDate;
    $ListItem->ChangeRate = $ListItem->ChangeRate .'%';

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
    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 6, $objGlobalVar->en2Base64($ListItem->IdKey . '::==::' . TableIWAProductPrice, 0));
}





