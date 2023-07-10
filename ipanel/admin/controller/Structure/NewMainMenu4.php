<?php
//NewMainMenu4.php


require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = true;
$strListHead = (new ListTools())->TableHead(array( FA_LC["main_name"], FA_LC["local_name"], FA_LC["main_menu"], FA_LC["main_menu2"], FA_LC["main_menu3"], FA_LC["weight"], FA_LC["category"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];
$ToolsIcons[] = $arrToolsIcon["delete"];

$strListBody = '';
foreach ($objORM->FetchAllWhitoutCondition('Name,LocalName,NewMenuId,NewMenu2Id,GroupIdKey,iw_product_weight_id,CatId,Enabled,id', TableIWNewMenu4) as $ListItem) {

    $ListItem->LocalName = '<input type="text" class="name-sub" maxlength="250" size="25" id="' . $ListItem->id . '" value="' . $ListItem->LocalName . '">';

    $SCondition = "id = '$ListItem->GroupIdKey'";
    $ListItem->GroupIdKey = $objORM->Fetch($SCondition, 'Name', TableIWNewMenu3)->Name;


    $SCondition = "id = '$ListItem->NewMenu2Id'";
    $ListItem->NewMenu2Id = $objORM->Fetch($SCondition, 'Name', TableIWNewMenu2)->Name;

    $SCondition = "id = '$ListItem->NewMenuId'";
    $ListItem->NewMenuId = $objORM->Fetch($SCondition, 'Name', TableIWNewMenu)->Name;

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
    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 8, $objGlobalVar->en2Base64($ListItem->id . '::==::' . TableIWNewMenu4, 0));
}


// set file weight

if(@$_GET["www"] == 1)
{
    $csvFile = file(IW_MAIN_ROOT_FROM_PANEL . "changewieght.csv");

    $data = [];
    foreach ($csvFile as $line) {
        $data[] = str_getcsv($line);
    }
// 0 idkey newmenu4
// 1 weight number

    foreach ($data as $rowData) {
        if ($rowData[1] == null)
            continue;

        // find weight idkey
        $SConditionWeight = "Weight = '$rowData[1]' ";
        $iw_product_weight_id = $objORM->Fetch($SConditionWeight, 'IdKey', TableIWWebWeightPrice)->IdKey;

        // update new menu 4 weight

        $UCondition = " IdKey = '$rowData[0]' ";
        $USet = " iw_product_weight_id = '$iw_product_weight_id' ";
        $objORM->DataUpdate($UCondition, $USet, TableIWNewMenu4);

    }
}
