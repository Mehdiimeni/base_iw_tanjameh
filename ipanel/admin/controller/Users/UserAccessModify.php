<?php
//UserAccessModify.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";
$Enabled = true;

switch ($objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->modify) {
    case 'add' :
        $strModifyTitle = FA_LC["add"];
        break;
    case 'edit' :
        $strModifyTitle = FA_LC["edit"];
        break;
    case 'view' :
        $strModifyTitle = FA_LC["view"];
        break;
}

//Group Name
$strGroupIdKey = '';
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWUserGroup) as $ListItem) {
    $strGroupIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
}
//All Access
$SCondition = " Enabled = $Enabled ORDER BY id ";

$strAllAccess = '';
foreach ($objORM->FetchAll($SCondition, 'PartName,id,Name,FaIcon', TableIWPanelUserPart) as $ListItem) {
    $strAllAccess .= '<optgroup  label=' . $ListItem->PartName . '>';

    $SCondition = " Enabled = $Enabled AND iw_panel_user_part_id = $ListItem->id  ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'PageName,Name,id', TableIWPanelUserPage) as $ListItem2) {
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

        $GroupIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->GroupIdKey);
        $AllAccess = $objAclTools->JsonDecode($objAclTools->PostVarToJson())->AllAccess;
        $AllTools = $objAclTools->JsonDecode($objAclTools->PostVarToJson())->AllTools;
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);
        $Enabled = true;
        $SCondition = "  GroupIdKey = '$GroupIdKey'  ";

        if ($objORM->DataExist($SCondition, TableIWUserAccess)) {
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
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            

            

            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));
            $InSet = "";
            
            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " GroupIdKey = '$GroupIdKey' ,";
            $InSet .= " AllAccess = '$jsonAllAccess' ,";
            $InSet .= " AllTools = '$jsonAllTools' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWUserAccess);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  id = $IdKey ";
    $objEditView = $objORM->Fetch($SCondition, 'AllAccess,AllTools,GroupIdKey,Description', TableIWUserAccess);

    //Part Name
    $SCondition = "  IdKey = '$objEditView->GroupIdKey' ";
    $Item = $objORM->Fetch($SCondition, 'Name,id', TableIWUserGroup);
    $strGroupIdKey = '<option selected value="' . $Item->id . '">' . $Item->Name . '</option>';

    //All Access
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    $arrExitViewAccess = ($objGlobalVar->JsonDecodeArray($objEditView->AllAccess));
    $strAllAccess = '';
    foreach ($objORM->FetchAll($SCondition, 'PartName,id,Name,FaIcon', TableIWPanelUserPart) as $ListItem) {
        $strAllAccess .= '<optgroup  label=' . $ListItem->PartName . '>';

        $SCondition = " Enabled = $Enabled AND iw_panel_user_part_id = $ListItem->id  ORDER BY id ";
        foreach ($objORM->FetchAll($SCondition, 'PageName,Name,id', TableIWPanelUserPage) as $ListItem2) {
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

            $GroupIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->GroupIdKey);
            $AllAccess = $objAclTools->JsonDecode($objAclTools->PostVarToJson())->AllAccess;
            $AllTools = $objAclTools->JsonDecode($objAclTools->PostVarToJson())->AllTools;
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $SCondition = "GroupIdKey = '$GroupIdKey' and id!= $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWUserAccess)) {
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
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                
                
                $now_modify = date("Y-m-d H:i:s");
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

                $UCondition = " id = $IdKey ";
                $USet = "";
                $USet .= " AllAccess = '$jsonAllAccess' ,";
                $USet .= " AllTools = '$jsonAllTools' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                
                
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = $ModifyId ";

                $objORM->DataUpdate($UCondition, $USet, TableIWUserAccess);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}



