<?php

//NewMainMenu2.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = true;
$strListHead = (new ListTools())->TableHead(array( FA_LC["main_name"], FA_LC["local_name"], FA_LC["main_menu"], FA_LC["weight"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];
$ToolsIcons[] = $arrToolsIcon["delete"];

$strListBody = '';
foreach ($objORM->FetchAllWhitoutCondition('Name,LocalName,GroupIdKey,iw_product_weight_id,Enabled,id', TableIWNewMenu2) as $ListItem) {

    $ListItem->LocalName = '<input type="text" class="name-sub" maxlength="250" size="25" id="' . $ListItem->id . '" value="' . $ListItem->LocalName . '">';


    $SCondition = "id = '$ListItem->GroupIdKey'";
    $ListItem->GroupIdKey = $objORM->Fetch($SCondition, 'Name', TableIWNewMenu)->Name;

    $SCondition = "id = $ListItem->iw_product_weight_id";
    $ListItem->iw_product_weight_id = '<input type="text" class="weight-sub" maxlength="3" size="3" id="' . $ListItem->Name . '" value="' . @$objORM->Fetch($SCondition, 'Weight', TableIWWebWeightPrice)->Weight . '">';

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
    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 5, $objGlobalVar->en2Base64($ListItem->id . '::==::' . TableIWNewMenu2, 0));
}

