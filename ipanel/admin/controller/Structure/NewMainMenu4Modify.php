<?php
//NewMainMenu4Modify.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
$Enabled = true;

$SCondition = " Enabled = $Enabled ORDER BY id ";


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
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Name,id,LocalName', TableIWNewMenu) as $ListItem) {
    $strNewMenuId .= '<option value="' . $ListItem->id . '">' . $ListItem->LocalName . '</option>';
}

//Menu Sub menu 4 Add
$strApiNameSet = '<option value="" selected></option>';
$SCondition = " 1 ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Name,CatId,iw_product_weight_id,LocalName,IdKey', TableIWWebSub4Menu) as $ListItem) {
    $SCondition = "id = $ListItem->iw_product_weight_id";
    $Weight = 0;
    if (@$objORM->Fetch($SCondition, 'Weight', TableIWWebWeightPrice)->Weight != null)
        $Weight = $objORM->Fetch($SCondition, 'Weight', TableIWWebWeightPrice)->Weight;

    $strApiNameSet .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . ' ( CAT ' . $ListItem->CatId . ' W ' . $Weight . ' )</option>';
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
        $TableDataSub4 = $objORM->Fetch($SCondition, 'Name,CatId,iw_product_weight_id', TableIWWebSub4Menu);

        $Name = $TableDataSub4->Name;
        $iw_product_weight_id = $TableDataSub4->iw_product_weight_id;
        $CatId = $TableDataSub4->CatId;


        $LocalName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->LocalName);
        $GroupIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->GroupIdKey);
        $NewMenuId = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->NewMenuId);
        $NewMenu2Id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->NewMenu2Id);
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);
        $Enabled = true;
        $SCondition = "Name = '$Name' AND LocalName = '$LocalName' AND GroupIdKey = '$GroupIdKey' AND NewMenuId = '$NewMenuId'    ";

        if ($objORM->DataExist($SCondition, TableIWNewMenu4)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            

            

            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));
            $InSet = "";
            
            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " GroupIdKey = '$GroupIdKey' ,";
            $InSet .= " NewMenuId = '$NewMenuId' ,";
            $InSet .= " NewMenu2Id = '$NewMenu2Id' ,";
            $InSet .= " Name = '$Name' ,";
            $InSet .= " CatId = '$CatId' ,";
            $InSet .= " AttributeId = '$AttributeId' ,";
            $InSet .= " iw_product_weight_id = '$iw_product_weight_id' ,";
            $InSet .= " LocalName = '$LocalName' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWNewMenu4);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (!isset($_POST['SubmitApi']) and @$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  id = $IdKey ";
    $objEditView = $objORM->Fetch($SCondition, 'Name,LocalName,GroupIdKey,Description', TableIWNewMenu4);

    //Part Name
    $SCondition = "  IdKey = '$objEditView->GroupIdKey' ";
    $Item = $objORM->Fetch($SCondition, 'Name,id', TableIWNewMenu);
    $strMenuIdKey = '<option selected value="' . $Item->id . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWNewMenu) as $ListItem) {
        $strMenuIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
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

            $SCondition = "( Name = '$Name' AND LocalName = '$LocalName' AND GroupIdKey = '$GroupIdKey' ) and id!= $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWNewMenu4)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {

                $objTimeTools = new TimeTools();
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                
                
                $now_modify = date("Y-m-d H:i:s");
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

                $UCondition = " id = $IdKey ";
                $USet = "";
                $USet .= " GroupIdKey = '$GroupIdKey' ,";
                $USet .= " NewMenuId = '$NewMenuId' ,";
                $USet .= " NewMenu2Id = '$NewMenu2Id' ,";
                $USet .= " Name = '$Name' ,";
                $USet .= " LocalName = '$LocalName' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                
                
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = $ModifyId ";

                $objORM->DataUpdate($UCondition, $USet, TableIWNewMenu4);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}







