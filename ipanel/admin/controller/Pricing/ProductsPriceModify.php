<?php
//Productsiw_currencies_conversion_idModify.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
$Enabled = true;


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


//Currencies 
$list_Currencies = '';
$SCondition = " Enabled = 1 ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWACurrencies) as $ListItem) {
    $list_Currencies .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
}


if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    $arrExcept = array('Description' => '');
    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {


        $iw_currencies_conversion_id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_currencies_conversion_id);
        $ChangeRate = (float) $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->ChangeRate);
        $Smaller = (float) $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Smaller);
        $Bigger = (float) $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Bigger);
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);


        $Enabled = true;
        $SCondition = " Smaller = '$Smaller' AND Bigger = '$Bigger' AND iw_currencies_conversion_id = '$iw_currencies_conversion_id' ";

        if ($objORM->DataExist($SCondition, TableIWAProductPrice)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();





            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

            $InSet = "";

            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " iw_currencies_conversion_id = '$iw_currencies_conversion_id' ,";
            $InSet .= " ChangeRate = $ChangeRate ,";
            $InSet .= " Smaller = $Smaller ,";
            $InSet .= " Bigger = $Bigger ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";


            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWAProductPrice);


            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $id = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  id = $id ";
    $objEditView = $objORM->Fetch($SCondition, 'Bigger,iw_currencies_conversion_id,ChangeRate,Smaller,Description', TableIWAProductPrice);


    //Currencies
    $SCondition = "  id = '$objEditView->iw_currencies_conversion_id' ";
    $Item = $objORM->Fetch($SCondition, 'Name,id', TableIWACurrencies);
    $list_Currencies = '<option selected value="' . $Item->id . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = 1 ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWACurrencies) as $ListItem) {
        $list_Currencies .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
    }

    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        $arrExcept = array('Description' => '');
        if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $iw_currencies_conversion_id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_currencies_conversion_id);
            $ChangeRate = (float) $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->ChangeRate);
            $Smaller = (float) $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Smaller);
            $Bigger = (float) $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Bigger);
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $SCondition = "Smaller = '$Smaller' AND Bigger = '$Bigger' and id!= $id  ";

            if ($objORM->DataExist($SCondition, TableIWAProductPrice)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {


                $objTimeTools = new TimeTools();
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();


                $now_modify = date("Y-m-d H:i:s");
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

                $USet = " iw_currencies_conversion_id = $iw_currencies_conversion_id ,";
                $USet .= " ChangeRate = $ChangeRate ,";
                $USet .= " Smaller = $Smaller ,";
                $USet .= " Bigger = $Bigger ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = $ModifyId ";

                $objORM->DataUpdate(" id = $id ", $USet, TableIWAProductPrice);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}