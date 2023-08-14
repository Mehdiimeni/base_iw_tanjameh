<?php
//NotificationModify.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
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


//Admin Name
$stradmin_id = '';
$SCondition = "  CellNumber IS NOT NULL ORDER BY Name ";
foreach ($objORM->FetchAll($SCondition, 'Name,iw_admin_id', TableIWAdminProfile) as $ListItem) {
    $stradmin_id .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
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
        $AdminId = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->AdminId);

        $Enabled = true;
        $SCondition = "  AdminId = '$AdminId' ";

        if ($objORM->DataExist($SCondition, TableIWAdminNotification)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            

            

            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

            $InSet = "";
            
            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " Sms = '$Sms' ,";
            $InSet .= " Email = '$Email' ,";
            $InSet .= " AdminId = '$AdminId' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWAdminNotification);


            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  id = $IdKey ";
    $objEditView = $objORM->Fetch($SCondition, 'Sms,AdminId,Email', TableIWAdminNotification);


    //Admin Name
    $SCondition = "  IdKey = '$objEditView->AdminId' ";
    $Item = $objORM->Fetch($SCondition, 'Name,id', TableIWAdmin);
    $stradmin_id = '<option selected value="' . $Item->id . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = $Enabled and CellNumber IS NOT NULL ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWAdmin) as $ListItem) {
        $stradmin_id .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
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
            $AdminId = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->AdminId);

            $SCondition = " AdminId = '$AdminId' and id!= $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWAdminNotification)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {


                $objTimeTools = new TimeTools();
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                
                
                $now_modify = date("Y-m-d H:i:s");
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

                $UCondition = " id = $IdKey ";
                $USet = "";
                $USet .= " Sms = '$Sms' ,";
                $USet .= " Email = '$Email' ,";
                $USet .= " AdminId = '$AdminId' ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                
                
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = $ModifyId ";


                $objORM->DataUpdate($UCondition, $USet, TableIWAdminNotification);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}
