<?php
///controller/Structure/WebSiteInfoModify.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
$Enabled = true;
$objAclTools = new ACLTools();
$objTimeTools = new TimeTools();




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

    $arrExcept = array('address' => '');
    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $website_name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->website_name);
        $website_title = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->website_title);
        $email = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->email);
        $main_phone = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->main_phone);
        $company = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->company);
        $website_address = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->website_address);

        $SCondition = "website_name = '$website_name'   ";

        if ($objORM->DataExist($SCondition, TableIWWebSiteInfo,'id')) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {


            $IdKey = $objAclTools->IdKey();
            $modify_id = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();

            $InSet = "";
            $InSet .= " IdKey = '$IdKey' ,";
            $InSet .= " Enabled = '$Enabled' ,";
            $InSet .= " website_name = '$website_name' ,";
            $InSet .= " website_title = '$website_title' ,";
            $InSet .= " email = '$email' ,";
            $InSet .= " main_phone = '$main_phone' ,";
            $InSet .= " company = '$company' ,";
            $InSet .= " website_address = '$website_address' ,";
            $InSet .= " modify_id = '$modify_id' ,";
            $InSet .= " modify_ip = '$modify_ip'";

            $objORM->DataAdd($InSet, TableIWWebSiteInfo);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (!isset($_POST['SubmitApi']) and @$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  IdKey = '$IdKey' ";
    $objEditView = $objORM->Fetch($SCondition, '*', TableIWWebSiteInfo);


    if (isset($_POST['SubmitM'])) {
        $arrExcept = array('address' => '');
        if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $website_name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->website_name);
            $website_title = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->website_title);
            $email = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->email);
            $main_phone = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->main_phone);
            $company = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->company);
            $website_address = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->website_address);

            $SCondition = "( website_name = '$website_name'  ) and IdKey != '$IdKey'  ";

            if ($objORM->DataExist($SCondition, TableIWWebSiteInfo,'id')) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {

                $modify_id = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();

                $UCondition = " IdKey = '$IdKey' ";
                $USet = "";
                $USet .= " website_name = '$website_name' ,";
                $USet .= " website_title = '$website_title' ,";
                $USet .= " email = '$email' ,";
                $USet .= " main_phone = '$main_phone' ,";
                $USet .= " company = '$company' ,";
                $USet .= " website_address = '$website_address' ,";
                $USet .= " modify_id = '$modify_id', ";
                $USet .= " modify_ip = '$modify_ip' ";

                $objORM->DataUpdate($UCondition, $USet, TableIWWebSiteInfo);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}