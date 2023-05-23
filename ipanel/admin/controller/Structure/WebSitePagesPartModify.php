<?php
///controller/Structure/WebSitePagesPartModify.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
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

//WebSitePages Name
$strWebSitePages = '';
$SCondition = " Enabled = '$Enabled' ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'id,title', TableIWWebSitePages) as $ListItem) {
    $strWebSitePages .= '<option value="' . $ListItem->id . '">' . $ListItem->title . '</option>';
}

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {

    $arrExcept = array();
    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $title = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->title);
        $name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->name);
        $iw_web_pages_id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_web_pages_id);


        $SCondition = "title = '$title' and iw_web_pages_id='$iw_web_pages_id'   ";

        if ($objORM->DataExist($SCondition, TableIWWebSitePagesPart, 'id')) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {


            $IdKey = $objAclTools->IdKey();
            $modify_id = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();

            $InSet = "";
            $InSet .= " IdKey = '$IdKey' ,";
            $InSet .= " Enabled = '$Enabled' ,";
            $InSet .= " title = '$title' ,";
            $InSet .= " name = '$name' ,";
            $InSet .= " modify_id = '$modify_id', ";
            $InSet .= " modify_ip = '$modify_ip' ,";
            $InSet .= " iw_web_pages_id = '$iw_web_pages_id' ";

            $objORM->DataAdd($InSet, TableIWWebSitePagesPart);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (!isset($_POST['SubmitApi']) and @$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  IdKey = '$IdKey' ";
    $objEditView = $objORM->Fetch($SCondition, '*', TableIWWebSitePagesPart);



    //WebSitePages Name
    $SCondition = "  id = '$objEditView->iw_web_pages_id' ";
    $Item = $objORM->Fetch($SCondition, 'title,id', TableIWWebSitePages);
    $strWebSitePages = '<option selected value="' . $Item->id . '">' . $Item->title . '</option>';
    $SCondition = " Enabled = '$Enabled' ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'title,id', TableIWWebSitePages) as $ListItem) {
        $strWebSitePages .= '<option value="' . $ListItem->id . '">' . $ListItem->title . '</option>';
    }


    if (isset($_POST['SubmitM'])) {
        $arrExcept = array('');
        if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $title = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->title);
            $name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->name);
            $iw_web_pages_id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_web_pages_id);

            $SCondition = "( name = '$name' and iw_web_pages_id = '$iw_web_pages_id'  ) and IdKey != '$IdKey'  ";

            if ($objORM->DataExist($SCondition, TableIWWebSitePagesPart, 'id')) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {

                $modify_id = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();

                $UCondition = " IdKey = '$IdKey' ";
                $USet = "";
                $USet .= " title = '$title' ,";
                $USet .= " name = '$name' ,";
                $USet .= " modify_id = '$modify_id', ";
                $USet .= " modify_ip = '$modify_ip' ,";
                $USet .= " iw_web_pages_id = '$iw_web_pages_id' ";

                $objORM->DataUpdate($UCondition, $USet, TableIWWebSitePagesPart);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}