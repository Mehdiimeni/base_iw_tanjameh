<?php
//NewMainMenu4Modify.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$Enabled = BoolEnum::BOOL_TRUE();

$SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";


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
//Menu Name
$strNewMenuId = '<option value="" selected></option>';
$SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";
foreach ($objORM->FetchAll($SCondition, 'Name,IdKey,LocalName', TableIWNewMenu) as $ListItem) {
    $strNewMenuId .= '<option value="' . $ListItem->IdKey . '">' . $ListItem->LocalName . '</option>';
}

//Menu Sub menu 4 Add
$strApiNameSet = '<option value="" selected></option>';
$SCondition = " 1 ORDER BY IdRow ";
foreach ($objORM->FetchAll($SCondition, 'Name,CatId,WeightIdKey,LocalName,IdKey', TableIWWebSub4Menu) as $ListItem) {
    $SCondition = "IdKey = '$ListItem->WeightIdKey'";
    $Weight = 0;
    if (@$objORM->Fetch($SCondition, 'Weight', TableIWWebWeightPrice)->Weight != null)
        $Weight = $objORM->Fetch($SCondition, 'Weight', TableIWWebWeightPrice)->Weight;

    $strApiNameSet .= '<option value="' . $ListItem->IdKey . '">' . $ListItem->Name . ' ( CAT ' . $ListItem->CatId . ' W ' . $Weight . ' )</option>';
}


// Category
$strPCategory = '<option value=""></option>';
if (isset($_GET['PCategory']))
    $strPCategory .= '<option selected value="' . $_GET['PCategory'] . '">' . $_GET['PCategory'] . '</option>';


if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    $arrExcept = array('Description' => '');
    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $ArrName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->ArrName);
        $SCondition = "  IdKey = '$ArrName' ";
        $TableDataSub4 = $objORM->Fetch($SCondition, 'Name,CatId,WeightIdKey', TableIWWebSub4Menu);

        $Name = $TableDataSub4->Name;
        $WeightIdKey = $TableDataSub4->WeightIdKey;
        $CatId = $TableDataSub4->CatId;


        $LocalName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->LocalName);
        $GroupIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->GroupIdKey);
        $NewMenuId = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->NewMenuId);
        $NewMenu2Id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->NewMenu2Id);
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);
        $Enabled = BoolEnum::BOOL_TRUE();
        $SCondition = "Name = '$Name' AND LocalName = '$LocalName' AND GroupIdKey = '$GroupIdKey' AND NewMenuId = '$NewMenuId'    ";

        if ($objORM->DataExist($SCondition, TableIWNewMenu4)) {
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
            $InSet .= " GroupIdKey = '$GroupIdKey' ,";
            $InSet .= " NewMenuId = '$NewMenuId' ,";
            $InSet .= " NewMenu2Id = '$NewMenu2Id' ,";
            $InSet .= " Name = '$Name' ,";
            $InSet .= " CatId = '$CatId' ,";
            $InSet .= " AttributeId = '$AttributeId' ,";
            $InSet .= " WeightIdKey = '$WeightIdKey' ,";
            $InSet .= " LocalName = '$LocalName' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " ModifyIP = '$ModifyIP' ,";
            $InSet .= " ModifyTime = '$ModifyTime' ,";
            $InSet .= " ModifyDate = '$ModifyDate' ,";
            $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $InSet .= " ModifyId = '$ModifyId' ";

            $objORM->DataAdd($InSet, TableIWNewMenu4);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (!isset($_POST['SubmitApi']) and @$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  IdKey = '$IdKey' ";
    $objEditView = $objORM->Fetch($SCondition, 'Name,LocalName,GroupIdKey,Description', TableIWNewMenu4);

    //Part Name
    $SCondition = "  IdKey = '$objEditView->GroupIdKey' ";
    $Item = $objORM->Fetch($SCondition, 'Name,IdKey', TableIWNewMenu);
    $strMenuIdKey = '<option selected value="' . $Item->IdKey . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";
    foreach ($objORM->FetchAll($SCondition, 'Name,IdKey', TableIWNewMenu) as $ListItem) {
        $strMenuIdKey .= '<option value="' . $ListItem->IdKey . '">' . $ListItem->Name . '</option>';
    }


    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();
        $arrExcept = array('Description' => '');
        if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
            $LocalName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->LocalName);
            $GroupIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->GroupIdKey);
            $NewMenuId = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->NewMenuId);
            $NewMenu2Id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->NewMenu2Id);
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $SCondition = "( Name = '$Name' AND LocalName = '$LocalName' AND GroupIdKey = '$GroupIdKey' ) and IdKey != '$IdKey'  ";

            if ($objORM->DataExist($SCondition, TableIWNewMenu4)) {
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
                $USet .= " GroupIdKey = '$GroupIdKey' ,";
                $USet .= " NewMenuId = '$NewMenuId' ,";
                $USet .= " NewMenu2Id = '$NewMenu2Id' ,";
                $USet .= " Name = '$Name' ,";
                $USet .= " LocalName = '$LocalName' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " ModifyIP = '$ModifyIP' ,";
                $USet .= " ModifyTime = '$ModifyTime' ,";
                $USet .= " ModifyDate = '$ModifyDate' ,";
                $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
                $USet .= " ModifyId = '$ModifyId' ";

                $objORM->DataUpdate($UCondition, $USet, TableIWNewMenu4);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}







