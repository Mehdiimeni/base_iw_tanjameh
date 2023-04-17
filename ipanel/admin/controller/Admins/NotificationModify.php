<?php
//NotificationModify.php

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


//Admin Name
$strAdminIdKey = '';
$SCondition = " Enabled = '$Enabled' and CellNumber IS NOT NULL ORDER BY Name ";
foreach ($objORM->FetchAll($SCondition, 'Name,IdKey', TableIWAdmin) as $ListItem) {
    $strAdminIdKey .= '<option value="' . $ListItem->IdKey . '">' . $ListItem->Name . '</option>';
}

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    $arrExcept = array('Sms' => '', 'Email' => '');
    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {


        $Sms = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Sms);
        if ($Sms == null)
            $Sms = 0;
        $Email = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Email);
        if ($Email == null)
            $Email = 0;
        $AdminIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->AdminIdKey);

        $Enabled = BoolEnum::BOOL_TRUE();
        $SCondition = "  AdminIdKey = '$AdminIdKey' ";

        if ($objORM->DataExist($SCondition, TableIWAdminNotification)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

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
            $InSet .= " Sms = '$Sms' ,";
            $InSet .= " Email = '$Email' ,";
            $InSet .= " AdminIdKey = '$AdminIdKey' ,";
            $InSet .= " ModifyIP = '$ModifyIP' ,";
            $InSet .= " ModifyTime = '$ModifyTime' ,";
            $InSet .= " ModifyDate = '$ModifyDate' ,";
            $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $InSet .= " ModifyId = '$ModifyId' ";

            $objORM->DataAdd($InSet, TableIWAdminNotification);


            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  IdKey = '$IdKey' ";
    $objEditView = $objORM->Fetch($SCondition, 'Sms,AdminIdKey,Email', TableIWAdminNotification);


    //Admin Name
    $SCondition = "  IdKey = '$objEditView->AdminIdKey' ";
    $Item = $objORM->Fetch($SCondition, 'Name,IdKey', TableIWAdmin);
    $strAdminIdKey = '<option selected value="' . $Item->IdKey . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = '$Enabled' and CellNumber IS NOT NULL ORDER BY IdRow ";
    foreach ($objORM->FetchAll($SCondition, 'Name,IdKey', TableIWAdmin) as $ListItem) {
        $strAdminIdKey .= '<option value="' . $ListItem->IdKey . '">' . $ListItem->Name . '</option>';
    }

    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        $arrExcept = array('Sms' => '', 'Email' => '');
        if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $Sms = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Sms);
            if ($Sms == null)
                $Sms = 0;
            $Email = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Email);
            if ($Email == null)
                $Email = 0;
            $AdminIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->AdminIdKey);

            $SCondition = " AdminIdKey = '$AdminIdKey' and IdKey != '$IdKey'  ";

            if ($objORM->DataExist($SCondition, TableIWAdminNotification)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {


                $objTimeTools = new TimeTools();
                $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                $ModifyTime = $objTimeTools->jdate("H:i:s");
                $ModifyDate = $objTimeTools->jdate("Y/m/d");
                $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));

                $UCondition = " IdKey = '$IdKey' ";
                $USet = "";
                $USet .= " Sms = '$Sms' ,";
                $USet .= " Email = '$Email' ,";
                $USet .= " AdminIdKey = '$AdminIdKey' ,";
                $USet .= " ModifyIP = '$ModifyIP' ,";
                $USet .= " ModifyTime = '$ModifyTime' ,";
                $USet .= " ModifyDate = '$ModifyDate' ,";
                $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
                $USet .= " ModifyId = '$ModifyId' ";


                $objORM->DataUpdate($UCondition, $USet, TableIWAdminNotification);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}
