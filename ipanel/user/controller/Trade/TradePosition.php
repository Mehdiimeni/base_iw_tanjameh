<?php
//TradePosition.php


require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";
include_once IW_ASSETS_FROM_PANEL . "include/UserInfo.php";

if ($strUserGroup->SuperUser or $strUserGroup->SuperTrade)
    $strSuper = 1;

$Enabled = true;
$strListHead = (new ListTools())->TableHead(array( FA_LC["group_name"], FA_LC["trade_name"], FA_LC["trade_type"], FA_LC["trade_time"], FA_LC["submit_date"],FA_LC["submit_time"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];
$ToolsIcons[] = $arrToolsIcon["delete"];

$arrUserTradeIdKey = array();
foreach ($arrAllTrade as $AllTrade)
{
    $arrUserTradeIdKey = $AllTrade;
}
$impUserTradeIdKey = implode(",",$arrUserTradeIdKey);

$strListBody = '';
count($arrUserTradeIdKey) > 1 ? $SCondition = " TradeIdKey IN '$impUserTradeIdKey'" : $SCondition = " TradeIdKey = '$impUserTradeIdKey'";

foreach ($objORM->FetchAll($SCondition,'IdKey,GroupIdKey,TradeIdKey,TypePosition,TimePosition,last_modify,created_time,Enabled,id', TableIWTradePosition) as $ListItem) {


    $SCondition = "id = '$ListItem->GroupIdKey'";
    $ListItem->GroupIdKey = @$objORM->Fetch($SCondition, 'Name', TableIWTradeGroup)->Name;
    $SCondition = "id = '$ListItem->TradeIdKey'";
    $ListItem->TradeIdKey = @$objORM->Fetch($SCondition, 'Name', TableIWTrade)->Name;

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
    if(@$strSuper == 0) {
        $ToolsIcons = array();
        $ToolsIcons[] = $arrToolsIcon["view"];
    }

    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 7, $objGlobalVar->en2Base64($ListItem->id . '::==::' . TableIWTradePosition, 0));
}





