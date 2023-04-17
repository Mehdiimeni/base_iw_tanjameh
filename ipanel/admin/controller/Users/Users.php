<?php
//Users.php


include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = BoolEnum::BOOL_TRUE();
$strListHead = (new ListTools())->TableHead(array(FA_LC["row"], FA_LC["id"], FA_LC["username"],  FA_LC["group_name"],  FA_LC["name"], FA_LC["email"], FA_LC["count_enter"], FA_LC["last_admin_login"],FA_LC['address_label']), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];
$ToolsIcons[] = $arrToolsIcon["delete"];

$strListBody = '';
@$_GET['s'] != null ? $getStart = @$_GET['s'] : $getStart = 0;
@$_GET['e'] != null ? $getEnd = @$_GET['e'] : $getEnd = 500;

    $SCondition = " Username != '' order by IdRow DESC limit " . $getStart . " , " . $getEnd;


foreach ($objORM->FetchAll($SCondition, 'IdRow,IdKey,UserName,GroupIdKey,Name,Email,CountEnter,ModifyDate,ModifyTime,Enabled,IdRow', TableIWUser) as $ListItem) {

    $ListItem->UserName = $objGlobalVar->de2Base64($ListItem->UserName);

    $SCondition = "IdKey = '$ListItem->GroupIdKey'";
    $ListItem->GroupIdKey = @$objORM->Fetch($SCondition, 'Name', TableIWUserGroup)->Name;

    $ListItem->ModifyTime =  '<a target="_blank" href="?ln=&part=Users&page=AddressLabel&IdKey='.$ListItem->IdKey.'">'.FA_LC["download"].'</a>';


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
    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 9, $objGlobalVar->en2Base64($ListItem->IdKey . '::==::' . TableIWUser, 0));
}



