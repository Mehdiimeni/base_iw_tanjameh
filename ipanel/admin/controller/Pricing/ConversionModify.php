<?php
//ConversionModify.php

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


//Currencies 1
$strCurrencyIdKey1 = '';
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWACurrencies) as $ListItem) {
    $strCurrencyIdKey1 .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
}

//Currencies 2
$strCurrencyIdKey2 = '';
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWACurrencies) as $ListItem) {
    $strCurrencyIdKey2 .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
}

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    $arrExcept = array('Description' => '');
    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {



        $Rate = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Rate);
        $CurrencyIdKey1 = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->CurrencyIdKey1);
        $CurrencyIdKey2 = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->CurrencyIdKey2);
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);


        $Enabled = true;
        $SCondition = " CurrencyIdKey1 = '$CurrencyIdKey1' AND CurrencyIdKey2 = '$CurrencyIdKey1' ";

        if ($objORM->DataExist($SCondition, TableIWACurrenciesConversion)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            

            

            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

            $InSet = "";
            
            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " Rate = $Rate ,";
            $InSet .= " CurrencyIdKey1 = '$CurrencyIdKey1' ,";
            $InSet .= " CurrencyIdKey2 = '$CurrencyIdKey2' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWACurrenciesConversion);


            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  id = $IdKey ";
    $objEditView = $objORM->Fetch($SCondition, 'CurrencyIdKey1,CurrencyIdKey2,Rate,Description', TableIWACurrenciesConversion);


    //Currencies 1
    $SCondition = "  IdKey = '$objEditView->CurrencyIdKey1' ";
    $Item = $objORM->Fetch($SCondition, 'Name,id', TableIWACurrencies);
    $strCurrencyIdKey1 = '<option selected value="' . $Item->id . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWACurrencies) as $ListItem) {
        $strCurrencyIdKey1 .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
    }

    //Currencies 2
    $SCondition = "  IdKey = '$objEditView->CurrencyIdKey2' ";
    $Item = $objORM->Fetch($SCondition, 'Name,id', TableIWACurrencies);
    $strCurrencyIdKey2 = '<option selected value="' . $Item->id . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWACurrencies) as $ListItem) {
        $strCurrencyIdKey2 .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
    }



    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        $arrExcept = array('Description' => '');
        if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $Rate = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Rate);
            $CurrencyIdKey1 = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->CurrencyIdKey1);
            $CurrencyIdKey2 = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->CurrencyIdKey2);
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $SCondition = "CurrencyIdKey1 = '$CurrencyIdKey1' AND CurrencyIdKey2 = '$CurrencyIdKey1' and id!= $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWACurrenciesConversion)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {



                $objTimeTools = new TimeTools();
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                
                
                $now_modify = date("Y-m-d H:i:s");
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

                $UCondition = " id = $IdKey ";
                $USet = "";
                $USet .= " Rate = $Rate ,";
                $USet .= " CurrencyIdKey1 = '$CurrencyIdKey1' ,";
                $USet .= " CurrencyIdKey2 = '$CurrencyIdKey2' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                
                
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = $ModifyId ";

                $objORM->DataUpdate($UCondition, $USet, TableIWACurrenciesConversion);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}




