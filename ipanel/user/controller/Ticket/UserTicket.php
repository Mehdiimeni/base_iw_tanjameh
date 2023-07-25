<?php
//UserTicket.php


require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";
include IW_ASSETS_FROM_PANEL . "include/UserInfo.php";
$UserId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserId'));

$Enabled = true;
$strListHead = (new ListTools())->TableHead(array( FA_LC["sender"], FA_LC["subject"], FA_LC["view"], FA_LC["submit_time"], FA_LC["submit_date"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];


$strListBody = '';
$SCondition = "SenderIdKey = '$UserId' ";
foreach ($objORM->FetchAll($SCondition,'IdKey,SenderIdKey,TicketSubject,SetView,created_time,last_modify,Enabled,id', TableIWTicket) as $ListItem) {


    $SCondition = "id = '$ListItem->SenderIdKey'";
    $ListItem->SenderIdKey = @$objORM->Fetch($SCondition, 'Name', TableIWUser)->Name;


    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 6, $objGlobalVar->en2Base64($ListItem->id . '::==::' . TableIWTicket, 0));
}



