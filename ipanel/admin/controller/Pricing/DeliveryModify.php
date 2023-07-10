<?php
//DeliveryModify.php

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


//Currencies 
$strCompanyIdKey = '';
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWWebLogo) as $ListItem) {
    $strCompanyIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
}


if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    $arrExcept = array('Description' => '');
    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {


        $CompanyIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->CompanyIdKey);
        $ChangeRate = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->ChangeRate);
        $Smaller = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Smaller);
        $Bigger = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Bigger);
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);


        $Enabled = true;
        $SCondition = " Smaller = '$Smaller' AND Bigger = '$Bigger' AND CompanyIdKey = '$CompanyIdKey' ";

        if ($objORM->DataExist($SCondition, TableIWAProductDeliveryPrice)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            

            

            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

            $InSet = "";
            
            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " CompanyIdKey = '$CompanyIdKey' ,";
            $InSet .= " ChangeRate = $ChangeRate ,";
            $InSet .= " Smaller = $Smaller ,";
            $InSet .= " Bigger = $Bigger ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWAProductDeliveryPrice);


            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  id = $IdKey ";
    $objEditView = $objORM->Fetch($SCondition, 'Bigger,CompanyIdKey,ChangeRate,Smaller,Description', TableIWAProductDeliveryPrice);


    //Currencies
    $SCondition = "  IdKey = '$objEditView->CompanyIdKey' ";
    $Item = $objORM->Fetch($SCondition, 'Name,id', TableIWWebLogo);
    $strCompanyIdKey = '<option selected value="' . $Item->id . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWWebLogo) as $ListItem) {
        $strCompanyIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
    }

    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        $arrExcept = array('Description' => '');
        if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $CompanyIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->CompanyIdKey);
            $ChangeRate = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->ChangeRate);
            $Smaller = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Smaller);
            $Bigger = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Bigger);
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $SCondition = "Smaller = '$Smaller' AND Bigger = '$Bigger' and id!= $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWAProductDeliveryPrice)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {


                $objTimeTools = new TimeTools();
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                
                
                $now_modify = date("Y-m-d H:i:s");
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

                $UCondition = " id = $IdKey ";
                $USet = "";
                $USet .= " CompanyIdKey = '$CompanyIdKey' ,";
                $USet .= " ChangeRate = $ChangeRate ,";
                $USet .= " Smaller = $Smaller ,";
                $USet .= " Bigger = $Bigger ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                
                
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = $ModifyId ";

                $objORM->DataUpdate($UCondition, $USet, TableIWAProductDeliveryPrice);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}






