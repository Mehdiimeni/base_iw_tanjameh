<?php
///controller/look/UserLook.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = true;
$strListHead = (new ListTools())->TableHead(array(FA_LC["username"],FA_LC["accept"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];
$ToolsIcons[] = $arrToolsIcon["delete"];

$strListBody = '';
foreach ($objORM->FetchAllWhitoutCondition('user_id,stat,enabled,id', TableIWUserLookDocuments) as $ListItem) {

    $ListItem->user_id = @$objORM->Fetch(
        "id = $ListItem->user_id",
        'Name',
        TableIWUser
    )->Name;

    $ListItem->stat == 1 ? $ListItem->stat= "تایید" : $ListItem->stat = "عدم تایید";


    if ($ListItem->enabled == false) {
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
    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 2, $objGlobalVar->en2Base64($ListItem->id . '::==::' . TableIWUserLookDocuments, 0));
}