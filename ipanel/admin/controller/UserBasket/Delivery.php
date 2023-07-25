<?php
//Dispatch.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$Enabled = true;
$strListHead = (new ListTools())->TableHead(array( FA_LC["id"], FA_LC["user"], FA_LC["pack"],FA_LC["weight"],FA_LC["tracking_number"],FA_LC['attached_file'],FA_LC["date"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];

$strListBody = '';
@$_GET['s'] != null ? $getStart = @$_GET['s'] : $getStart = 0;
@$_GET['e'] != null ? $getEnd = @$_GET['e'] : $getEnd = 100;

$SCondition = " Enabled != 0 and (ChkState = 'delivery'  ) group by PackingNu  order by id DESC limit " . $getStart . " , " . $getEnd;
foreach ($objORM->FetchAll($SCondition, 'id,UserId,PackingNu,PackWeight,TrackingNu,CopFile,last_modify,Enabled', TableIWAUserMainCart) as $ListItem) {


    $SCondition = "id = $ListItem->iw_user_id";
    $ListItem->iw_user_id = @$objORM->Fetch($SCondition, 'Name', TableIWUser)->Name;


    if ($ListItem->Enabled == false) {
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




