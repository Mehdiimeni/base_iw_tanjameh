<?php
//Sub2Menu.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = BoolEnum::BOOL_TRUE();
$strListHead = (new ListTools())->TableHead(array(FA_LC["row"], FA_LC["main_name"], FA_LC["local_name"], FA_LC["branch"],FA_LC["weight"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];
$ToolsIcons[] = $arrToolsIcon["delete"];

$strListBody = '';
foreach ($objORM->FetchAllWhitoutCondition('IdKey,Name,LocalName,GroupIdKey,WeightIdKey,Enabled,IdRow', TableIWWebSub4Menu) as $ListItem) {

    $ListItem->LocalName = '<input type="text" class="name-sub4" maxlength="250" size="25" id="' . $ListItem->IdKey . '" value="' . $ListItem->LocalName . '">';


    $SCondition = "IdKey = '$ListItem->GroupIdKey'";
    $ListItem->GroupIdKey = @$objORM->Fetch($SCondition, 'LocalName', TableIWWebSubMenu)->LocalName;

    $SCondition = "IdKey = '$ListItem->WeightIdKey'";
    $ListItem->WeightIdKey =  '<input type="text" class="weight-sub4" maxlength="3" size="3" id="' . $ListItem->Name . '" value="' . @$objORM->Fetch($SCondition,'Weight',TableIWWebWeightPrice)->Weight . '">';

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
    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 5, $objGlobalVar->en2Base64($ListItem->IdKey . '::==::' . TableIWWebSub4Menu, 0));
}








