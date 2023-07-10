<?php
//Sub2MenuModify.php

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
$strMenuIdKey = '';
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWWebSubMenu) as $ListItem) {
    $strMenuIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
}

// Weight
$strWeightIdKey = '';
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Weight,IdKey', TableIWWebWeightPrice) as $ListItem) {
    $strWeightIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->Weight . '</option>';
}

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    $arrExcept = array('Description' => '', 'iw_product_weight_id' => '');
    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
        $LocalName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->LocalName);
        $GroupIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->GroupIdKey);
        $iw_product_weight_id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_product_weight_id);

        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);
        $Enabled = true;
        $SCondition = "Name = '$Name' AND GroupIdKey = '$GroupIdKey'    ";

        if ($objORM->DataExist($SCondition, TableIWWebSub2Menu)) {
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
            $InSet .= " Name = '$Name' ,";
            $InSet .= " LocalName = '$LocalName' ,";
            $InSet .= " iw_product_weight_id = '$iw_product_weight_id' ,";

            $InSet .= " Description = '$Description' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWWebSub2Menu);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (!isset($_POST['SubmitApi']) and @$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  id = $IdKey ";
    $objEditView = $objORM->Fetch($SCondition, 'Name,LocalName,GroupIdKey,iw_product_weight_id,Description', TableIWWebSub2Menu);

    //Part Name
    $SCondition = "  IdKey = '$objEditView->GroupIdKey' ";
    $Item = $objORM->Fetch($SCondition, 'Name,id', TableIWWebSubMenu);
    $strMenuIdKey = '<option selected value="' . $Item->id . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWWebSubMenu) as $ListItem) {
        $strMenuIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
    }

    //Weight
    $SCondition = "  IdKey = '$objEditView->iw_product_weight_id' ";
    $Item = $objORM->Fetch($SCondition, 'Weight,IdKey', TableIWWebWeightPrice);
    $strWeightIdKey = '<option selected value="' . @$Item->id . '">' . @$Item->Weight . '</option>';
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'Weight,IdKey', TableIWWebWeightPrice) as $ListItem) {
        $strWeightIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->Weight . '</option>';
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
            $iw_product_weight_id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_product_weight_id);
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $SCondition = "( Name = '$Name' AND GroupIdKey = '$GroupIdKey' ) and id!= $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWWebSub2Menu)) {
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
                $USet .= " Name = '$Name' ,";
                $USet .= " LocalName = '$LocalName' ,";
                $USet .= " iw_product_weight_id = '$iw_product_weight_id' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                
                
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = $ModifyId ";

                $objORM->DataUpdate($UCondition, $USet, TableIWWebSub2Menu);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}




