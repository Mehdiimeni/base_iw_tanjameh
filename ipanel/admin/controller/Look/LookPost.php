<?php
///controller/look/LookPost.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = true;
$strListHead = (new ListTools())->TableHead(array(FA_LC["gender"],FA_LC["group"], FA_LC["user"], FA_LC["accept"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];
$ToolsIcons[] = $arrToolsIcon["delete"];

$strListBody = '';
@$_GET['s'] != null ? $getStart = @$_GET['s'] : $getStart = 0;
@$_GET['e'] != null ? $getEnd = @$_GET['e'] : $getEnd = 500;

$SCondition = " 1 order by id DESC limit " . $getStart . " , " . $getEnd;

foreach ($objORM->FetchAll($SCondition, 'look_gender,look_group,user_id,stat,enabled,id', TableIWUserLookPost) as $ListItem) {

    $ListItem->user_id = @$objORM->Fetch(
        "id = $ListItem->user_id",
        'Name',
        TableIWUser
    )->Name;

    $ListItem->look_group = @$objORM->Fetch(
        "id = $ListItem->look_group",
        'name',
        TableIWUserLookGroup
    )->name;

    $ListItem->stat == 1 ? $ListItem->stat = "تایید" : $ListItem->stat = "عدم تایید";


    if ($ListItem->enabled == false) {
        $ToolsIcons[2] = $arrToolsIcon["inactive"];
    } else {
        $ToolsIcons[2] = $arrToolsIcon["active"];
    }


    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 4, $objGlobalVar->en2Base64($ListItem->id . '::==::' . TableIWUserLookPost, 0));
}