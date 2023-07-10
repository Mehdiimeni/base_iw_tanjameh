<?php
///controller/Look/LookPage.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = true;
$strListHead = (new ListTools())->TableHead(array( FA_LC["name"], FA_LC["user"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];
$ToolsIcons[] = $arrToolsIcon["delete"];

$strListBody = '';
@$_GET['s'] != null ? $getStart = @$_GET['s'] : $getStart = 0;
@$_GET['e'] != null ? $getEnd = @$_GET['e'] : $getEnd = 500;

$SCondition = " 1 order by id DESC limit " . $getStart . " , " . $getEnd;

foreach ($objORM->FetchAll($SCondition, 'IdKey,LookPageName,iw_user_IdRow,Enabled,id', TableIWUserLook) as $ListItem) {

    $SCondition = "id = '$ListItem->iw_user_IdRow'";
    $ListItem->iw_user_IdRow = $objORM->Fetch($SCondition, 'Name', TableIWUser)->Name;


    if ($ListItem->Enabled == false) {
        $ToolsIcons[2] = $arrToolsIcon["inactive"];
    } else {
        $ToolsIcons[2] = $arrToolsIcon["active"];
    }


    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 4, $objGlobalVar->en2Base64($ListItem->id . '::==::' . TableIWAdminGroup, 0));
}







