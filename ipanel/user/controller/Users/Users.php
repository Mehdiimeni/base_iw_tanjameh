<?php
//Users.php


include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = BoolEnum::BOOL_TRUE();
$strListHead = (new ListTools())->TableHead(array(FA_LC["row"], FA_LC["username"], FA_LC["group_name"], FA_LC["name"], FA_LC["email"], FA_LC["count_enter"], FA_LC["last_admin_login"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];
$ToolsIcons[] = $arrToolsIcon["delete"];

$strListBody = '';
$ModifyId = @$objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
$SCondition = " ModifyId = '$ModifyId' ";
foreach ($objORM->FetchAll($SCondition,'IdKey,UserName,GroupIdKey,Name,Email,CountEnter,ModifyDate,Enabled,IdRow', TableIWUser) as $ListItem) {

    $ListItem->UserName = $objGlobalVar->de2Base64($ListItem->UserName);

    $SCondition = "IdKey = '$ListItem->GroupIdKey'";
    $ListItem->GroupIdKey = @$objORM->Fetch($SCondition, 'Name', TableIWUserGroup)->Name;

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
    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 7, $objGlobalVar->en2Base64($ListItem->IdKey . '::==::' . TableIWUser, 0));
}



