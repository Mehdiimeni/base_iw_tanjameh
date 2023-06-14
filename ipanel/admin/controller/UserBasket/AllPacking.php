<?php
//AllPacking.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = true;


//Count show
$arrListcount = [25, 50, 100, 200, 500];
$strCountShow = '';
foreach ($arrListcount as $Listcount) {
    $strSelected = '';
    if (@$_GET['CountShow'] == $Listcount and isset($_GET['CountShow']))
        $strSelected = 'selected';
    $strCountShow .= '<option ' . $strSelected . ' value="' . $Listcount . '" >' . $Listcount . '</option>';
}


if (isset($_POST['SubmitF'])) {

    $CountShow = @$_POST['CountShow'];


    $strGetUrl = '';

    if ($CountShow != '')
        $strGetUrl .= '&CountShow=' . $CountShow;

    $objGlobalVar->JustUnsetGetVar(array('CountShow'));
    JavaTools::JsTimeRefresh(0, '?part=UserBasket&page=AllPacking&ln=' . @$strGlobalVarLanguage . $strGetUrl);

}

$strListHead = (new ListTools())->TableHead(array(FA_LC["name"]), FA_LC['code']);


$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];


if (@$_GET['CountShow'] != '') {
    $strLimit = @$_GET['CountShow'];
} else {
    $strLimit = '25';
}


$strListBody = '';
$SCondition = "Enabled != 0 and (ChkState = 'bought' or ChkState = 'preparation') group by UserIdKey";

foreach ($objORM->FetchLimit($SCondition, 'UserIdKey', 'ModifyDate ASC', $strLimit, TableIWAUserMainCart) as $ListItem) {


    $SCondition = "IdKey = '$ListItem->UserIdKey'";
    $ListItem->UserIdKey = '<a target="_blank" href="?ln=&part=UserBasket&page=Packing&IdKey=' . $ListItem->UserIdKey . '">' . @$objORM->Fetch($SCondition, 'Name', TableIWUser)->Name . '</a>';

    if (@$ListItem->Enabled == false) {
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
    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 8, $objGlobalVar->en2Base64(@$ListItem->IdKey . '::==::' . TableIWAdmin, 0));
}



