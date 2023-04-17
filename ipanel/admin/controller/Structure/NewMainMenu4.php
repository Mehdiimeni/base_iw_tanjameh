<?php
//NewMainMenu4.php


include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = BoolEnum::BOOL_TRUE();
$strListHead = (new ListTools())->TableHead(array(FA_LC["row"], FA_LC["main_name"], FA_LC["local_name"], FA_LC["main_menu"], FA_LC["main_menu2"], FA_LC["main_menu3"], FA_LC["weight"], FA_LC["category"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];
$ToolsIcons[] = $arrToolsIcon["delete"];

$strListBody = '';
foreach ($objORM->FetchAllWhitoutCondition('IdKey,Name,LocalName,NewMenuId,NewMenu2Id,GroupIdKey,WeightIdKey,CatId,Enabled,IdRow', TableIWNewMenu4) as $ListItem) {

    $ListItem->LocalName = '<input type="text" class="name-sub" maxlength="250" size="25" id="' . $ListItem->IdKey . '" value="' . $ListItem->LocalName . '">';

    $SCondition = "IdKey = '$ListItem->GroupIdKey'";
    $ListItem->GroupIdKey = $objORM->Fetch($SCondition, 'Name', TableIWNewMenu3)->Name;


    $SCondition = "IdKey = '$ListItem->NewMenu2Id'";
    $ListItem->NewMenu2Id = $objORM->Fetch($SCondition, 'Name', TableIWNewMenu2)->Name;

    $SCondition = "IdKey = '$ListItem->NewMenuId'";
    $ListItem->NewMenuId = $objORM->Fetch($SCondition, 'Name', TableIWNewMenu)->Name;

    $SCondition = "IdKey = '$ListItem->WeightIdKey'";
    $ListItem->WeightIdKey = '<input type="text" class="weight-sub" maxlength="3" size="3" id="' . $ListItem->Name . '" value="' . @$objORM->Fetch($SCondition, 'Weight', TableIWWebWeightPrice)->Weight . '">';

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
    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 8, $objGlobalVar->en2Base64($ListItem->IdKey . '::==::' . TableIWNewMenu4, 0));
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
        $WeightIdKey = $objORM->Fetch($SConditionWeight, 'IdKey', TableIWWebWeightPrice)->IdKey;

        // update new menu 4 weight

        $UCondition = " IdKey = '$rowData[0]' ";
        $USet = " WeightIdKey = '$WeightIdKey' ";
        $objORM->DataUpdate($UCondition, $USet, TableIWNewMenu4);

    }
}
