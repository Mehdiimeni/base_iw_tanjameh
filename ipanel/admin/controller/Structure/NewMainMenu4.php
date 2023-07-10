<?php
//NewMainMenu4.php


require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = true;
$strListHead = (new ListTools())->TableHead(array(FA_LC["main_name"], FA_LC["local_name"], FA_LC["address"], FA_LC["weight"], FA_LC["category"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];
$ToolsIcons[] = $arrToolsIcon["delete"];

$strListBody = '';
foreach ($objORM->FetchAllWhitoutCondition('Name,LocalName,iw_new_menu_3_id,iw_product_weight_id,CatId,Enabled,id', TableIWNewMenu4) as $ListItem) {

    $ListItem->LocalName = '<input type="text" class="name-sub4" maxlength="250" size="25" id="' . $ListItem->id . '" value="' . $ListItem->LocalName . '">';

    $obj_menu3 = $objORM->Fetch(
        "id = $ListItem->iw_new_menu_3_id",
        'Name,iw_new_menu_2_id',
        TableIWNewMenu3
    );

    $obj_menu2 = $objORM->Fetch(
        "id = $obj_menu3->iw_new_menu_2_id",
        'Name,iw_new_menu_id',
        TableIWNewMenu2
    );

    $obj_menu = $objORM->Fetch(
        "id = $obj_menu2->iw_new_menu_id",
        'Name',
        TableIWNewMenu
    );



    $ListItem->iw_new_menu_3_id = $obj_menu->Name . '/' . $obj_menu2->Name . '/' . $obj_menu3->Name;

    $SCondition = "id = $ListItem->iw_product_weight_id";
    $weight = @$objORM->Fetch(
        "id = $ListItem->iw_product_weight_id",
        'Weight',
        TableIWWebWeight
    )->Weight;

    $ListItem->iw_product_weight_id = '<input type="text" class="weight-sub4" maxlength="3" size="3" id="' . $ListItem->Name . '" value="' . $weight . '">';

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
    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons,5, $objGlobalVar->en2Base64($ListItem->id . '::==::' . TableIWNewMenu4, 0));
}


// set file weight

if (@$_GET["www"] == 1) {
    $csvFile = file(IW_MAIN_ROOT_FROM_PANEL . "changewieght.csv");

    $data = [];
    foreach ($csvFile as $line) {
        $data[] = str_getcsv($line);
    }
    // 0 idkey newmenu4
// 1 weight number

    foreach ($data as $rowData) {
        if ($rowData[1] == null)
            continue;

        // find weight idkey
        $SConditionWeight = "Weight = '$rowData[1]' ";
        $iw_product_weight_id = $objORM->Fetch($SConditionWeight, 'id', TableIWWebWeight)->id;

        // update new menu 4 weight

        $UCondition = " id = '$rowData[0]' ";
        $USet = " iw_product_weight_id = $iw_product_weight_id ";
        $objORM->DataUpdate($UCondition, $USet, TableIWNewMenu4);

    }
}