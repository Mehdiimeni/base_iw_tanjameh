<?php
//UserTicket.php


include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";
include IW_ASSETS_FROM_PANEL . "include/UserInfo.php";
$UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));

$Enabled = BoolEnum::BOOL_TRUE();
$strListHead = (new ListTools())->TableHead(array(FA_LC["row"], FA_LC["sender"], FA_LC["subject"], FA_LC["view"], FA_LC["submit_time"], FA_LC["submit_date"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];


$strListBody = '';
$SCondition = "SenderIdKey = '$UserIdKey' ";
foreach ($objORM->FetchAll($SCondition,'IdKey,SenderIdKey,TicketSubject,SetView,ModifyTime,ModifyDate,Enabled,IdRow', TableIWTicket) as $ListItem) {


    $SCondition = "IdKey = '$ListItem->SenderIdKey'";
    $ListItem->SenderIdKey = @$objORM->Fetch($SCondition, 'Name', TableIWUser)->Name;


    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 6, $objGlobalVar->en2Base64($ListItem->IdKey . '::==::' . TableIWTicket, 0));
}



