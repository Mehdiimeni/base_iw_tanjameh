<?php
//ProcessingCodeGroupModify.php

$apiMainName = 'ProcessingCodeGroup';

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
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

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
        $objRNLS2 = new RNLS2Connection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, "");
        /*
         $Title = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Title);
         $strSearch = "Title%20in%20(\'888\')";
         var_dump($objRNLS2->Search($strSearch));
         exit();

         if ($objORM->DataExist($SCondition, TableIWAdminGroup)) {
             JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
             exit();

         } else {
 */

        $Title = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Title);
        $arrPost = array('Title' => $Title, 'IsActive' => true);
        $JsonPostData = $objAclTools->JsonEncode($arrPost);

        $objRNLS2->Post($JsonPostData);

        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
        exit();


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
    $objRNLS2 = new RNLS2Connection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName . "/" . $IdKey, "");
    $objEditView = $objGlobalVar->ObjectJson($objRNLS2->connect());

    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $Title = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Title);
            $arrPatch = array('Title' => $Title);
            $JsonPatchData = $objAclTools->JsonEncode($arrPatch);

            $objRNLS2->Patch($JsonPatchData);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
            exit();


        }

    }
}





