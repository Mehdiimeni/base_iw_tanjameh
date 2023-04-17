<?php
//booking.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$Enabled = BoolEnum::BOOL_TRUE();
$ToolsIcons[] = $arrToolsIcon["reverse_basket"];

$strListHead = (new ListTools())->TableHead(array(FA_LC["row"], FA_LC["id"], FA_LC["user"], FA_LC["pack"],FA_LC["weight"],FA_LC["tracking_number"], FA_LC["date"], FA_LC["address_label"]), FA_LC["tools"]);


$strListBody = '';
@$_GET['s'] != null ? $getStart = @$_GET['s'] : $getStart = 0;
@$_GET['e'] != null ? $getEnd = @$_GET['e'] : $getEnd = 100;

$SCondition = " Enabled != 0 and (ChkState = 'packing' ) group by PackingNu  order by IdRow DESC limit " . $getStart . " , " . $getEnd;
foreach ($objORM->FetchAll($SCondition, 'IdRow,IdKey,UserIdKey,PackingNu,PackWeight,TrackingNu,ModifyDate,ModifyTime,IdKey,Enabled', TableIWAUserMainCart) as $ListItem) {


    $SCondition = "IdKey = '$ListItem->UserIdKey'";
    $ListItem->UserIdKey = @$objORM->Fetch($SCondition, 'Name', TableIWUser)->Name;


    $ListItem->TrackingNu = '<input type="text" dir="ltr" class="tracking_number"  size="16" id="' . $ListItem->PackingNu . '" value="' . $ListItem->TrackingNu . '">';
    $ListItem->ModifyTime = '<a target="_blank" href="?ln=&part=Users&page=AddressLabelBook&PackingNu='.$ListItem->PackingNu.'">'.FA_LC["download"].'</a>';


    if ($ListItem->Enabled == BoolEnum::BOOL_FALSE()) {
        $ToolsIcons[2] = $arrToolsIcon["inactive"];
    } else {
        $ToolsIcons[2] = $arrToolsIcon["active"];
    }


    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 8, $objGlobalVar->en2Base64($ListItem->IdKey . '::==::' . TableIWAUserMainCart, 0));
}




