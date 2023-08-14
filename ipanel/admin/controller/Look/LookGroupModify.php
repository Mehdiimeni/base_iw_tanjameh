<?php
///controller/look/LookGroupModify.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
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

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->name);
        $root = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->root);

        $SCondition = "  name = '$name' and root = '$root'  ";

        if ($objORM->DataExist($SCondition, TableIWUserLookGroup)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            $now_modify = date("Y-m-d H:i:s");

            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

            $InSet = " enabled = 1 ,";
            $InSet .= " name = '$name' ,";
            $InSet .= " root = '$root' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = '$ModifyId' ";

            $objORM->DataAdd($InSet, TableIWUserLookGroup);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {

    $id = $objGlobalVar->RefFormGet()[0];
    $objEditView = $objORM->Fetch(" id = $id", 'name,root', TableIWUserLookGroup);

    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->name);
            $root = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->root);

            $SCondition = " name = '$name' and root = '$root' and id != $id  ";

            if ($objORM->DataExist($SCondition, TableIWUserLookGroup)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {

                $objTimeTools = new TimeTools();
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                $now_modify = date("Y-m-d H:i:s");
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

                $USet = " enabled = 1 ,";
                $USet .= " name = '$name' ,";
                $USet .= " root = '$root' ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = '$ModifyId' ";

                $objORM->DataUpdate(" id = $id ", $USet, TableIWUserLookGroup);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}