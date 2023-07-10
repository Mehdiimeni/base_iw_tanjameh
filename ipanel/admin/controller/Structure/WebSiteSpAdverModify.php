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
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'id,title,iw_website_pages_id', TableIWWebSitePagesPart) as $ListItem) {
    $page_title = $objORM->Fetch(" id = $ListItem->iw_website_pages_id ","title",TableIWWebSitePages)->title;
    $strWebSitePart .= '<option value="' . $ListItem->id . '">' .$page_title.' | '.$ListItem->title . '</option>';
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
        $bottom_link = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->bottom_link);
        $iw_website_pages_part_id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_website_pages_part_id);


        $SCondition = "title = '$title' and iw_website_pages_part_id='$iw_website_pages_part_id'   ";

        if ($objORM->DataExist($SCondition, TableIWWebSiteSpAdver, 'id')) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {


            
            $modify_id = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();

            $InSet = "";
            
            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " title = '$title' ,";
            $InSet .= " content = '$content' ,";
            $InSet .= " condition_statement = '$condition_statement' ,";
            $InSet .= " bottom_caption = '$bottom_caption' ,";
            $InSet .= " bottom_link = '$bottom_link' ,";
            $InSet .= " modify_id = '$modify_id', ";
            $InSet .= " modify_ip = '$modify_ip' ,";
            $InSet .= " iw_website_pages_part_id = '$iw_website_pages_part_id' ";

            $objORM->DataAdd($InSet, TableIWWebSiteSpAdver);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (!isset($_POST['SubmitApi']) and @$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  id = $IdKey ";
    $objEditView = $objORM->Fetch($SCondition, '*', TableIWWebSiteSpAdver);


    //WebSitePagesPart Name
    $SCondition = "  id = '$objEditView->iw_website_pages_part_id' ";
    $Item = $objORM->Fetch($SCondition, 'title,id,iw_website_pages_id', TableIWWebSitePagesPart);
    $page_title = $objORM->Fetch(" id = $Item->iw_website_pages_id ","title",TableIWWebSitePages)->title;
    $strWebSitePart = '<option selected value="' . $Item->id . '">' .$page_title.' | '. $Item->title . '</option>';
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'title,id,iw_website_pages_id', TableIWWebSitePagesPart) as $ListItem) {
        $page_title = $objORM->Fetch(" id = $ListItem->iw_website_pages_id ","title",TableIWWebSitePages)->title;
        $strWebSitePart .= '<option value="' . $ListItem->id . '">' .$page_title.' | '. $ListItem->title . '</option>';
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
            $bottom_link = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->bottom_link);
            $iw_website_pages_part_id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_website_pages_part_id);

            $SCondition = "( title = '$title' and iw_website_pages_part_id = '$iw_website_pages_part_id'  ) and id!= $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWWebSiteSpAdver, 'id')) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {

                $modify_id = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();

                $UCondition = " id = $IdKey ";
                $USet = "";
                $USet .= " title = '$title' ,";
                $USet .= " content = '$content' ,";
                $USet .= " condition_statement = '$condition_statement' ,";
                $USet .= " bottom_caption = '$bottom_caption' ,";
                $USet .= " bottom_link = '$bottom_link' ,";
                $USet .= " modify_id = '$modify_id', ";
                $USet .= " modify_ip = '$modify_ip' ,";
                $USet .= " iw_website_pages_part_id = '$iw_website_pages_part_id' ";

                $objORM->DataUpdate($UCondition, $USet, TableIWWebSiteSpAdver);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}