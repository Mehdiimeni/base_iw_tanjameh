<?php
//Dispatch.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$Enabled = BoolEnum::BOOL_TRUE();
$strListHead = (new ListTools())->TableHead(array(FA_LC["row"], FA_LC["id"], FA_LC["user"], FA_LC["pack"],FA_LC["weight"],FA_LC["tracking_number"],FA_LC['attached_file'],FA_LC["date"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];

$strListBody = '';
@$_GET['s'] != null ? $getStart = @$_GET['s'] : $getStart = 0;
@$_GET['e'] != null ? $getEnd = @$_GET['e'] : $getEnd = 100;

$SCondition = " Enabled != 0 and (ChkState = 'booking' or ChkState = 'dispatch' ) group by PackingNu  order by IdRow DESC limit " . $getStart . " , " . $getEnd;
foreach ($objORM->FetchAll($SCondition, 'IdRow,IdKey,UserIdKey,PackingNu,PackWeight,TrackingNu,CopFile,ModifyDate,IdKey,Enabled', TableIWAUserMainCart) as $ListItem) {


    $SCondition = "IdKey = '$ListItem->UserIdKey'";
    $ListItem->UserIdKey = @$objORM->Fetch($SCondition, 'Name', TableIWUser)->Name;


    if ($ListItem->Enabled == BoolEnum::BOOL_FALSE()) {
        $ToolsIcons[2] = $arrToolsIcon["inactive"];
    } else {
        $ToolsIcons[2] = $arrToolsIcon["active"];
    }

    if($ListItem->CopFile != null)
    {
        $ListItem->CopFile = '<a target="_blank" href="' . IW_REPOSITORY_FROM_PANEL . 'attach/copfile/download/' . $ListItem->CopFile . '">Cop File</a>';
       // $ListItem->CopFile .= '<a target="_blank" href="?ln=&part=UserBasket&page=Output">pdf</a>';
    }


    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 8, $objGlobalVar->en2Base64($ListItem->PackingNu . '::==::' . TableIWAUserMainCart, 0));
}




