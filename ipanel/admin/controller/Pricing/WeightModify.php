<?php
//WeightModify.php

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





if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    $arrExcept = array('Description' => '','ExtraPrice'=>'');
    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {


        $Weight = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Weight);
        $NormalPrice = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->NormalPrice);
        $ExtraPrice = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->ExtraPrice);
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);


        $Enabled = true;
        $SCondition = " Weight = '$Weight' ";

        if ($objORM->DataExist($SCondition, TableIWWebWeightPrice)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            

            

            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

            $InSet = "";
            
            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " Weight = $Weight ,";
            $InSet .= " NormalPrice = $NormalPrice ,";
            $InSet .= " ExtraPrice = $ExtraPrice ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWWebWeightPrice);


            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  id = $IdKey ";
    $objEditView = $objORM->Fetch($SCondition, 'Weight,NormalPrice,ExtraPrice,Description', TableIWWebWeightPrice);


    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        $arrExcept = array('Description' => '','ExtraPrice'=>'');
        if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $Weight = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Weight);
            $NormalPrice = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->NormalPrice);
            $ExtraPrice = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->ExtraPrice);
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $SCondition = "Weight = '$Weight' AND id!= $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWWebWeightPrice)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {


                $objTimeTools = new TimeTools();
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                
                
                $now_modify = date("Y-m-d H:i:s");
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

                $UCondition = " id = $IdKey ";
                $USet = "";
                $USet .= " Weight = $Weight ,";
                $USet .= " NormalPrice = $NormalPrice ,";
                $USet .= " ExtraPrice = $ExtraPrice ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                
                
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = $ModifyId ";

                $objORM->DataUpdate($UCondition, $USet, TableIWWebWeightPrice);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}






