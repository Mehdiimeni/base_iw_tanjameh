<?php
//booking.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$Enabled = true;
$ToolsIcons[] = $arrToolsIcon["reverse_basket"];

$strListHead = (new ListTools())->TableHead(array( FA_LC["id"], FA_LC["user"], FA_LC["pack"],FA_LC["weight"],FA_LC["tracking_number"], FA_LC["date"], FA_LC["address_label"]), FA_LC["tools"]);


$strListBody = '';
@$_GET['s'] != null ? $getStart = @$_GET['s'] : $getStart = 0;
@$_GET['e'] != null ? $getEnd = @$_GET['e'] : $getEnd = 100;

$SCondition = " Enabled != 0 and (ChkState = 'packing' ) group by PackingNu  order by id DESC limit " . $getStart . " , " . $getEnd;
foreach ($objORM->FetchAll($SCondition, 'id,UserId,PackingNu,PackWeight,TrackingNu,last_modify,created_time,Enabled', TableIWAUserMainCart) as $ListItem) {


    $SCondition = "id = $ListItem->iw_user_id";
    $ListItem->iw_user_id = @$objORM->Fetch($SCondition, 'Name', TableIWUser)->Name;


    $ListItem->TrackingNu = '<input type="text" dir="ltr" class="tracking_number"  size="16" id="' . $ListItem->PackingNu . '" value="' . $ListItem->TrackingNu . '">';
    $ListItem->created_time = '<a target="_blank" href="?ln=&part=Users&page=AddressLabelBook&PackingNu='.$ListItem->PackingNu.'">'.FA_LC["download"].'</a>';


    if ($ListItem->Enabled == false) {
        $ToolsIcons[2] = $arrToolsIcon["inactive"];
    } else {
        $ToolsIcons[2] = $arrToolsIcon["active"];
    }


    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 8, $objGlobalVar->en2Base64($ListItem->id . '::==::' . TableIWAUserMainCart, 0));
}




