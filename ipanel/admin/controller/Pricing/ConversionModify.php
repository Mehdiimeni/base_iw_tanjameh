<?php
//ConversionModify.php

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


//Currencies 1
$strCurrencyIdKey1 = '';
$SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";
foreach ($objORM->FetchAll($SCondition, 'Name,IdKey', TableIWACurrencies) as $ListItem) {
    $strCurrencyIdKey1 .= '<option value="' . $ListItem->IdKey . '">' . $ListItem->Name . '</option>';
}

//Currencies 2
$strCurrencyIdKey2 = '';
$SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";
foreach ($objORM->FetchAll($SCondition, 'Name,IdKey', TableIWACurrencies) as $ListItem) {
    $strCurrencyIdKey2 .= '<option value="' . $ListItem->IdKey . '">' . $ListItem->Name . '</option>';
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


        $Enabled = BoolEnum::BOOL_TRUE();
        $SCondition = " CurrencyIdKey1 = '$CurrencyIdKey1' AND CurrencyIdKey2 = '$CurrencyIdKey1' ";

        if ($objORM->DataExist($SCondition, TableIWACurrenciesConversion)) {
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
            $InSet .= " Rate = $Rate ,";
            $InSet .= " CurrencyIdKey1 = '$CurrencyIdKey1' ,";
            $InSet .= " CurrencyIdKey2 = '$CurrencyIdKey2' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " ModifyIP = '$ModifyIP' ,";
            $InSet .= " ModifyTime = '$ModifyTime' ,";
            $InSet .= " ModifyDate = '$ModifyDate' ,";
            $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $InSet .= " ModifyId = '$ModifyId' ";

            $objORM->DataAdd($InSet, TableIWACurrenciesConversion);


            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  IdKey = '$IdKey' ";
    $objEditView = $objORM->Fetch($SCondition, 'CurrencyIdKey1,CurrencyIdKey2,Rate,Description', TableIWACurrenciesConversion);


    //Currencies 1
    $SCondition = "  IdKey = '$objEditView->CurrencyIdKey1' ";
    $Item = $objORM->Fetch($SCondition, 'Name,IdKey', TableIWACurrencies);
    $strCurrencyIdKey1 = '<option selected value="' . $Item->IdKey . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";
    foreach ($objORM->FetchAll($SCondition, 'Name,IdKey', TableIWACurrencies) as $ListItem) {
        $strCurrencyIdKey1 .= '<option value="' . $ListItem->IdKey . '">' . $ListItem->Name . '</option>';
    }

    //Currencies 2
    $SCondition = "  IdKey = '$objEditView->CurrencyIdKey2' ";
    $Item = $objORM->Fetch($SCondition, 'Name,IdKey', TableIWACurrencies);
    $strCurrencyIdKey2 = '<option selected value="' . $Item->IdKey . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";
    foreach ($objORM->FetchAll($SCondition, 'Name,IdKey', TableIWACurrencies) as $ListItem) {
        $strCurrencyIdKey2 .= '<option value="' . $ListItem->IdKey . '">' . $ListItem->Name . '</option>';
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

            $SCondition = "CurrencyIdKey1 = '$CurrencyIdKey1' AND CurrencyIdKey2 = '$CurrencyIdKey1' and IdKey != '$IdKey'  ";

            if ($objORM->DataExist($SCondition, TableIWACurrenciesConversion)) {
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
                $USet .= " Rate = $Rate ,";
                $USet .= " CurrencyIdKey1 = '$CurrencyIdKey1' ,";
                $USet .= " CurrencyIdKey2 = '$CurrencyIdKey2' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " ModifyIP = '$ModifyIP' ,";
                $USet .= " ModifyTime = '$ModifyTime' ,";
                $USet .= " ModifyDate = '$ModifyDate' ,";
                $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
                $USet .= " ModifyId = '$ModifyId' ";

                $objORM->DataUpdate($UCondition, $USet, TableIWACurrenciesConversion);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}




