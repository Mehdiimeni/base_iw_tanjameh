<?php
///controller/Structure/WebSiteSpAdverModify.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
$Enabled = true;
$objAclTools = new ACLTools();
$objTimeTools = new TimeTools();

//No Image
$strBannerAdverImage = '';

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

//WebSitePagesPart Name
$strWebSitePart = '';
$SCondition = " Enabled = '$Enabled' ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'id,title', TableIWWebSitePagesPart) as $ListItem) {
    $strWebSitePart .= '<option value="' . $ListItem->id . '">' . $ListItem->title . '</option>';
}

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {

    $arrExcept = array();
    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $title = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->title);
        $content = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->content);
        $condition_statement = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->condition_statement);
        $bottom_caption = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->bottom_caption);
        $iw_web_pages_part_id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_web_pages_part_id);


        $SCondition = "title = '$title' and iw_web_pages_part_id='$iw_web_pages_part_id'   ";

        if ($objORM->DataExist($SCondition, TableIWWebSiteSpAdver, 'id')) {
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
            $InSet .= " content = '$content' ,";
            $InSet .= " condition_statement = '$condition_statement' ,";
            $InSet .= " bottom_caption = '$bottom_caption' ,";
            $InSet .= " modify_id = '$modify_id', ";
            $InSet .= " modify_ip = '$modify_ip' ,";
            $InSet .= " iw_web_pages_part_id = '$iw_web_pages_part_id' ";

            $objORM->DataAdd($InSet, TableIWWebSiteSpAdver);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (!isset($_POST['SubmitApi']) and @$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  IdKey = '$IdKey' ";
    $objEditView = $objORM->Fetch($SCondition, '*', TableIWWebSiteSpAdver);


    //WebSitePagesPart Name
    $SCondition = "  id = '$objEditView->iw_web_pages_part_id' ";
    $Item = $objORM->Fetch($SCondition, 'title,id', TableIWWebSitePagesPart);
    $strWebSitePart = '<option selected value="' . $Item->id . '">' . $Item->title . '</option>';
    $SCondition = " Enabled = '$Enabled' ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'title,id', TableIWWebSitePagesPart) as $ListItem) {
        $strWebSitePart .= '<option value="' . $ListItem->id . '">' . $ListItem->title . '</option>';
    }


    if (isset($_POST['SubmitM'])) {
        $arrExcept = array('');
        if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $title = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->title);
            $content = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->content);
            $condition_statement = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->condition_statement);
            $bottom_caption = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->bottom_caption);
            $iw_web_pages_part_id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_web_pages_part_id);

            $SCondition = "( title = '$title' and iw_web_pages_part_id = '$iw_web_pages_part_id'  ) and IdKey != '$IdKey'  ";

            if ($objORM->DataExist($SCondition, TableIWWebSiteSpAdver, 'id')) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {

                $modify_id = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();

                $UCondition = " IdKey = '$IdKey' ";
                $USet = "";
                $USet .= " title = '$title' ,";
                $USet .= " content = '$content' ,";
                $USet .= " condition_statement = '$condition_statement' ,";
                $USet .= " bottom_caption = '$bottom_caption' ,";
                $USet .= " modify_id = '$modify_id', ";
                $USet .= " modify_ip = '$modify_ip' ,";
                $USet .= " iw_web_pages_part_id = '$iw_web_pages_part_id' ";

                $objORM->DataUpdate($UCondition, $USet, TableIWWebSiteSpAdver);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}