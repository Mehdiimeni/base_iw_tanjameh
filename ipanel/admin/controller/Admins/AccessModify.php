<?php
//AccessModify.php
include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";
$Enabled = BoolEnum::BOOL_TRUE();

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
$SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";
foreach ($objORM->FetchAll($SCondition, 'Name,IdKey', TableIWAdminGroup) as $ListItem) {
    $strGroupIdKey .= '<option value="' . $ListItem->IdKey . '">' . $ListItem->Name . '</option>';
}
//All Access
$SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";

$strAllAccess = '';
foreach ($objORM->FetchAll($SCondition, 'PartName,IdKey,Name,FaIcon', TableIWPanelAdminPart) as $ListItem) {
    $strAllAccess .= '<optgroup  label=' . $ListItem->PartName . '>';

    $SCondition = " Enabled = '$Enabled' AND PartIdKey = '$ListItem->IdKey'  ORDER BY IdRow ";
    foreach ($objORM->FetchAll($SCondition, 'PageName,Name,IdKey', TableIWPanelAdminPage) as $ListItem2) {
        $strAllAccess .= '<option value=' . $ListItem->IdKey . ';' . $ListItem2->IdKey . '>';
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
        $Enabled = BoolEnum::BOOL_TRUE();
        $SCondition = "  GroupIdKey = '$GroupIdKey'  ";

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
            $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            $ModifyTime = $objTimeTools->jdate("H:i:s");
            $ModifyDate = $objTimeTools->jdate("Y/m/d");

            $IdKey = $objAclTools->IdKey();

            $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));
            $InSet = "";
            $InSet .= " IdKey = '$IdKey' ,";
            $InSet .= " Enabled = '$Enabled' ,";
            $InSet .= " GroupIdKey = '$GroupIdKey' ,";
            $InSet .= " AllAccess = '$jsonAllAccess' ,";
            $InSet .= " AllTools = '$jsonAllTools' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " ModifyIP = '$ModifyIP' ,";
            $InSet .= " ModifyTime = '$ModifyTime' ,";
            $InSet .= " ModifyDate = '$ModifyDate' ,";
            $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $InSet .= " ModifyId = '$ModifyId' ";

            $objORM->DataAdd($InSet, TableIWAdminAccess);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  IdKey = '$IdKey' ";
    $objEditView = $objORM->Fetch($SCondition, 'AllAccess,AllTools,GroupIdKey,Description', TableIWAdminAccess);

    //Part Name
    $SCondition = "  IdKey = '$objEditView->GroupIdKey' ";
    $Item = $objORM->Fetch($SCondition, 'Name,IdKey', TableIWAdminGroup);
    $strGroupIdKey = '<option selected value="' . $Item->IdKey . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";
    foreach ($objORM->FetchAll($SCondition, 'Name,IdKey', TableIWAdminGroup) as $ListItem) {
        $strGroupIdKey .= '<option value="' . $ListItem->IdKey . '">' . $ListItem->Name . '</option>';
    }

    //All Access
    $SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";
    $arrExitViewAccess = ($objGlobalVar->JsonDecodeArray($objEditView->AllAccess));
    $strAllAccess = '';
    foreach ($objORM->FetchAll($SCondition, 'PartName,IdKey,Name,FaIcon', TableIWPanelAdminPart) as $ListItem) {
        $strAllAccess .= '<optgroup  label=' . $ListItem->PartName . '>';

        $SCondition = " Enabled = '$Enabled' AND PartIdKey = '$ListItem->IdKey'  ORDER BY IdRow ";
        foreach ($objORM->FetchAll($SCondition, 'PageName,Name,IdKey', TableIWPanelAdminPage) as $ListItem2) {
            $selected = '';
            if (isset($arrExitViewAccess[$ListItem->IdKey]))
                if (array_search($ListItem2->IdKey, $arrExitViewAccess[$ListItem->IdKey]) > -1)
                    $selected = 'selected';

            $strAllAccess .= '<option value=' . $ListItem->IdKey . ';' . $ListItem2->IdKey . ' ' . $selected . ' >';
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
    $strAllTools .= '<label><input name="AllTools[]" type="checkbox" class="js-switch" value="add" '.$AddChecked.' >' . (new ListTools())->ButtonReflectorIcon($arrToolsIcon["add"]) . '</label>';
    $strAllTools .= '<label><input name="AllTools[]" type="checkbox" class="js-switch" value="view" '.$ViewChecked.' >' . (new ListTools())->ButtonReflectorIcon($arrToolsIcon["view"]) . '</label>';
    $strAllTools .= '<label><input name="AllTools[]" type="checkbox" class="js-switch" value="edit" '.$EditChecked.' >' . (new ListTools())->ButtonReflectorIcon($arrToolsIcon["edit"]) . '</label>';
    $strAllTools .= '<label><input name="AllTools[]" type="checkbox" class="js-switch" value="active" '.$ActiveChecked.' >' . (new ListTools())->ButtonReflectorIcon($arrToolsIcon["active"]) . '</label>';
    $strAllTools .= '<label><input name="AllTools[]" type="checkbox" class="js-switch" value="delete" '.$DeleteChecked.' >' . (new ListTools())->ButtonReflectorIcon($arrToolsIcon["delete"]) . '</label>';


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

            $SCondition = "GroupIdKey = '$GroupIdKey' and IdKey != '$IdKey'  ";

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
                $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                $ModifyTime = $objTimeTools->jdate("H:i:s");
                $ModifyDate = $objTimeTools->jdate("Y/m/d");
                $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));

                $UCondition = " IdKey = '$IdKey' ";
                $USet = "";
                $USet .= " GroupIdKey = '$GroupIdKey' ,";
                $USet .= " AllAccess = '$jsonAllAccess' ,";
                $USet .= " AllTools = '$jsonAllTools' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " ModifyIP = '$ModifyIP' ,";
                $USet .= " ModifyTime = '$ModifyTime' ,";
                $USet .= " ModifyDate = '$ModifyDate' ,";
                $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
                $USet .= " ModifyId = '$ModifyId' ";

                $objORM->DataUpdate($UCondition, $USet, TableIWAdminAccess);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}


