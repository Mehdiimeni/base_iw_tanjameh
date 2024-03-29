<?php
///controller/Structure/WebSiteAlertModify.php

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

//Website Name
$strWebsiteName = '';
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'id,website_name', TableIWWebSiteInfo) as $ListItem) {
    $strWebsiteName .= '<option value="' . $ListItem->id . '">' . $ListItem->website_name . '</option>';
}


if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {

    $arrExcept = array('alert_content' => '');
    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $alert_name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->alert_name);
        $alert_type = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->alert_type);
        $alert_content = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->alert_content);
        $iw_website_info_id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_website_info_id);

        $SCondition = "alert_name = '$alert_name' and iw_website_info_id='$iw_website_info_id'   ";

        if ($objORM->DataExist($SCondition, TableIWWebSiteAlert, 'id')) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {


            
            $modify_id = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();

            $InSet = "";
            
            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " alert_name = '$alert_name' ,";
            $InSet .= " alert_type = '$alert_type' ,";
            $InSet .= " alert_content = '$alert_content' ,";
            $InSet .= " modify_id = $modify_id ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            $InSet .= " iw_website_info_id = '$iw_website_info_id' ";

            $objORM->DataAdd($InSet, TableIWWebSiteAlert);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (!isset($_POST['SubmitApi']) and @$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  id = $IdKey ";
    $objEditView = $objORM->Fetch($SCondition, '*', TableIWWebSiteAlert);


    //Website Name
    $SCondition = "  id = '$objEditView->iw_website_info_id' ";
    $Item = $objORM->Fetch($SCondition, 'website_name,id', TableIWWebSiteInfo);
    $strMenuIdKey = '<option selected value="' . $Item->id . '">' . $Item->website_name . '</option>';
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'website_name,id', TableIWWebSiteInfo) as $ListItem) {
        $strMenuIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->website_name . '</option>';
    }


    if (isset($_POST['SubmitM'])) {
        $arrExcept = array('alert_content' => '');
        if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $alert_name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->alert_name);
            $alert_type = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->alert_type);
            $alert_content = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->alert_content);
            $iw_website_info_id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_website_info_id);

            $SCondition = "( alert_name = '$alert_name' and iw_website_info_id='$iw_website_info_id'  ) and id!= $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWWebSiteAlert, 'id')) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {

                $modify_id = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();

                $UCondition = " id = $IdKey ";
                $USet = "";
                $USet .= " alert_name = '$alert_name' ,";
                $USet .= " alert_type = '$alert_type' ,";
                $USet .= " alert_content = '$alert_content' ,";
                $USet .= " modify_id = $modify_id, ";
                $USet .= " modify_ip = '$modify_ip' ,";
                $USet .= " iw_website_info_id = '$iw_website_info_id' ";

                $objORM->DataUpdate($UCondition, $USet, TableIWWebSiteAlert);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}