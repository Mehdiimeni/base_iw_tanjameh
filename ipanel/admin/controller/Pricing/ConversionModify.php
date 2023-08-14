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
$list_currencies_id1 = '';
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWACurrencies) as $ListItem) {
    $list_currencies_id1 .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
}

//Currencies 2
$list_currencies_id2 = '';
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWACurrencies) as $ListItem) {
    $list_currencies_id2 .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
}

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    $arrExcept = array('Description' => '');
    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {



        $Rate = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Rate);
        $iw_currencies_id1 = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_currencies_id1);
        $iw_currencies_id2 = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_currencies_id2);
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);


        $Enabled = true;
        $SCondition = " iw_currencies_id1 = '$iw_currencies_id1' AND iw_currencies_id2 = '$iw_currencies_id1' ";

        if ($objORM->DataExist($SCondition, TableIWACurrenciesConversion)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            

            

            $now_modify = date("Y-m-d H:i:s");
            $modify_id = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

            $InSet = "";
            
            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " Rate = $Rate ,";
            $InSet .= " iw_currencies_id1 = '$iw_currencies_id1' ,";
            $InSet .= " iw_currencies_id2 = '$iw_currencies_id2' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $modify_id ";

            $objORM->DataAdd($InSet, TableIWACurrenciesConversion);


            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $id = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  id = $id ";
    $objEditView = $objORM->Fetch($SCondition, 'iw_currencies_id1,iw_currencies_id2,Rate,Description', TableIWACurrenciesConversion);


    //Currencies 1
    $SCondition = "  id = '$objEditView->iw_currencies_id1' ";
    $Item = $objORM->Fetch($SCondition, 'Name,id', TableIWACurrencies);
    $list_currencies_id1 = '<option selected value="' . $Item->id . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWACurrencies) as $ListItem) {
        $list_currencies_id1 .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
    }

    //Currencies 2
    $SCondition = "  id = '$objEditView->iw_currencies_id2' ";
    $Item = $objORM->Fetch($SCondition, 'Name,id', TableIWACurrencies);
    $list_currencies_id2 = '<option selected value="' . $Item->id . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWACurrencies) as $ListItem) {
        $list_currencies_id2 .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
    }



    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        $arrExcept = array('Description' => '');
        if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $Rate = (float)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Rate);
            $iw_currencies_id1 = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_currencies_id1);
            $iw_currencies_id2 = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_currencies_id2);
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $SCondition = "iw_currencies_id1 = '$iw_currencies_id1' AND iw_currencies_id2 = '$iw_currencies_id1' and id!= $id  ";

            if ($objORM->DataExist($SCondition, TableIWACurrenciesConversion)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {



                $objTimeTools = new TimeTools();
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                
                
                $now_modify = date("Y-m-d H:i:s");
                $modify_id = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

                $UCondition = " id = $id ";
                $USet = "";
                $USet .= " Rate = $Rate ,";
                $USet .= " iw_currencies_id1 = '$iw_currencies_id1' ,";
                $USet .= " iw_currencies_id2 = '$iw_currencies_id2' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                
                
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = $modify_id ";

                $objORM->DataUpdate($UCondition, $USet, TableIWACurrenciesConversion);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}




