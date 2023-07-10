<?php
//AccessModify.php
require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";
$Enabled = true;

switch ($objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->modify) {
    case 'add':
        $strModifyTitle = FA_LC["add"];
        break;
    case 'edit':
        $strModifyTitle = FA_LC["edit"];
        break;
    case 'view':
        $strModifyTitle = FA_LC["view"];
        break;
}

//Group Name
$striw_admin_group_id = '';
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWAdminGroup) as $ListItem) {
    $striw_admin_group_id .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
}
//All Access
$SCondition = " Enabled = $Enabled ORDER BY id ";

$strAllAccess = '';
foreach ($objORM->FetchAll($SCondition, 'PartName,id,Name,FaIcon', TableIWPanelAdminPart) as $ListItem) {
    $strAllAccess .= '<optgroup  label=' . $ListItem->PartName . '>';

    $SCondition = " Enabled = $Enabled AND iw_panel_admin_part_id = $ListItem->id  ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'PageName,Name,id', TableIWPanelAdminPage) as $ListItem2) {
        $strAllAccess .= '<option value=' . $ListItem->id . ';' . $ListItem2->id . '>';
        $strAllAccess .= $ListItem2->PageName;
        $strAllAccess .= '</option>';

    }
    $strAllAccess .= '</optgroup>';
}

//All Tools
$strAllTools = '';
$strAllTools .= '<label><input name="AllTools[]" type="checkbox" class="js-switch" value="add" >' . (new ListTools())->ButtonReflectorIcon($arrToolsIcon["add"]) . '</label>';
$strAllTools .= '<label><input name="AllTools[]" type="checkbox" class="js-switch" value="view" >' . (new ListTools())->ButtonReflectorIcon($arrToolsIcon["view"]) . '</label>';
$strAllTools .= '<label><input name="AllTools[]" type="checkbox" class="js-switch" value="edit" >' . (new ListTools())->ButtonReflectorIcon($arrToolsIcon["edit"]) . '</label>';
$strAllTools .= '<label><input name="AllTools[]" type="checkbox" class="js-switch" value="active" >' . (new ListTools())->ButtonReflectorIcon($arrToolsIcon["active"]) . '</label>';
$strAllTools .= '<label><input name="AllTools[]" type="checkbox" class="js-switch" value="delete" >' . (new ListTools())->ButtonReflectorIcon($arrToolsIcon["delete"]) . '</label>';

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {

    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson()) or $objAclTools->JsonDecode($objAclTools->PostVarToJson())->AllAccess == null or $objAclTools->JsonDecode($objAclTools->PostVarToJson())->AllTools == null) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $iw_admin_group_id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_admin_group_id);
        $AllAccess = $objAclTools->JsonDecode($objAclTools->PostVarToJson())->AllAccess;
        $AllTools = $objAclTools->JsonDecode($objAclTools->PostVarToJson())->AllTools;
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);
        $Enabled = true;
        $SCondition = "  iw_admin_group_id = $iw_admin_group_id  ";

        if ($objORM->DataExist($SCondition, TableIWAdminAccess)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            foreach ($AllAccess as $access) {

                $expStr = explode(";", $access);
                $arrStr[$expStr[0]][] = $expStr[1];

            }
            $jsonAllAccess = $objAclTools->JsonEncode($arrStr);
            $jsonAllTools = $objAclTools->JsonEncode($AllTools);

            $objTimeTools = new TimeTools();
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            $now_modify = date("Y-m-d H:i:s");

            $InSet = " Enabled = $Enabled ";
            $InSet .= " iw_admin_group_id = $iw_admin_group_id ,";
            $InSet .= " AllAccess = '$jsonAllAccess' ,";
            $InSet .= " AllTools = '$jsonAllTools' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = '$ModifyId' ";

            $objORM->DataAdd($InSet, TableIWAdminAccess);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $objEditView = $objORM->Fetch(
        " id = $IdKey",
        'AllAccess,
        AllTools,
        iw_admin_group_id,
        Description',
        TableIWAdminAccess
    );

    //Part Name
    $Item = $objORM->Fetch(
        "id = $objEditView->iw_admin_group_id",
        'Name,id',
        TableIWAdminGroup
    );

    $striw_admin_group_id = '<option selected value="' . $Item->id . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWAdminGroup) as $ListItem) {
        $striw_admin_group_id .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
    }

    //All Access
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    $arrExitViewAccess = ($objGlobalVar->JsonDecodeArray($objEditView->AllAccess));
    $strAllAccess = '';
    foreach ($objORM->FetchAll($SCondition, 'PartName,id,Name,FaIcon', TableIWPanelAdminPart) as $ListItem) {
        $strAllAccess .= '<optgroup  label=' . $ListItem->PartName . '>';

        $SCondition = " Enabled = $Enabled AND iw_panel_admin_part_id = $ListItem->id  ORDER BY id ";
        foreach ($objORM->FetchAll($SCondition, 'PageName,Name,id', TableIWPanelAdminPage) as $ListItem2) {
            $selected = '';
            if (isset($arrExitViewAccess[$ListItem->id]))
                if (array_search($ListItem2->id, $arrExitViewAccess[$ListItem->id]) > -1)
                    $selected = 'selected';

            $strAllAccess .= '<option value=' . $ListItem->id . ';' . $ListItem2->id . ' ' . $selected . ' >';
            $strAllAccess .= $ListItem2->PageName;
            $strAllAccess .= '</option>';

        }
        $strAllAccess .= '</optgroup>';

    }

    //All Tools
    $arrExitViewTools = ($objGlobalVar->JsonDecodeArray($objEditView->AllTools));
    array_search('add', $arrExitViewTools) > -1 ? $AddChecked = 'checked' : $AddChecked = null;
    array_search('view', $arrExitViewTools) > -1 ? $ViewChecked = 'checked' : $ViewChecked = null;
    array_search('edit', $arrExitViewTools) > -1 ? $EditChecked = 'checked' : $EditChecked = null;
    array_search('active', $arrExitViewTools) > -1 ? $ActiveChecked = 'checked' : $ActiveChecked = null;
    array_search('delete', $arrExitViewTools) > -1 ? $DeleteChecked = 'checked' : $DeleteChecked = null;


    $strAllTools = '';
    $strAllTools .= '<label><input name="AllTools[]" type="checkbox" class="js-switch" value="add" ' . $AddChecked . ' >' . (new ListTools())->ButtonReflectorIcon($arrToolsIcon["add"]) . '</label>';
    $strAllTools .= '<label><input name="AllTools[]" type="checkbox" class="js-switch" value="view" ' . $ViewChecked . ' >' . (new ListTools())->ButtonReflectorIcon($arrToolsIcon["view"]) . '</label>';
    $strAllTools .= '<label><input name="AllTools[]" type="checkbox" class="js-switch" value="edit" ' . $EditChecked . ' >' . (new ListTools())->ButtonReflectorIcon($arrToolsIcon["edit"]) . '</label>';
    $strAllTools .= '<label><input name="AllTools[]" type="checkbox" class="js-switch" value="active" ' . $ActiveChecked . ' >' . (new ListTools())->ButtonReflectorIcon($arrToolsIcon["active"]) . '</label>';
    $strAllTools .= '<label><input name="AllTools[]" type="checkbox" class="js-switch" value="delete" ' . $DeleteChecked . ' >' . (new ListTools())->ButtonReflectorIcon($arrToolsIcon["delete"]) . '</label>';


    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        if ($objAclTools->CheckNull($objAclTools->PostVarToJson()) or @$objAclTools->JsonDecode($objAclTools->PostVarToJson())->AllAccess == null or $objAclTools->JsonDecode($objAclTools->PostVarToJson())->AllTools == null) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $iw_admin_group_id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_admin_group_id);
            $AllAccess = $objAclTools->JsonDecode($objAclTools->PostVarToJson())->AllAccess;
            $AllTools = $objAclTools->JsonDecode($objAclTools->PostVarToJson())->AllTools;
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $SCondition = "iw_admin_group_id = $iw_admin_group_id and id != $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWAdminAccess)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {

                foreach ($AllAccess as $access) {

                    $expStr = explode(";", $access);
                    $arrStr[$expStr[0]][] = $expStr[1];

                }
                $jsonAllAccess = $objAclTools->JsonEncode($arrStr);
                $jsonAllTools = $objAclTools->JsonEncode($AllTools);


                $objTimeTools = new TimeTools();

                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                $now_modify = date("Y-m-d H:i:s");

                $UCondition = " id = $IdKey ";
                $USet = " iw_admin_group_id = '$iw_admin_group_id' ,";
                $USet .= " AllAccess = '$jsonAllAccess' ,";
                $USet .= " AllTools = '$jsonAllTools' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = '$ModifyId' ";

                $objORM->DataUpdate($UCondition, $USet, TableIWAdminAccess);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}